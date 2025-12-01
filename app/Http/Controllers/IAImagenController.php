<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI;

class IAImagenController extends Controller
{
    /**
     * Generar imagen con IA basada en la descripción del producto personalizado
     * Soporta generación solo con texto O con texto + imagen de referencia
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generarImagenIA(Request $request)
    {
        try {
            // Validar que la API KEY esté configurada
            $apiKey = env('OPENAI_API_KEY');
            if (!$apiKey) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'API KEY de OpenAI no configurada. Por favor, configura OPENAI_API_KEY en tu archivo .env'
                ], 500);
            }

            // Inicializar cliente OpenAI
            $client = OpenAI::client($apiKey);

            // ===================================================
            // ESCENARIO A: Cliente subió imagen de referencia
            // Usamos GPT-4o Vision para analizar la imagen y generar prompt mejorado
            // ===================================================
            $imagenReferenciaBase64 = null;
            $promptMejorado = null;

            // Verificar si hay imagen de referencia
            $tieneImagenReferencia = $request->hasFile('imagen_referencia') 
                && $request->file('imagen_referencia')->isValid();

            Log::info('Generación IA iniciada', [
                'tiene_imagen' => $tieneImagenReferencia,
                'descripcion' => $request->descripcion,
                'tamano' => $request->tamano,
                'sabor' => $request->sabor
            ]);

            if ($tieneImagenReferencia) {
                
                try {
                    // Procesar imagen de referencia
                    $imagenFile = $request->file('imagen_referencia');
                    $mimeType = $imagenFile->getMimeType();
                    
                    // Validar tipo de imagen
                    $tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                    if (!in_array($mimeType, $tiposPermitidos)) {
                        throw new \Exception('Tipo de imagen no soportado. Usa JPG, PNG o WebP.');
                    }

                    // Validar tamaño (máx 20MB)
                    if ($imagenFile->getSize() > 20 * 1024 * 1024) {
                        throw new \Exception('La imagen es demasiado grande. Máximo 20MB.');
                    }

                    $imageContent = file_get_contents($imagenFile->getRealPath());
                    $imagenReferenciaBase64 = base64_encode($imageContent);

                    Log::info('Imagen procesada', [
                        'mime_type' => $mimeType,
                        'size_kb' => round($imagenFile->getSize() / 1024, 2)
                    ]);

                    // ===================================================
                    // OPCIÓN A: ULTRA PRECISO
                    // Imagen de referencia = Prioridad absoluta
                    // Descripción del usuario = Complemento secundario
                    // ===================================================

                    // Construir contexto complementario del cliente (solo detalles secundarios)
                    $contextoCliente = "";
                    
                    if ($request->tamano) {
                        $contextoCliente .= "Requested size: " . $request->tamano . ". ";
                    }
                    
                    if ($request->sabor) {
                        $contextoCliente .= "Flavor preference: " . $request->sabor . ". ";
                    }
                    
                    if ($request->ocasion) {
                        $contextoCliente .= "Occasion: " . $request->ocasion . ". ";
                    }
                    
                    if ($request->descripcion) {
                        $contextoCliente .= "Additional context: " . $request->descripcion . ". ";
                    }
                    
                    if ($request->notas_adicionales) {
                        $contextoCliente .= "Special notes: " . $request->notas_adicionales . ". ";
                    }

                    // Si no hay contexto del cliente, indicarlo
                    if (empty($contextoCliente)) {
                        $contextoCliente = "No additional customer specifications provided.";
                    }

                    Log::info('Analizando imagen con GPT-4o Vision (ULTRA PRECISO)...');

                    // Usar GPT-4o Vision con prompt ULTRA PRECISO
                    $visionResponse = $client->chat()->create([
                        'model' => 'gpt-4o',
                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => 'You are an expert visual analyzer for cake design. Your primary task is to PRIORITIZE the reference image as the main visual source. 

CRITICAL INSTRUCTIONS:
1. Use the reference image as the PRIMARY visual foundation
2. Preserve and prioritize: colors, theme, style, palette, composition, and visual characteristics from the image
3. DO NOT replicate characters or recognizable figures exactly - reinterpret their style to avoid direct matches while maintaining the visual essence, dominant colors, and design energy
4. Customer description is SECONDARY - use it only for minor complementary details or context
5. Generate a DALL-E prompt that creates a customized cake directly inspired by the visual elements of the reference image

Keep your DALL-E prompt detailed and focused on visual accuracy (max 500 characters).'
                            ],
                            [
                                'role' => 'user',
                                'content' => [
                                    [
                                        'type' => 'text',
                                        'text' => "ANALYZE this reference image carefully and create a DALL-E prompt for D'Nokali bakery.\n\n"
                                            . "PRIORITY: The reference image is the MAIN visual source. Capture its colors, style, composition, theme, and energy.\n\n"
                                            . "Customer context (secondary/complementary only): " . $contextoCliente . "\n\n"
                                            . "Generate a detailed DALL-E prompt that produces a cake heavily inspired by the reference image's visual characteristics, "
                                            . "while subtly incorporating any relevant customer preferences as minor details. "
                                            . "Focus on visual fidelity to the reference image above all else."
                                    ],
                                    [
                                        'type' => 'image_url',
                                        'image_url' => [
                                            'url' => "data:{$mimeType};base64,{$imagenReferenciaBase64}",
                                            'detail' => 'high'
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'max_tokens' => 400,
                        'temperature' => 0.5  // Reducido para mayor precisión y consistencia
                    ]);

                    $promptMejorado = trim($visionResponse->choices[0]->message->content);
                    
                    Log::info('Prompt ULTRA PRECISO generado con Vision', ['prompt' => $promptMejorado]);

                } catch (\Exception $e) {
                    // Si falla el análisis de imagen, usar solo texto
                    Log::warning('Error al analizar imagen, usando solo texto: ' . $e->getMessage());
                    $tieneImagenReferencia = false;
                    $imagenReferenciaBase64 = null;
                }
            }
            
            if (!$tieneImagenReferencia || !$promptMejorado) {
                // ===================================================
                // ESCENARIO B: Sin imagen de referencia (solo texto)
                // Usamos el prompt original basado en texto
                // ===================================================
                Log::info('Generando con solo texto (sin imagen)');
                
                $promptMejorado = "A beautifully decorated cake for D'Nokali bakery with the following specifications: ";
                
                if ($request->descripcion) {
                    $promptMejorado .= "Description: " . $request->descripcion . ". ";
                }
                
                if ($request->tamano) {
                    $promptMejorado .= "Size: " . $request->tamano . ". ";
                }
                
                if ($request->sabor) {
                    $promptMejorado .= "Flavor: " . $request->sabor . ". ";
                }
                
                if ($request->ocasion) {
                    $promptMejorado .= "Occasion: " . $request->ocasion . ". ";
                }
                
                if ($request->notas_adicionales) {
                    $promptMejorado .= "Additional notes: " . $request->notas_adicionales . ". ";
                }

                $promptMejorado .= "Style: professional photography, clean background, soft pastel colors, warm lighting, elegant presentation, high quality bakery product shot.";
            }

            Log::info('Generando imagen con DALL-E 3...');

            // ===================================================
            // Generar imagen final con DALL-E 3
            // ===================================================
            $response = $client->images()->create([
                'model' => 'dall-e-3',
                'prompt' => $promptMejorado,
                'size' => '1024x1024',
                'quality' => 'standard',
                'response_format' => 'b64_json',
                'n' => 1,
            ]);

            // Extraer imagen en base64
            $base64Image = $response->data[0]->b64_json;
            $imageData = base64_decode($base64Image);

            // Crear directorio si no existe
            $directorio = storage_path('app/public/personalizados-ia');
            if (!is_dir($directorio)) {
                mkdir($directorio, 0755, true);
            }

            // Guardar imagen con nombre único
            $fileName = 'torta_ia_' . time() . '_' . uniqid() . '.png';
            $filePath = $directorio . '/' . $fileName;
            file_put_contents($filePath, $imageData);

            Log::info('Imagen guardada exitosamente', ['file' => $fileName]);

            // Retornar respuesta exitosa con la URL pública de la imagen
            return response()->json([
                'status' => 'ok',
                'message' => 'Imagen generada exitosamente',
                'image_url' => asset('storage/personalizados-ia/' . $fileName),
                'prompt_usado' => $promptMejorado,
                'uso_imagen_referencia' => $imagenReferenciaBase64 !== null
            ]);

        } catch (\OpenAI\Exceptions\ErrorException $e) {
            // Errores específicos de OpenAI (cuota excedida, API key inválida, etc.)
            Log::error('Error de OpenAI en generación IA', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error de OpenAI: ' . $e->getMessage(),
                'tipo' => 'openai_error'
            ], 500);

        } catch (\Exception $e) {
            // Otros errores generales
            Log::error('Error general en generación IA', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al generar la imagen: ' . $e->getMessage(),
                'tipo' => 'general_error'
            ], 500);
        }
    }
}


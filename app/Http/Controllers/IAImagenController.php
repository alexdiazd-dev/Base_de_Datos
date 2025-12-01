<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class IAImagenController extends Controller
{
    /**
     * Generar imagen con IA basada en la descripción del producto personalizado
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

            // Construir el prompt detallado combinando los datos del formulario
            $prompt = "A beautifully decorated cake for D'Nokali bakery with the following specifications: ";
            
            if ($request->descripcion) {
                $prompt .= "Description: " . $request->descripcion . ". ";
            }
            
            if ($request->tamano) {
                $prompt .= "Size: " . $request->tamano . ". ";
            }
            
            if ($request->sabor) {
                $prompt .= "Flavor: " . $request->sabor . ". ";
            }
            
            if ($request->ocasion) {
                $prompt .= "Occasion: " . $request->ocasion . ". ";
            }
            
            if ($request->notas_adicionales) {
                $prompt .= "Additional notes: " . $request->notas_adicionales . ". ";
            }

            $prompt .= "Style: professional photography, clean background, soft pastel colors, warm lighting, elegant presentation, high quality bakery product shot.";

            // Generar imagen usando DALL-E 3
            $response = $client->images()->create([
                'model' => 'dall-e-3',
                'prompt' => $prompt,
                'size' => '1024x1024',
                'quality' => 'standard', // 'standard' o 'hd'
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

            // Retornar respuesta exitosa con la URL pública de la imagen
            return response()->json([
                'status' => 'ok',
                'message' => 'Imagen generada exitosamente',
                'image_url' => asset('storage/personalizados-ia/' . $fileName),
                'prompt_usado' => $prompt // Útil para debugging
            ]);

        } catch (\OpenAI\Exceptions\ErrorException $e) {
            // Errores específicos de OpenAI (cuota excedida, API key inválida, etc.)
            return response()->json([
                'status' => 'error',
                'message' => 'Error de OpenAI: ' . $e->getMessage(),
                'tipo' => 'openai_error'
            ], 500);

        } catch (\Exception $e) {
            // Otros errores generales
            return response()->json([
                'status' => 'error',
                'message' => 'Error al generar la imagen: ' . $e->getMessage(),
                'tipo' => 'general_error'
            ], 500);
        }
    }
}


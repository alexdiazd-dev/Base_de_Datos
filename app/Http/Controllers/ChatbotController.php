<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use OpenAI;

class ChatbotController extends Controller
{
    /**
     * Procesar mensaje del usuario y devolver respuesta del chatbot Nokalito
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function responder(Request $request)
    {
        try {
            // Validar que el mensaje exista
            $mensajeUsuario = $request->input('mensaje');
            if (!$mensajeUsuario || trim($mensajeUsuario) === '') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Por favor, escribe un mensaje.'
                ], 400);
            }

            // Validar que la API KEY esté configurada
            $apiKey = env('OPENAI_API_KEY');
            if (!$apiKey) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Nokalito no está disponible en este momento. Por favor, intenta más tarde.'
                ]);
            }

            // Inicializar cliente OpenAI
            $client = OpenAI::client($apiKey);

            // =====================================================
            // LEER ARCHIVO DE CONTEXTO INTERNO
            // =====================================================
            $rutaContexto = 'nokalito/contexto.txt';
            
            if (!Storage::exists($rutaContexto)) {
                Log::error('Archivo de contexto no encontrado: ' . $rutaContexto);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Nokalito no está disponible en este momento. Por favor, intenta más tarde.'
                ]);
            }

            $contenidoContexto = Storage::get($rutaContexto);

            // =====================================================
            // SYSTEM PROMPT FIJO + CONTEXTO
            // =====================================================
            $systemPrompt = "
                Eres Nokalito, asistente virtual oficial de la pastelería D’Nokali.

                REGLAS:
                1. Siempre responde de manera amable y conversacional.
                2. Para saludos o frases casuales (hola, jhola, cómo estás, etc.), responde con un saludo natural.
                3. Para información del negocio, usa únicamente los datos del archivo de contexto.
                4. Si el usuario pregunta algo que NO está en el contexto, responde de manera útil, educada y natural. 
                Indica que esa información no está registrada, pero ofrece alternativas basadas en el contexto.
                Ejemplo:
                “No contamos con ese dato exacto, pero sí disponemos de estos sabores: …”

                5. Puedes corregir errores ortográficos leves.
                6. No inventes datos del negocio que no existan en el contexto.

                FORMATO DE RESPUESTA (OBLIGATORIO):
                - NO uses Markdown (**negritas**, *, #, etc.).
                - NO escribas todo en un solo párrafo.
                - Cada producto debe ir EXACTAMENTE así:
                Nombre — S/ precio (Stock: X)
                - Cada producto en SU PROPIA LÍNEA.
                - Entre secciones debe haber una LÍNEA EN BLANCO.
                - No juntar textos ni pegar productos seguidos.
                - Mantén el texto limpio, ordenado y fácil de leer en un chat pequeño.

                EJEMPLO DEL FORMATO ESPERADO:
                Producto 1 — S/ xx.xx (Stock: X)
                Producto 2 — S/ xx.xx (Stock: X)
                Producto 3 — S/ xx.xx (Stock: X)

                --- INFORMACIÓN DE CONTEXTO ---
                $contenidoContexto
            ";



            // Generar respuesta usando GPT-4o-mini (modelo económico y rápido)
            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $mensajeUsuario
                    ]
                ],
                'max_tokens' => 300,  // Aumentado para respuestas más completas basadas en contexto
                'temperature' => 0.3,  // Reducido para mayor precisión y menos creatividad
            ]);

            // Extraer la respuesta del chatbot
            $respuestaNokalito = $response->choices[0]->message->content;

            // Retornar respuesta exitosa
            return response()->json([
                'status' => 'success',
                'message' => trim($respuestaNokalito),
                'timestamp' => now()->toIso8601String()
            ]);

        } catch (\OpenAI\Exceptions\ErrorException $e) {
            // Errores específicos de OpenAI (cuota excedida, API key inválida, etc.)
            Log::error('Error de OpenAI en chatbot: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Nokalito no está disponible en este momento. Por favor, intenta más tarde.'
            ]);

        } catch (\Exception $e) {
            // Otros errores generales
            Log::error('Error general en chatbot: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Nokalito no está disponible en este momento. Por favor, intenta más tarde.'
            ]);
        }
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

            // Definir el system prompt (personalidad de Nokalito)
            $systemPrompt = "Eres Nokalito, el asistente virtual de D'Nokali, una pastelería premium especializada en productos personalizados. "
                . "Tu personalidad es amable, cálida y profesional. "
                . "Eres experto en tortas, pasteles, productos de repostería y personalización de pedidos. "
                . "Respondes de forma clara, concisa y útil. "
                . "Ayudas a los clientes con información sobre productos, pedidos personalizados, sabores, tamaños, ocasiones especiales y cualquier duda sobre D'Nokali. "
                . "Siempre mantienes un tono dulce y acogedor, como la marca que representas. "
                . "Tus respuestas son breves (máximo 3-4 oraciones) pero muy útiles.";

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
                'max_tokens' => 200,
                'temperature' => 0.7,
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
            \Log::error('Error de OpenAI en chatbot: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Nokalito no está disponible en este momento. Por favor, intenta más tarde.'
            ]);

        } catch (\Exception $e) {
            // Otros errores generales
            \Log::error('Error general en chatbot: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Nokalito no está disponible en este momento. Por favor, intenta más tarde.'
            ]);
        }
    }
}


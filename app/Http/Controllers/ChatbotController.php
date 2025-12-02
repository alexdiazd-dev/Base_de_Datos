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
            $systemPrompt = "Eres Nokalito, el asistente virtual oficial de la pastelería D'Nokali.

Tu función es responder únicamente preguntas relacionadas con:
- Productos de la pastelería
- Tortas personalizadas
- Sabores, tamaños, precios aproximados
- Ocasiones especiales
- Pedidos, entregas y dudas sobre D'Nokali

Si el usuario hace preguntas que NO tengan relación con repostería, comida, pedidos o la pastelería D'Nokali, debes responder SIEMPRE con este mensaje por defecto:

“¡Hola! Soy Nokalito ✨ Solo puedo ayudarte con dudas sobre tortas, postres o pedidos personalizados de D'Nokali. ¿En qué te gustaría que te ayude hoy?”

No respondas preguntas externas, no des consejos, no generes historias ni información fuera del alcance de la pastelería.

Mantén siempre un tono cálido, dulce y profesional. Responde con máximo 3–4 oraciones.";

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


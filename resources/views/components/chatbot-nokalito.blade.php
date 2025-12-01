{{-- 
    Componente Chatbot Nokalito
    Asistente virtual flotante para D'Nokali
--}}

<!-- Botón flotante del chatbot -->
<div id="nokalito-chat-btn" class="nokalito-floating-btn" title="Habla con Nokalito">
    <i class="bi bi-chat-dots-fill"></i>
</div>

<!-- Ventana del chatbot (oculta por defecto) -->
<div id="nokalito-chat-window" class="nokalito-chat-window d-none">
    <div class="nokalito-chat-container">
        
        <!-- Encabezado -->
        <div class="nokalito-chat-header">
            <div class="d-flex align-items-center gap-2">
                <div class="nokalito-avatar">
                    <i class="bi bi-robot"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-semibold">Nokalito</h6>
                    <small class="text-white-50 d-flex align-items-center gap-1">
                        <span class="nokalito-status-dot"></span>
                        En línea
                    </small>
                </div>
            </div>
            <button id="nokalito-close-btn" class="nokalito-close-btn">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- Cuerpo del chat -->
        <div class="nokalito-chat-body" id="nokalito-chat-body">
            <!-- Mensaje de bienvenida -->
            <div class="nokalito-message nokalito-message-bot">
                <div class="nokalito-message-avatar">
                    <i class="bi bi-robot"></i>
                </div>
                <div class="nokalito-message-bubble">
                    <p class="mb-1">¡Hola! Soy <strong>Nokalito</strong>, tu asistente virtual de D'Nokali 🍰</p>
                    <p class="mb-0">¿En qué puedo ayudarte hoy?</p>
                    <small class="nokalito-message-time">Ahora</small>
                </div>
            </div>
        </div>

        <!-- Footer con input -->
        <div class="nokalito-chat-footer">
            <div class="nokalito-input-container">
                <input 
                    type="text" 
                    id="nokalito-input" 
                    class="nokalito-input" 
                    placeholder="Escribe tu mensaje..."
                    autocomplete="off"
                >
                <button id="nokalito-send-btn" class="nokalito-send-btn">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>

    </div>
</div>

<style>
/* ========================================
   ESTILOS DEL CHATBOT NOKALITO
======================================== */

/* Botón flotante */
.nokalito-floating-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #c8a5f0, #9b7bdb);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 28px;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(155, 123, 219, 0.4);
    transition: all 0.3s ease;
    z-index: 9998;
    animation: nokalito-pulse 2s infinite;
}

.nokalito-floating-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(155, 123, 219, 0.6);
}

@keyframes nokalito-pulse {
    0%, 100% {
        box-shadow: 0 4px 15px rgba(155, 123, 219, 0.4);
    }
    50% {
        box-shadow: 0 4px 25px rgba(155, 123, 219, 0.7);
    }
}

/* Ventana del chat */
.nokalito-chat-window {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 380px;
    height: 550px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    overflow: hidden;
    animation: nokalito-slide-up 0.3s ease-out;
}

@keyframes nokalito-slide-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.nokalito-chat-container {
    display: flex;
    flex-direction: column;
    height: 100%;
}

/* Encabezado */
.nokalito-chat-header {
    background: linear-gradient(135deg, #c8a5f0, #9b7bdb);
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nokalito-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.nokalito-status-dot {
    width: 8px;
    height: 8px;
    background: #4ade80;
    border-radius: 50%;
    display: inline-block;
    animation: nokalito-blink 2s infinite;
}

@keyframes nokalito-blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

.nokalito-close-btn {
    background: transparent;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    padding: 5px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.2s;
}

.nokalito-close-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

/* Cuerpo del chat */
.nokalito-chat-body {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: linear-gradient(to bottom, #faf8ff, #ffffff);
}

/* Mensajes */
.nokalito-message {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
    animation: nokalito-fade-in 0.3s ease-out;
}

@keyframes nokalito-fade-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.nokalito-message-bot {
    flex-direction: row;
}

.nokalito-message-user {
    flex-direction: row-reverse;
}

.nokalito-message-avatar {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #e5d9f2, #c8a5f0);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #9b7bdb;
    flex-shrink: 0;
}

.nokalito-message-user .nokalito-message-avatar {
    background: linear-gradient(135deg, #fde8df, #f8d7c9);
    color: #d4916f;
}

.nokalito-message-bubble {
    max-width: 75%;
    padding: 12px 16px;
    border-radius: 16px;
    font-size: 14px;
    line-height: 1.5;
}

.nokalito-message-bot .nokalito-message-bubble {
    background: #f3f0ff;
    color: #4b3c3a;
    border-bottom-left-radius: 4px;
}

.nokalito-message-user .nokalito-message-bubble {
    background: linear-gradient(135deg, #c8a5f0, #9b7bdb);
    color: white;
    border-bottom-right-radius: 4px;
}

.nokalito-message-time {
    display: block;
    font-size: 11px;
    margin-top: 4px;
    opacity: 0.6;
}

/* Footer */
.nokalito-chat-footer {
    padding: 15px 20px;
    background: white;
    border-top: 1px solid #f0f0f0;
}

.nokalito-input-container {
    display: flex;
    gap: 10px;
    align-items: center;
}

.nokalito-input {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #e5d9f2;
    border-radius: 25px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
}

.nokalito-input:focus {
    border-color: #c8a5f0;
}

.nokalito-send-btn {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #c8a5f0, #9b7bdb);
    border: none;
    border-radius: 50%;
    color: white;
    font-size: 18px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
}

.nokalito-send-btn:hover {
    transform: scale(1.1);
}

.nokalito-send-btn:active {
    transform: scale(0.95);
}

/* Responsive */
@media (max-width: 768px) {
    .nokalito-chat-window {
        bottom: 0;
        right: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 0;
    }

    .nokalito-floating-btn {
        bottom: 20px;
        right: 20px;
    }
}

/* Scrollbar personalizado */
.nokalito-chat-body::-webkit-scrollbar {
    width: 6px;
}

.nokalito-chat-body::-webkit-scrollbar-track {
    background: transparent;
}

.nokalito-chat-body::-webkit-scrollbar-thumb {
    background: #e5d9f2;
    border-radius: 10px;
}

.nokalito-chat-body::-webkit-scrollbar-thumb:hover {
    background: #c8a5f0;
}

/* Indicador de escritura */
.nokalito-typing-dots {
    display: flex;
    gap: 4px;
    align-items: center;
    padding: 8px 0;
}

.nokalito-typing-dots span {
    width: 8px;
    height: 8px;
    background: #9b7bdb;
    border-radius: 50%;
    animation: nokalito-typing 1.4s infinite;
}

.nokalito-typing-dots span:nth-child(2) {
    animation-delay: 0.2s;
}

.nokalito-typing-dots span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes nokalito-typing {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.4;
    }
    30% {
        transform: translateY(-10px);
        opacity: 1;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatBtn = document.getElementById('nokalito-chat-btn');
    const chatWindow = document.getElementById('nokalito-chat-window');
    const closeBtn = document.getElementById('nokalito-close-btn');
    const sendBtn = document.getElementById('nokalito-send-btn');
    const input = document.getElementById('nokalito-input');
    const chatBody = document.getElementById('nokalito-chat-body');

    // Abrir/cerrar chat
    if (chatBtn) {
        chatBtn.addEventListener('click', function() {
            chatWindow.classList.toggle('d-none');
            if (!chatWindow.classList.contains('d-none')) {
                input.focus();
            }
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            chatWindow.classList.add('d-none');
        });
    }

    // Enviar mensaje
    async function enviarMensaje() {
        const mensaje = input.value.trim();
        if (!mensaje) return;

        // Deshabilitar input mientras se procesa
        input.disabled = true;
        sendBtn.disabled = true;

        // Agregar mensaje del usuario inmediatamente
        agregarMensajeUsuario(mensaje);
        input.value = '';

        // Mostrar indicador de escritura
        const typingIndicator = mostrarEscribiendo();

        try {
            // Enviar petición al backend
            const response = await fetch('{{ route('chatbot.responder') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    mensaje: mensaje
                })
            });

            const data = await response.json();

            // Remover indicador de escritura
            if (typingIndicator && typingIndicator.parentNode) {
                typingIndicator.remove();
            }

            if (response.ok && data.status === 'success') {
                // Mostrar respuesta del bot
                agregarMensajeBot(data.message);
            } else {
                throw new Error('Error en la respuesta del servidor');
            }

        } catch (error) {
            console.error('Error al comunicarse con Nokalito:', error);
            
            // Remover indicador de escritura si existe
            if (typingIndicator && typingIndicator.parentNode) {
                typingIndicator.remove();
            }
            
            // Mostrar mensaje de error
            agregarMensajeBot('Nokalito no está disponible en este momento. Por favor, intenta más tarde.');
        } finally {
            // Rehabilitar input
            input.disabled = false;
            sendBtn.disabled = false;
            input.focus();
        }
    }

    function mostrarEscribiendo() {
        const typingDiv = document.createElement('div');
        typingDiv.className = 'nokalito-message nokalito-message-bot nokalito-typing-indicator';
        typingDiv.innerHTML = `
            <div class="nokalito-message-avatar">
                <i class="bi bi-robot"></i>
            </div>
            <div class="nokalito-message-bubble">
                <span class="nokalito-typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </div>
        `;
        chatBody.appendChild(typingDiv);
        chatBody.scrollTop = chatBody.scrollHeight;
        return typingDiv;
    }

    function agregarMensajeUsuario(texto) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'nokalito-message nokalito-message-user';
        messageDiv.innerHTML = `
            <div class="nokalito-message-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="nokalito-message-bubble">
                <p class="mb-0">${escapeHtml(texto)}</p>
                <small class="nokalito-message-time">Ahora</small>
            </div>
        `;
        chatBody.appendChild(messageDiv);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function agregarMensajeBot(texto) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'nokalito-message nokalito-message-bot';
        messageDiv.innerHTML = `
            <div class="nokalito-message-avatar">
                <i class="bi bi-robot"></i>
            </div>
            <div class="nokalito-message-bubble">
                <p class="mb-0">${escapeHtml(texto)}</p>
                <small class="nokalito-message-time">Ahora</small>
            </div>
        `;
        chatBody.appendChild(messageDiv);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    if (sendBtn) {
        sendBtn.addEventListener('click', enviarMensaje);
    }

    if (input) {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                enviarMensaje();
            }
        });
    }
});
</script>

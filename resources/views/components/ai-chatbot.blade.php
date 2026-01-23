<!-- AI Support Chatbot Component -->
<div id="ai-support-chatbot" class="ai-chatbot-wrapper" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <!-- Chat Toggle Button -->
    <button id="chat-toggle" class="chat-toggle-btn shadow-lg">
        <div class="pulse-ring"></div>
        <i class="fas fa-robot"></i>
        <span class="notification-dot"></span>
    </button>

    <!-- Chat Window -->
    <div id="chat-window" class="chat-window-container glassmorphism hidden">
        <!-- Chat Header -->
        <div class="chat-header d-flex align-items-center justify-content-between p-3">
            <div class="d-flex align-items-center">
                <div class="bot-avatar mr-2">
                    <i class="fas fa-robot text-white"></i>
                </div>
                <div>
                    <h6 class="text-white mb-0 font-weight-700">GoWa Assistant</h6>
                    <small class="text-white-50"><span class="online-dot"></span> Online</small>
                </div>
            </div>
            <button id="close-chat" class="btn btn-sm btn-link text-white shadow-none p-0">
                <i class="fas fa-times fa-lg"></i>
            </button>
        </div>

        <!-- Chat Body -->
        <div id="chat-body" class="chat-body p-3">
            <div class="message bot-message animate-fade-in">
                Hello! I'm your GoWaSender assistant. How can I help you today? 👋
            </div>
        </div>

        <!-- Chat Footer -->
        <div class="chat-footer p-3 border-top bg-white-5">
            <div class="input-group">
                <input type="text" id="chat-input" class="form-control chat-input-field"
                    placeholder="Ask me anything..." autocomplete="off">
                <div class="input-group-append">
                    <button id="send-btn" class="btn send-message-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .ai-chatbot-wrapper {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
    }

    .chat-toggle-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);
        color: white;
        border: none;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        transition: transform 0.3s ease;
    }

    .chat-toggle-btn:hover {
        transform: scale(1.1);
    }

    .pulse-ring {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 2px solid #16A34A;
        animation: pulse 2s infinite;
        opacity: 0;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 0.5;
        }

        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }

    .notification-dot {
        position: absolute;
        top: 0;
        right: 0;
        width: 12px;
        height: 12px;
        background: #ef4444;
        border-radius: 50%;
        border: 2px solid white;
    }

    .chat-window-container {
        position: absolute;
        bottom: 80px;
        right: 0;
        width: 350px;
        height: 480px;
        display: flex;
        flex-direction: column;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-origin: bottom right;
    }

    .chat-window-container.hidden {
        transform: scale(0);
        opacity: 0;
        pointer-events: none;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .chat-header {
        background: linear-gradient(90deg, #16A34A 0%, #15803D 100%);
    }

    .bot-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .online-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        background: #22c55e;
        border-radius: 50%;
        margin-right: 4px;
        box-shadow: 0 0 5px #22c55e;
    }

    .chat-body {
        flex: 1;
        overflow-y: auto;
        background: rgba(249, 250, 251, 0.5);
    }

    .message {
        max-width: 85%;
        padding: 10px 15px;
        border-radius: 15px;
        margin-bottom: 15px;
        font-size: 14px;
        line-height: 1.5;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .bot-message {
        background: white;
        color: #374151;
        align-self: flex-start;
        border-bottom-left-radius: 2px;
    }

    .user-message {
        background: #16A34A;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 2px;
        margin-left: auto;
    }

    .chat-input-field {
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        padding-left: 15px;
        font-size: 14px;
    }

    .chat-input-field:focus {
        border-color: #16A34A;
        box-shadow: none;
    }

    .send-message-btn {
        background: #16A34A;
        color: white;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 8px;
        padding: 0;
    }

    .send-message-btn:hover {
        background: #15803D;
        color: white;
    }

    .typing-indicator {
        font-style: italic;
        color: #9ca3af;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .animate-fade-in {
        animation: fadeIn 0.4s ease forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('chat-toggle');
        const chatWindow = document.getElementById('chat-window');
        const closeBtn = document.getElementById('close-chat');
        const sendBtn = document.getElementById('send-btn');
        const chatInput = document.getElementById('chat-input');
        const chatBody = document.getElementById('chat-body');

        // Toggle Chat
        toggleBtn.addEventListener('click', () => {
            chatWindow.classList.toggle('hidden');
            if (!chatWindow.classList.contains('hidden')) {
                chatInput.focus();
                document.querySelector('.notification-dot').style.display = 'none';
            }
        });

        closeBtn.addEventListener('click', () => {
            chatWindow.classList.add('hidden');
        });

        // Send Message
        const sendMessage = () => {
            const text = chatInput.value.trim();
            if (!text) return;

            addMessage(text, 'user');
            chatInput.value = '';

            // AI Response Logic
            showTypingIndicator();
            setTimeout(() => {
                removeTypingIndicator();
                const response = getAIResponse(text);
                addMessage(response, 'bot');
            }, 1000 + Math.random() * 2000);
        };

        sendBtn.addEventListener('click', sendMessage);
        chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });

        function addMessage(text, type) {
            const msgDiv = document.createElement('div');
            msgDiv.className = `message ${type}-message animate-fade-in`;
            msgDiv.innerText = text;
            chatBody.appendChild(msgDiv);
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        function showTypingIndicator() {
            const indicator = document.createElement('div');
            indicator.id = 'typing-indicator';
            indicator.className = 'typing-indicator px-2';
            indicator.innerText = 'GoWa Assistant is thinking...';
            chatBody.appendChild(indicator);
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        function removeTypingIndicator() {
            const indicator = document.getElementById('typing-indicator');
            if (indicator) indicator.remove();
        }

        function getAIResponse(input) {
            const query = input.toLowerCase();

            if (query.includes('hello') || query.includes('hi')) return "Hello! I'm here to help you automate your WhatsApp communications. What's on your mind?";
            if (query.includes('device') || query.includes('connect')) return "To connect a device, go to 'Devices' in your dashboard and follow the Cloud API setup. It's fast and secure!";
            if (query.includes('bulk')) return "Our Bulk Sending feature allows you to reach thousands of customers. You can find it under the 'Bulk Sending' menu.";
            if (query.includes('price') || query.includes('plan') || query.includes('cost')) return "We have flexible plans for every business size. Check our 'Subscription' page for details!";
            if (query.includes('flow') || query.includes('automate')) return "Automation Flows let you build interactive chatbots. Head over to 'User Flows' to start building!";
            if (query.includes('support') || query.includes('help')) return "I'm doing my best! But if you need a human, you can open a ticket in the 'Support' section.";

            return "That's a great question! I'm still learning, but you can find detailed guides in our documentation or tutorials. How else can I assist you?";
        }
    });
</script>
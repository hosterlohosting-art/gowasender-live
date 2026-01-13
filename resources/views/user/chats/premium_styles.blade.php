<style>
    /* --- PREMIUM WHATSAPP DARK THEME --- */
    :root {
        --wa-dark-bg: #0b141a;
        /* Main Background (behind doodles) */
        --wa-dark-sidebar: #111b21;
        /* Sidebar & Headers */
        --wa-dark-hover: #202c33;
        /* Hover State / Search Bar */
        --wa-dark-border: #222d36;
        /* Borders */
        --wa-green-sent: #005c4b;
        /* Sent Bubble */
        --wa-incoming: #202c33;
        /* Incoming Bubble */
        --wa-primary: #00a884;
        /* Green Accents */
        --wa-text-main: #e9edef;
        /* Primary Text */
        --wa-text-sub: #8696a0;
        /* Secondary Text */
        --wa-input-bg: #2a3942;
        /* Input Fields */
    }

    /* Base Override */
    body {
        background-color: #090e11 !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
        color: var(--wa-text-main);
    }

    .layout-px-spacing {
        padding: 0 !important;
        /* Full width */
    }

    /* Chat Container */
    .chat-container {
        height: calc(100vh - 80px) !important;
        background-color: var(--wa-dark-bg);
        border: 1px solid var(--wa-dark-border);
        border-radius: 0 !important;
        display: flex;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
    }

    /* --- SIDEBAR --- */
    .user-container {
        width: 350px !important;
        background-color: var(--wa-dark-sidebar);
        border-right: 1px solid var(--wa-dark-border);
        display: flex;
        flex-direction: column;
    }

    .own-details {
        padding: 10px 16px;
        background-color: var(--wa-dark-sidebar);
        border-bottom: 1px solid var(--wa-dark-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 60px;
    }

    .own-details img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .search {
        padding: 10px;
        background-color: var(--wa-dark-sidebar);
        border-bottom: 1px solid var(--wa-dark-border);
    }

    .search input {
        background-color: var(--wa-dark-hover);
        border: none;
        border-radius: 8px;
        padding: 7px 15px 7px 35px;
        /* Space for icon */
        color: var(--wa-text-main);
        width: 100%;
    }

    .search input::placeholder {
        color: var(--wa-text-sub);
    }

    .people {
        flex: 1;
        overflow-y: auto;
        background-color: var(--wa-dark-sidebar);
    }

    .person {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        border-bottom: 1px solid var(--wa-dark-border);
        cursor: pointer;
        transition: background 0.2s;
    }

    .person:hover,
    .person.active {
        background-color: var(--wa-dark-hover);
    }

    .person .user-info {
        margin-left: 15px;
        flex: 1;
    }

    .person .user-info h5 {
        font-size: 16px;
        color: var(--wa-text-main);
        margin: 0;
        font-weight: 500;
    }

    .person .user-info p {
        font-size: 13px;
        color: var(--wa-text-sub);
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 180px;
    }

    /* --- MAIN CHAT AREA --- */
    .chat-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        background-color: var(--wa-dark-bg);
        position: relative;
        background-image: url('{{ asset("assets/img/whatsapp-bg.png") }}');
        /* Doodle BG */
        background-blend-mode: overlay;
        background-repeat: repeat;
        background-size: 400px;
    }

    /* Chat Header */
    .chat-details-header {
        height: 60px;
        background-color: var(--wa-dark-sidebar);
        padding: 0 16px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid var(--wa-dark-border);
        z-index: 10;
    }

    .chat-with {
        flex: 1;
    }

    .chat-with-name {
        color: var(--wa-text-main);
        font-size: 16px;
        font-weight: 600;
        margin: 0;
    }

    .chat-with-options i {
        color: var(--wa-text-sub);
        font-size: 18px;
        margin-left: 20px;
        cursor: pointer;
    }

    /* Chat Messages Area */
    .chatting-container {
        flex: 1;
        overflow-y: auto;
        padding: 20px 50px;
        /* Wider padding for premium feel */
        display: flex;
        flex-direction: column;
    }

    .bubble {
        max-width: 65%;
        padding: 8px 12px;
        border-radius: 8px;
        margin-bottom: 8px;
        position: relative;
        font-size: 14.2px;
        line-height: 19px;
        box-shadow: 0 1px 0.5px rgba(0, 0, 0, 0.13);
    }

    .bubble.me {
        align-self: flex-end;
        background-color: var(--wa-green-sent);
        color: var(--wa-text-main);
        border-radius: 8px 0 8px 8px;
    }

    .bubble.you {
        align-self: flex-start;
        background-color: var(--wa-incoming);
        color: var(--wa-text-main);
        border-radius: 0 8px 8px 8px;
    }

    .bubble-time {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.6);
        text-align: right;
        margin-top: 4px;
        display: block;
    }

    /* Chat Input Area */
    .chat-input-container {
        height: 62px;
        background-color: var(--wa-dark-sidebar);
        padding: 10px 16px;
        display: flex;
        align-items: center;
        z-index: 10;
    }

    .chat-text-input {
        flex: 1;
        background-color: var(--wa-input-bg);
        border: none;
        border-radius: 8px;
        padding: 10px 15px;
        color: var(--wa-text-main);
        margin: 0 10px;
    }

    .chat-text-input::placeholder {
        color: var(--wa-text-sub);
    }

    .chat-send {
        color: var(--wa-text-sub);
        font-size: 20px;
        cursor: pointer;
        padding: 8px;
    }

    .chat-send:hover {
        color: var(--wa-primary);
    }

    /* --- RIGHT INFO SIDEBAR (Optional) --- */
    .chat-user-details {
        width: 300px;
        background-color: var(--wa-dark-sidebar);
        border-left: 1px solid var(--wa-dark-border);
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .chat-user-details img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin-bottom: 15px;
        border: 4px solid var(--wa-dark-bg);
    }

    .chat-user-details h3 {
        color: var(--wa-text-main);
        font-size: 20px;
        margin-bottom: 5px;
    }

    .chat-user-details p {
        color: var(--wa-text-sub);
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
        width: 6px !important;
        height: 6px !important;
    }

    ::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.2) !important;
    }
</style>
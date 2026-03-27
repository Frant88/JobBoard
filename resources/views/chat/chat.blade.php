@extends("layouts.app")
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">

@section("content")
<div class="messaging-wrapper">
    <div class="contacts-sidebar">
        <h4 class="sidebar-header">Chat</h4>
        @foreach($users as $user)
            <div class="contact-item" onclick="selectChat('{{ $user->id }}', '{{ $user->name }}')">
                <strong>{{ $user->name }}</strong>
            </div>
        @endforeach
    </div>

    <div id="chat-window" class="chat-window">
        <div id="no-chat-selected" class="placeholder-text">
            <h3>Seleziona un contatto per iniziare</h3>
        </div>

        <div id="active-chat" style="display: none; flex-direction: column; height: 100%;">
            <h3 id="chat-with-name" class="chat-header"></h3>
            
            <div id="chat-messages">
                </div>

            <div class="input-area">
                <input type="text" id="userInput" placeholder="Scrivi un messaggio...">
                <button class="btn-send" onclick="inviaMessaggio()">Invia</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sockjs-client/1.5.1/sockjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/stomp.js/2.3.3/stomp.min.js"></script>
<script src="{{ asset('js/chat.js') }}"></script>

<script>
    const mioId = "{{ Auth::id() }}";
    const mioTicket = "{{ $ticket }}";
    let currentRecipientId = null;
     let isWindowFocused = !document.hidden;



    document.addEventListener("visibilitychange", () => {
    if (document.visibilityState === 'visible') {
        isWindowFocused = true;
        console.log("Tab attiva: invio segnale di lettura...");
        
        
        if (currentRecipientId) {
            ChatModule.markAsReadSocket(currentRecipientId, mioTicket);
            ChatModule.markAsRead(currentRecipientId, mioTicket); 
        }
    } else {
        isWindowFocused = false;
        console.log("Tab in background");
    }
});
    // Connessione iniziale
    document.addEventListener('DOMContentLoaded', function() {
        ChatModule.connect(mioTicket);
       
        
        document.getElementById('userInput').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') inviaMessaggio();
        });
    });

    function selectChat(userId, userName) {
        currentRecipientId = userId;
        
        // UI
        document.getElementById('no-chat-selected').style.display = 'none';
        document.getElementById('active-chat').style.display = 'flex';
        document.getElementById('chat-with-name').innerText = "In chat con " + userName;
        document.getElementById('chat-messages').innerHTML = '';

        ChatModule.markAsReadSocket(userId, mioTicket);
        ChatModule.markAsRead(userId,mioTicket);

        // Caricamento storico da Java
        fetch(`http://localhost:8080/api/chat/history/${userId}`, {
            headers: { 'auth-ticket': mioTicket }
        })
        .then(res => res.json())
        .then(data => {
            data.forEach(msg => {
                const type = (msg.senderId == mioId) ? 'sent' : 'received';
                const isRead = msg.read;
                ChatModule.renderMessage(msg, type,isRead);
            });
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }).catch(err => console.log("Nessuno storico trovato o errore server."));
    }

    function inviaMessaggio() {
        const input = document.getElementById('userInput');
        const text = input.value;
        if(currentRecipientId && text.trim() !== "") {
            ChatModule.sendMessage(currentRecipientId, text);
            input.value = '';
        }
    }
</script>
@endsection
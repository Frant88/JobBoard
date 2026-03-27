const ChatModule = {
    stompClient: null,
    socket: null,
    mioTicket: null,

    // 1. Funzione per connettersi
    connect: function(ticket) {
        // Creiamo la connessione base con SockJS 
        this.socket = new SockJS('http://localhost:8080/ws-messaging');
        this.stompClient = Stomp.over(this.socket);
        this.mioTicket= ticket;

        // Header per l'interceptor Java
        const headers = {
            'auth-ticket': ticket
        };

        this.stompClient.connect(headers, (frame) => {
            console.log('Connesso a Spring Boot: ' + frame);

            // 2. Sottoscrizione alla coda PRIVATA
          this.stompClient.subscribe('/user/queue/messages', (message) => {
    const data = JSON.parse(message.body);
    // Gestione integrata: se arriva readBy aggiorna le spunte, altrimenti renderizza il messaggio
    if (data.readBy  === currentRecipientId) {
        console.log("Confronto: " + data.readBy + " con " + currentRecipientId)
        this.visualizeReadStatus();
    } else if (!data.readBy) {
        if(data.senderId == currentRecipientId){
            this.renderMessage(data, 'received');
        }else {
            console.log("Nuovo messaggio da un altro utente")
        }
        
        // Auto-read se sei in chat
        if (isWindowFocused && data.senderId == currentRecipientId) {
            this.markAsReadSocket(data.senderId, this.mioTicket);
        }
    }
});

        }, (error) => {
            console.error('Errore STOMP:', error);
            alert("Sessione scaduta o non valida. Ricarica la pagina.");
        });
    },
    //lettura messaggio
    markAsRead: function(recipientId,ticket){
        fetch(`http://localhost:8080/api/chat/read/${recipientId}`,{
            method : "PATCH",
            headers : {"auth-ticket" : ticket}
        }).catch(e => console.error("errore marckAsRead",e));
    },

    markAsReadSocket: function(senderId,ticket){
       if (!this.stompClient || !this.stompClient.connected) {
        console.warn("STOMP non ancora connesso. Impossibile segnare come letto.");
        return;
    }
    
    const payload = { senderId: senderId.toString() };
    this.stompClient.send("/app/chat.read", { "auth-ticket": ticket }, JSON.stringify(payload));
},

    // 3. Funzione per inviare
    sendMessage: function(recipientId, text) {
        if (text.trim() === "") return;

        const payload = {
            recipientId: recipientId,
            content: text
        };

        
        this.stompClient.send("/app/chat.send", {}, JSON.stringify(payload));
        
        
        this.renderMessage(payload, 'sent');
    },

    // 4. Funzione per "disegnare" il messaggio nell'HTML
    renderMessage: function(msg, type,isRead) {
        const chatBox = document.getElementById('chat-messages');
        const msgDiv = document.createElement('div');
      
        msgDiv.className = `bubble message ${type === 'sent' ? 'sent' : 'received'}`;
        let mark = ''
        if(type === 'sent'){
            mark = isRead ? '<span class="ticks read">✔✔</span>' :'<span class="ticks">✔</span>';
        }
         msgDiv.innerHTML = `<p>${msg.content} ${mark}</p>`;
        
         
            chatBox.appendChild(msgDiv);
        
        
       
        chatBox.scrollTop = chatBox.scrollHeight;
    },
    visualizeReadStatus: function() {
    // Seleziona tutte le spunte che non sono ancora "read" e aggiornale
    const allTicks = document.querySelectorAll('.ticks:not(.read)');
    allTicks.forEach(tick => {
        tick.classList.add('read');
        tick.innerHTML = '✔✔'; 
    });
}
};
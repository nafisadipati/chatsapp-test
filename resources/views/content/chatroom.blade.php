@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chatroom: {{ $chatroom->name }}</h1>
    <ul id="message-list"></ul>
    <form id="send-message-form">
        
        <textarea id="message-content" placeholder="Type your message here..." required></textarea>
        <input type="file" id="attachment">
        <button type="submit">Send</button>
    </form>
</div>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatroomId = {{ $chatroom->id }};
        fetchMessages(chatroomId);

        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true
        });
        
        const channel = pusher.subscribe('chatroom.' + chatroomId);
        
        channel.bind('message-sent', function(data) {
            const messageList = document.getElementById('message-list');
            const li = document.createElement('li');
            
            // Menampilkan konten pesan
            li.textContent = `${data.content} (Sent by user ${data.user_id})`;
            
            // Jika ada lampiran, tambahkan elemen gambar
            if (data.attachment) {
                const img = document.createElement('img');
                img.src = data.attachment; // URL gambar
                img.style.maxWidth = '200px'; // Mengatur lebar maksimal gambar
                img.style.display = 'block'; // Menampilkan gambar sebagai block element
                li.appendChild(img);
            }
            
            messageList.appendChild(li);
        });

        document.getElementById('send-message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            sendMessage(chatroomId);
        });
    });

    function fetchMessages(chatroomId) {
        fetch(`/api/chatrooms/${chatroomId}/messages`)
            .then(response => response.json())
            .then(data => {
                const messageList = document.getElementById('message-list');
                messageList.innerHTML = '';
                data.forEach(message => {
                    const li = document.createElement('li');
                    li.textContent = `${message.content} (Sent by user ${message.user_id})`;
                    messageList.appendChild(li);
                });
            });
    }

    function sendMessage(chatroomId) {
        const content = document.getElementById('message-content').value;
        const attachment = document.getElementById('attachment').files[0];
        
        const formData = new FormData();
        formData.append('content', content);
        formData.append('user_id', {{ Auth::user()->id }});
        formData.append('chatroom_id', chatroomId)
        if (attachment) {
            formData.append('attachment', attachment);
        }
        
        fetch(`/api/chatrooms/${chatroomId}/messages`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('message-content').value = '';
            document.getElementById('attachment').value = '';
        });
    }
</script>

@endsection

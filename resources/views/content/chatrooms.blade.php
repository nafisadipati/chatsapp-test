@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chatrooms</h1>
    <ul id="chatroom-list"></ul>
    <form id="create-chatroom-form">
        <input type="text" id="chatroom-name" placeholder="Chatroom Name" required>
        <input type="number" id="max-members" placeholder="Max Members" required>
        <button type="submit">Create Chatroom</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchChatrooms();

        document.getElementById('create-chatroom-form').addEventListener('submit', function(e) {
            e.preventDefault();
            createChatroom();
        });
    });

    function fetchChatrooms() {
        fetch('/chatrooms')
            .then(response => response.json())
            .then(data => {
                const chatroomList = document.getElementById('chatroom-list');
                chatroomList.innerHTML = '';
                data.forEach(chatroom => {
                    const li = document.createElement('li');
                    li.textContent = chatroom.name;
                    li.addEventListener('click', () => enterChatroom(chatroom.id));
                    chatroomList.appendChild(li);
                });
            });
    }

    function createChatroom() {
        const name = document.getElementById('chatroom-name').value;
        const maxMembers = document.getElementById('max-members').value;

        fetch('/chatrooms', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ name, max_members: maxMembers })
        })
        .then(response => response.json())
        .then(data => {
            fetchChatrooms();
            document.getElementById('chatroom-name').value = '';
            document.getElementById('max-members').value = '';
        });
    }

    function enterChatroom(id) {
        window.location.href = `/chatrooms/${id}`;
    }
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Laravel Chat</h3>
    <div id="chat-box" style="border:1px solid #ccc; height:300px; overflow-y:scroll; padding:10px;"></div>
    <form id="chat-form">
        <textarea id="message-input" class="form-control" rows="2" placeholder="Type a message..."></textarea>
        <button type="submit" class="btn btn-primary mt-2">Send</button>
    </form>
</div>
@endsection

    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
    function loadMessages() {
        $.get('/messages', function (messages) {
            $('#chat-box').html('');
            messages.forEach(function (msg) {
                $('#chat-box').append(
                    `<div><strong>${msg.user.name}:</strong> ${msg.body}</div>`
                );
            });
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
        });
    }

    loadMessages();
    setInterval(loadMessages, 3000); // Poll every 3 seconds

    $('#chat-form').on('submit', function (e) {
        e.preventDefault();
        const body = $('#message-input').val();
        if (!body.trim()) return;

        $.post('/messages', {
            _token: '{{ csrf_token() }}',
            body: body,
        }, function () {
            $('#message-input').val('');
            loadMessages();
        });
    });
});
</script>
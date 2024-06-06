<!DOCTYPE html>
<html>

<head>
    <title>Chat</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #chat-box {
            border: 1px solid #ccc;
            padding: 10px;
            width: 100%;
            height: 400px;
            overflow-y: scroll;
        }

        .message {
            padding: 10px;
            margin: 5px;
            border-radius: 15px;
            max-width: 70%;
            word-wrap: break-word;
        }

        .sender {
            background-color: #007bff;
            color: #fff;
            float: right;
            clear: both;
            text-align: right;
        }

        .receiver {
            background-color: #f1f1f1;
            float: left;
            clear: both;
        }

        .wide-textarea {
            width: 100%;
        }
    </style>
</head>

<body class="container mt-5">
    <h1 class="text-center">Chat</h1>
    <div id="chat-box" class="mb-3"></div>
    <form id="chat-form" class="form-inline">
        <input type="hidden" id="current-user-id" value="<?= session()->get('user_id'); ?>"> <!-- Mendapatkan user_id dari session -->
        <input type="hidden" name="receiver_id" value="2"> <!-- Sesuaikan dengan receiver_id yang diinginkan -->
        <div class="form-group mx-sm-3 mb-2">
            <textarea name="message" class="form-control wide-textarea" placeholder="Type your message here..." rows="1" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Send</button>
    </form>

    <script>
        $(document).ready(function() {
            const currentUserId = $('#current-user-id').val();

            function fetchMessages() {
                $.get('/chat/fetchMessages', function(data) {
                    $('#chat-box').html('');
                    data.forEach(function(message) {
                        var messageClass = message.sender_id == currentUserId ? 'sender' : 'receiver';
                        $('#chat-box').append('<div class="message ' + messageClass + '">' + message.message + '</div>');
                    });
                    scrollChatToBottom(); // Menggulir ke bawah setelah memuat pesan
                });
            }

            $('#chat-form').on('submit', function(event) {
                event.preventDefault();
                $.post('/chat/sendMessage', $(this).serialize(), function() {
                    fetchMessages();
                });
                $(this).find('textarea[name="message"]').val('');
            });

            setInterval(fetchMessages, 1000); // Polling setiap 1 detik

            function scrollChatToBottom() {
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            }
        });
    </script>
</body>

</html>
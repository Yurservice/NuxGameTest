<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page A</title>
</head>

<body>
    <h1>Page A for unique link</h1>
    <h2>Welcome, {{ $player->username }}</h2>
    <p>Your phone: {{ $player->phone_number }}</p>
    <p>Link expiration date: {{ $uniqueLink->expires_at->format('d.m.Y H:i') }}</p>

    <button id="generateLinkBtn" class="btn btn-primary">Generate new link</button>
    <button id="deactivateLinkBtn" class="btn btn-danger">Deactivate link</button>
    <button id="luckyBtn" class="btn btn-success">I'm feeling lucky</button>
    <button id="historyBtn" class="btn btn-info">History</button>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div id="message" class="alert" style="display: none;"></div>

    <script>
        document.getElementById('generateLinkBtn').addEventListener('click', function() {
            const playerId = "{{ $uniqueLink->player_id }}";

            fetch("{{ route('link.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        player_id: playerId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.unique_link) {
                        showMessage('New unique link: <a href="' + data.unique_link + '" target="_blank">HERE</a>', 'success');
                    } else {
                        showMessage('Error creating link', 'danger');
                    }
                })
                .catch(error => showMessage('Request error: ' + error.message, 'danger'));
        });

        document.getElementById('deactivateLinkBtn').addEventListener('click', function() {
            const link = '{{ $uniqueLink->unique_link }}';

            fetch("{{ route('link.deactivate') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        link: link
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage(data.success, 'success');
                    } else {
                        showMessage(data.error, 'danger');
                    }
                })
                .catch(error => showMessage('Request error: ' + error.message, 'danger'));
        });

        document.getElementById('luckyBtn').addEventListener('click', function() {
            let randomNumber = Math.floor(Math.random() * 1000) + 1;
            fetch("{{ route('game.result') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ player_id: {{ $player->id }}, figure: randomNumber })
                })
                .then(response => response.json())
                .then(data => {
                    let resultMessage = `Your figure: ${randomNumber} <br> Result: ${data.result} <br> Winning: ${data.amount}`;
                    showMessage(resultMessage, 'success', 'luckyResult');
                })
                .catch(error => showMessage('Request error: ' + error.message, 'danger', 'luckyResult'));
        });

        document.getElementById('historyBtn').addEventListener('click', function() {
            fetch("{{ route('game.history') }}?player_id={{ $player->id }}", {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let historyMessage;
                    if (data.games?.length > 0) {
                        historyMessage = '<strong>Last 3 games:</strong><br>' + 
                            data.games.map(item => `Figure: ${item.random_figure}, Result: ${item.reward > 0 ? 'Win' : 'LOSE'}, Winning: ${item.reward}, Date: ${item.created_at}`)
                            .join('<br>');
                    }
                    else historyMessage = 'Game list is empty';
                    showMessage(historyMessage, 'info', 'historyResult');
                })
                .catch(error => showMessage('Request error: ' + error.message, 'danger', 'historyResult'));
        });


        function showMessage(message, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.innerHTML = message;
            messageDiv.className = 'alert alert-' + type;
            messageDiv.style.display = 'block';
        }
    </script>
</body>

</html>
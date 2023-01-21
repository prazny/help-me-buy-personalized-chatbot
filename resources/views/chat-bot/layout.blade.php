<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/chatbot.css?id='  . rand(1, 5000)) }}"/>
    <script>
        const apiStartMessagingUrl = "{{ route('chatbot-start-messaging', $widget_id) }}"
        const apiMessagingUrl = "{{ route('chatbot-messaging') }}"
    </script>
</head>
<body>
<div class="chatbot-container" id="chatbot-body" data-widget-id="{{ $widget_id }}" x-data="{open: true}">
    <div class="chatbot-expanded-container" x-show="open">
        <div class="chatbot-expanded-header">
            <span id="chatbot-title" class="title">Wirtualny doradca</span>
        </div>
        <div class="chatbot-expanded-messages" id="chatbot-messages-container">

        </div>

    </div>

    <div class="chatbot-rolled" x-on:click="open = !open">
        <div class="chatbot-cloud">
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
<script src="{{ asset('js/chatbox.js?id=' . rand(1, 5000)) }}"></script>
</body>
</html>


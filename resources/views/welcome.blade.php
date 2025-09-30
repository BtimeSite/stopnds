<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Опрос: Отменить НДС 16%?</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        <div class="menu-wrap">
            <div class="menu-item">{{ __('News') }}</div>
            <div class="menu-item">{{ __('Kazakhstan') }}</div>
            <div class="menu-item">{{ __('Policy') }}</div>
        </div>
        <div class="header">
            <div class="title">{{ __('Welcome title') }}</div>
            <div class="highlight">{{ __('Welcome description') }}</div>
            <div class="question">{{ __('Welcome question') }}</div>
            <div class="author">{{ __('Welcome author') }}</div>
            
        </div>
    </div>
    <div class="logo">
    <img src="/images/tokaev.jpg" style="width: 100%; max-width: 500px;" alt="tokaev" />
    </div>
    <div class="container">
        <div class="poll-card">
            <button class="vote-button pulse" id="voteButton">
                <i class="fas fa-hand"></i>
                <span>{{ __('Support') }}</span>
            </button>
            
            <div class="vote-count">
                {{__('Number of votes:')}}
                <div class="votes-number" id="votesCount">728,459</div>
            </div>
            
            <div class="state-hearing">
                {{__('Your voice will be heard!')}}
            </div>
        </div>

        <div class="goal">
            <div class="goal-text">{{ __('The goal to be achieved:') }}</div>
            <div class="goal-number">{{ __(':count votes', ['count' => '1 000 000']) }}</div>
            <div class="progress-bar">
                <div class="progress" id="progressBar"></div>
            </div>
            <div>{!! __('Remaining: :count votes') !!}</div>
        </div>

        <div class="share-section">
            <div class="share-title">{{ __('Share the quiz') }}</div>
            <div class="share-buttons">
                <button class="share-button">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </button>
                <button class="share-button">
                    <i class="fab fa-telegram"></i> Telegram
                </button>
                <button class="share-button">
                    <i class="fab fa-facebook"></i> Facebook
                </button>
                <button class="share-button">
                    <i class="fab fa-threads"></i> Threads
                </button>
            </div>
        </div>

        <div class="social-section">
            <div class="social-title">{{ __('Social networks') }}</div>
            <div class="social-icons">
                <div class="social-icon"><i class="fab fa-instagram"></i></div>
                <div class="social-icon"><i class="fab fa-telegram"></i></div>
                <div class="social-icon"><i class="fab fa-youtube"></i></div>
                <div class="social-icon"><i class="fab fa-threads"></i></div>
            </div>
        </div>
        
        <div class="footer">
            {{ __('Your opinion is important for the future of the country.') }}
        </div>
    </div>
</body>
</html>
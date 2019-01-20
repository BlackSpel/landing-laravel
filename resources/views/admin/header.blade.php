<div class="container portfolio_title">
    <h2>{{ $title }}</h2>
</div>
<div class="portfolio">
    <div id="filters" class="sixteen columns">
        <ul style="padding:0 0 0 0">
            <li>
                <a href="{{ route('pages') }}">
                <h5>Страницы</h5>
                </a>
            </li>
            <li>
                <a href="{{ route('services') }}">
                    <h5>Сервисы</h5>
                </a>
            </li>
            <li>
                <a href="{{ route('portfolios') }}">
                    <h5>Портфолио</h5>
                </a>
            </li>
        </ul>
    </div>
</div>
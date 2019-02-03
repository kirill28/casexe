@if ($gameIsAvailable)
    <a class="btn btn-app" href="{{ route('play') }}">
        <i class="fa fa-play"></i>
        Play
    </a>
@else
    <div class="callout callout-danger">
        <h4>Sorry the game is not available now</h4>
        <p>We are working on it</p>
    </div>
@endif

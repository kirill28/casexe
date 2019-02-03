<div class="callout callout-info">
    <h4>Congratulations!</h4>

    <p>You won {{$value}} bonus points! Now you have {{ \Auth::user()->bonus_points }} bonus points.</p>
</div>

@include('casino._play')

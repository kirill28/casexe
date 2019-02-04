<div class="callout callout-info">
    <h4>Congratulations!</h4>

    <p>You won {{$value}} {{$currency}}!</p>
</div>

<div class="col-md-2">
    <a class="btn btn-app" href="{{ route('convert_to_bonus', ['id' => $transactionId]) }}">
        <i class="fa fa-refresh"></i>
        Bonus points x{{ $convertCoefficient }}
    </a>
</div>
<div class="col-md-4">
    <form action="{{ route('apply_money_transaction', ['id' => $transactionId]) }}" method="POST">
        {{ csrf_field() }}

        <div class="form-group @if($errors->first('card_number')) error @endif">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-cc-visa"></i></span>
                <input type="text"
                       name="card_number"
                       required
                       class="form-control"
                       placeholder="Card number"
                >
            </div>
            <p class="help">
                @if($errors->first('card_number'))
                    {{ $errors->first('card_number') }}
                @endif
            </p>
        </div>
        <button class="btn btn-primary">Submit</button>
    </form>
</div>
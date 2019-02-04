<div class="callout callout-info">
    <h4>Congratulations!</h4>

    <p>You won <b>{{$value->name}}</b>!</p>
</div>

<div class="col-md-2">
    <form action="{{ route('apply_item_transaction', ['id' => $transactionId]) }}" method="POST">
        {{ csrf_field() }}

        <button class="btn btn-success">Apply prize</button>
    </form>
</div>
<div class="col-md-2">
    <form action="{{ route('reject_item_transaction', ['id' => $transactionId]) }}" method="POST">
        {{ csrf_field() }}

        <button class="btn btn-danger">Reject prize</button>
    </form>
</div>
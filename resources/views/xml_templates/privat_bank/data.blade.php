        <oper>cmt</oper>
        <wait>{{ $wait ?? 0 }}</wait>
        <test>{{ $test ?? 0 }}</test>
@if(isset($paymentId))
        <payment id="{{ $paymentId }}">
            <prop name="b_card_or_acc" value="{{ $cardNumber }}" />
            <prop name="amt" value="{{ $amount }}" />
            <prop name="ccy"  value="{{ $currency }}" />
            <prop name="b_name" value="{{ $userName }}" />
            <prop name="details" value="testVisa" />
        </payment>@else
        <payment id="">
        </payment>@endif
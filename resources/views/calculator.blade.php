@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="gateway--info">
            <div id="calculator"></div>
        </div>
    </div>
@stop

@section('footer')
<script async defer src="http://loancalculator-uat.oscap.com.au/api/v0/LoanCalculator.aspx?callback=initCalculator"></script>
<script type="text/javascript">
    function initCalculator() {
        var init = {
            "minamount": 5000,
            "maxamount": 50000,
            "defaultamount": 20000,
            "minterm": 12,
            "maxterm": 120,
            "defaultterm": 24,
            "minrate": 5.00,
            "maxrate": 20.00,
            "defaultrate": 5.00,
            "lenderid": "KMF",
            "originationsource": "Alchemy-UAT: Ninja Supersport 4.99% deal linkon www.kawasaki.com.au",
            "notificationtoemailaddress":""
            };

        alliedcredit.lightning.createLoanCalculator(document.getElementById('calculator'), init);
    }
</script>
@stop

<div class="alert">
    @if (session('status'))
        <div class="message alert alert-success"> {{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="message alert alert-danger"> {{ session('error') }}</div>
    @endif
</div>

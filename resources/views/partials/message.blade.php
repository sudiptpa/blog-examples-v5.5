<div class="alert">
    @if (session('success'))
        <div class="message alert alert-success"> {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="message alert alert-danger"> {{ session('error') }}</div>
    @endif
</div>

<div class="absolute left-6 right-6 mt-6 lg:left-1/3 lg:right-1/3 z-[1000]">
    @if(session()->has('default'))
        <div id="toast" class="alert-window" role="alert">
            <div class="badge-blue">
                <i class="fa-solid fa-fire-flame-curved fa-lg"></i>
            </div>
            <div class="ml-3 text-sm font-normal">{!! session('success') !!}</div>
            <button type="button" class="alert-close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @elseif(session()->has('success'))
        <div id="toast" class="alert-window" role="alert">
            <div class="badge-green">
                <i class="fa-solid fa-check fa-lg"></i>
            </div>
            <div class="ml-3 text-sm font-normal">{!! session('success') !!}</div>
            <button type="button" class="alert-close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @elseif(session()->has('error'))
        <div id="toast" class="alert-window" role="alert">
            <div class="badge-red">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="ml-3 text-sm font-normal">{!! session('error') !!}</div>
            <button type="button" class="alert-close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @elseif(session()->has('warning'))
        <div id="toast" class="alert-window" role="alert">
            <div class="badge-yellow">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="ml-3 text-sm font-normal">{!! session('warning') !!}</div>
            <button type="button" class="alert-close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif
</div>

@if(session()->has('default') || session()->has('success') || session()->has('error') || session()->has('warning'))
    <script>
        setTimeout(function() {
            document.getElementById('toast').style.display = 'none';
        }, 5000);
        document.querySelector('.alert-close').addEventListener('click', function() {
            document.getElementById('toast').style.display = 'none';
        });
    </script>
@endif

@if(str_contains(url()->current(), 'localhost'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger text-center fw-bold">
                Developer verze
            </div>
        </div>
    </div>
@endif

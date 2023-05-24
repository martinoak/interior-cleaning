@if(str_contains(url()->current(), 'mad.dek.cz'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger text-center fw-bold">
                Developer verze Laravel {{ Illuminate\Foundation\Application::VERSION }}, PHP {{ PHP_VERSION }}
            </div>
        </div>
    </div>
@endif

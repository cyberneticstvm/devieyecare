@extends("admin.base")
@section("content")
<div class="container-xxl grow container-p-y">
    <div class="row">
        <!-- Website Analytics-->
        <div class="col-lg-12 col-md-12 mb-5 mt-5">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ asset('/assets/images/sad-face.svg') }}" width="5%" />
                    <h5 class="text-danger text-center">{{ $exception->getMessage() }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
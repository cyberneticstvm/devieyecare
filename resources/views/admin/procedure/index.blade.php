@extends("admin.base")
@section("content")
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Search Procedure</h5>
        <p class="fs-12">Search Procedure</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-6">
                {{ html()->form('POST')->route('procedure.fetch')->class('d-flex')->attribute('role', 'search')->open() }}
                {{ html()->text('mrn', $registration?->mrn ?? old('mrn'))->class('form-control me-2')->attribute('id', 'navbarSearch')->placeholder('Medical Record No.')->required() }}
                {{ html()->submit('Search')->class('btn btn-submit btn-primary w-100') }}
                {{ html()->form()->close() }}
                @error('mrn')
                <small class="text-danger">{{ $errors->first('mrn') }}</small>
                @enderror
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <h5>Registration / Order Details</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>Medical Record No.</th>
                                                <td><a href="{{ route('procedure.create', encrypt($registration?->id)) }}">{!! $registration?->getMrn() !!}</a></td>
                                            </tr>
                                            <tr>
                                                <th>Customer Name</th>
                                                <td>{{ $registration?->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Registration Date</th>
                                                <td>{{ $registration?->created_at->format('d.M.Y h:i a') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Booked Date</th>
                                                <td>{{ $registration?->order()?->first()?->created_at?->format('d.M.Y h:i a') ?? 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Due Date</th>
                                                <td>{{ $registration?->order()?->first()?->due_date?->format('d.M.Y') ?? 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Order Status</th>
                                                <td>{{ $registration?->order()?->first()?->ostatus?->name ?? 'NA' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Billed / Delivered Date</th>
                                                <td>{{ $registration?->order()?->first()?->invoice_generated_at?->format('d.M.Y h:i a') ?? 'NA' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
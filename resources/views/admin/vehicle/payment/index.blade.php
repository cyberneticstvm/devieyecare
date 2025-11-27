@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Vehicle Payment Register</h5>
        <p class="fs-12">Showing vehicle payment register</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-12">
                <h5 class="text-primary">Vehicle: {{ $vehicle->registration_number }} | Name: {{ $vehicle->name }} | Mobile: {{ $vehicle->mobile }}</h5>
            </div>
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Pay.Date</th>
                            <th class="py-2 fw-medium small text-uppercase">Amount</th>
                            <th class="py-2 fw-medium small text-uppercase">Notes</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $key => $payment)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $payment->pdate->format('d.M.Y') }}</td>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ $payment->notes }}</td>
                            <td>{!! $payment->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('vehicle.payment.edit', encrypt($payment->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('vehicle.payment.delete', encrypt($payment->id)) }}" class="text-danger dlt">Delete</a>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <h5>New Vehicle</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('vehicle.payment.save')->class('')->open() }}
                                        <input type="hidden" name="vehicle_id" value="{{ encrypt($vehicle->id) }}" />
                                        <div class="row g-3">
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Payment Date </label>
                                                {{ html()->date('pdate', (old('pdate')) ?? date('Y-m-d'))->class('form-control') }}
                                                @error('pdate')
                                                <small class="text-danger">{{ $errors->first('pdate') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Amount </label>
                                                {{ html()->number('amount', old('amount') ?? '', '1', '', '')->class('form-control')->placeholder('0.00') }}
                                                @error('amount')
                                                <small class="text-danger">{{ $errors->first('amount') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-12">
                                                <label class="form-label">Notes </label>
                                                {{ html()->text('notes', old('notes') ?? '')->class('form-control')->placeholder('Notes') }}
                                                @error('notes')
                                                <small class="text-danger">{{ $errors->first('notes') }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="raw mt-3">
                                            <div class="col text-end">
                                                {{ html()->submit('Save')->class('btn btn-submit btn-primary') }}
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
    </div>
</div>
@endsection
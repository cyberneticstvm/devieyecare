@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Payment Register</h5>
        <p class="fs-12">Payment Register</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Pay.Date</th>
                            <th class="py-2 fw-medium small text-uppercase">Amount</th>
                            <th class="py-2 fw-medium small text-uppercase">Mrn</th>
                            <th class="py-2 fw-medium small text-uppercase">Order Type</th>
                            <th class="py-2 fw-medium small text-uppercase">Pay Type</th>
                            <th class="py-2 fw-medium small text-uppercase">Pay Mode</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $key => $pay)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $pay->pdate->format('d.M.Y') }}</td>
                            <td>{{ $pay->amount }}</td>
                            <td>{!! $pay->order->registration->getMrn() !!}</td>
                            <td>{{ $pay->order_type }}</td>
                            <td>{{ $pay->ptype->name }}</td>
                            <td>{{ $pay->paymode->name }}</td>
                            <td>{!! $pay->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('payment.edit', encrypt($pay->id)) }}" class="text-secondary">Edit</a> | <a href="{{ route('payment.delete', encrypt($pay->id)) }}" class="text-danger dlt">Delete</a>
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
                                <h5>New Payment</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('payment.save')->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Pay. Date </label>
                                                {{ html()->date('pdate', old('pdate') ?? date('Y-m-d'))->class('form-control') }}
                                                @error('pdate')
                                                <small class="text-danger">{{ $errors->first('pdate') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">MRN </label>
                                                {{ html()->text('mrn', old('mrn') ?? '')->class('form-control')->placeholder('MRN') }}
                                                @error('mrn')
                                                <small class="text-danger">{{ $errors->first('mrn') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Order Type</label>
                                                {{ html()->select($name = 'order_type', $value = $otypes, old('order_type'))->class('form-select')->placeholder('Select') }}
                                                @error('order_type')
                                                <small class="text-danger">{{ $errors->first('order_type') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Payment Type</label>
                                                {{ html()->select($name = 'payment_type', $value = $ptypes, old('payment_type'))->class('form-select')->placeholder('Select') }}
                                                @error('payment_type')
                                                <small class="text-danger">{{ $errors->first('payment_type') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Amount</label>
                                                {{ html()->number('amount', old('amount') ?? '', '1', '', '1')->class('form-control')->placeholder('0.00') }}
                                                @error('amount')
                                                <small class="text-danger">{{ $errors->first('amount') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Payment Mode</label>
                                                {{ html()->select($name = 'pmode', $value = $pmodes, old('pmode'))->class('form-select')->placeholder('Select') }}
                                                @error('pmode')
                                                <small class="text-danger">{{ $errors->first('pmode') }}</small>
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
                                        <div class="raw g-lg-12 mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Generate Invoice </label><br>
                                                {{ html()->checkbox('invoice', false, 1)->class('form-check-input') }}
                                            </div>
                                        </div>
                                        <div class="raw text-end">
                                            <div class="col-md-12">
                                                {{ html()->submit('Save')->class('btn btn-submit btn-primary') }}
                                            </div>
                                        </div>
                                        {{ html()->form()->close() }}
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
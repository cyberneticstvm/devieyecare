@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Customer Register</h5>
        <p class="fs-12">Showing customers</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Customer</th>
                            <th class="py-2 fw-medium small text-uppercase">Mobile</th>
                            <th class="py-2 fw-medium small text-uppercase">Address</th>
                            <th class="py-2 fw-medium small text-uppercase">GST</th>
                            <th class="py-2 fw-medium small text-uppercase">Opening Bal.</th>
                            <th class="py-2 fw-medium small text-uppercase">Credit Limit</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Edit</th>
                            <th class="py-2 fw-medium small text-uppercase">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $key => $customer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->mobile }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ $customer->gst }}</td>
                            <td>{{ $customer->opening_balance }}</td>
                            <td>{{ $customer->credit_limit }}</td>
                            <td>{!! $customer->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('drishti.customer.edit', encrypt($customer->id)) }}" class="text-secondary">Edit</a> </a>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('drishti.customer.delete', encrypt($customer->id)) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger dlt">
                                        Delete
                                    </button>
                                </form>
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
                                <h5>New Customer</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('drishti.customer.save')->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Customer Name </label>
                                                {{ html()->text('name', old('name') ?? '')->class('form-control')->placeholder('Customer Name') }}
                                                @error('name')
                                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Contact Number </label>
                                                {{ html()->text('mobile', old('mobile') ?? '')->class('form-control')->maxlength(10)->placeholder('Contact Number') }}
                                                @error('mobile')
                                                <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-12">
                                                <label class="form-label">Address </label>
                                                {{ html()->text('address', old('address') ?? '')->class('form-control')->placeholder('Address') }}
                                                @error('address')
                                                <small class="text-danger">{{ $errors->first('address') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label">GST Number </label>
                                                {{ html()->text('gst', old('gst') ?? '')->class('form-control')->placeholder('GST Number') }}
                                                @error('gst')
                                                <small class="text-danger">{{ $errors->first('gst') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label">Opening Balance </label>
                                                {{ html()->text('opening_balance', old('opening_balance') ?? '')->class('form-control')->placeholder('Opening Balance') }}
                                                @error('opening_balance')
                                                <small class="text-danger">{{ $errors->first('opening_balance') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-4">
                                                <label class="form-label">Credit Limit </label>
                                                {{ html()->text('credit_limit', old('credit_limit') ?? '')->class('form-control')->placeholder('Credit Limit') }}
                                                @error('credit_limit')
                                                <small class="text-danger">{{ $errors->first('credit_limit') }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="raw mt-3">
                                            <div class="col text-end">
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
@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">{{ $category->name }} Register</h5>
        <p class="fs-12">Showing {{ $category->name }} register</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">SL No</th>
                            <th class="py-2 fw-medium small text-uppercase">Head</th>
                            <th class="py-2 fw-medium small text-uppercase">Description</th>
                            <th class="py-2 fw-medium small text-uppercase">Amount</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ies as $key => $ie)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $ie->head->name }}</td>
                            <td>{{ $ie->description }}</td>
                            <td class="text-end">{{ $ie->amount }}</td>
                            <td>{!! $ie->cancelled() !!}</td>
                            <td class="text-center">
                                <a href="{{ route('ie.edit', ['category' => 'Expense', 'id' => encrypt($ie->id)]) }}" class="text-secondary">Edit</a> | <a href="{{ route('ie.delete', ['category' => 'Expense', 'id' => encrypt($ie->id)]) }}" class="text-danger dlt">Delete</a>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="fw-bold text-end">Total</td>
                            <td class="fw-bold text-end">{{ number_format($ies->sum('amount'), 2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <h5>New Head</h5>
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        {{ html()->form('POST')->route('ie.save', 'Expense')->class('')->open() }}
                                        <div class="row g-3">
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Date </label>
                                                {{ html()->date('ie_date', old('ie_date') ?? date('Y-m-d'))->class('form-control') }}
                                                @error('ie_date')
                                                <small class="text-danger">{{ $errors->first('ie_date') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Head</label>
                                                {{ html()->select('head_id', $value = $heads, old('head_id'))->class('form-control')->placeholder('Select')->required() }}
                                                @error('head_id')
                                                <small class="text-danger">{{ $errors->first('head_id') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label req">Amount </label>
                                                {{ html()->number('amount', old('amount') ?? '', '1', '', '1')->class('form-control')->placeholder('0.00') }}
                                                @error('amount')
                                                <small class="text-danger">{{ $errors->first('amount') }}</small>
                                                @enderror
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label class="form-label">Description </label>
                                                {{ html()->text('description', old('description') ?? '')->class('form-control')->placeholder('Description') }}
                                                @error('description')
                                                <small class="text-danger">{{ $errors->first('description') }}</small>
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
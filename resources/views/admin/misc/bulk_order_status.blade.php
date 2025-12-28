@extends("admin.base")
@section("content")
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Order Status Update</h5>
        <p class="fs-12">Order Status Update</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-8">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <h5>Bulk Order Status Update</h5>
                                {{ html()->form('POST')->route('bulk.order.status.update')->class('')->open() }}
                                <div class="row g-lg-12 g-3">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered table-striped" id="apptTable">
                                            <thead>
                                                <th class="w-15">Mrn</th>
                                                <th class="w-25">Status</th>
                                                <th class="w-60">Comments</th>
                                                <th>Remove</th>
                                            </thead>
                                            <tbody class="orderStatusRow">
                                                <tr>

                                                    <td>
                                                        {{ html()->text('mrns[]', '')->class('form-control')->placeholder('Mrn') }}
                                                    </td>
                                                    <td>
                                                        {{ html()->select($name = 'status_ids[]', $value = $statuses, '')->class('select2')->attribute('id', 'sid1')->placeholder('Select') }}
                                                    </td>
                                                    <td>
                                                        {{ html()->text('comments[]', '')->class('form-control')->placeholder('comment') }}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-center"><a href="javascript:void(0)" onclick="addRow('status')">Add New</a></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="raw mt-3">
                                    <div class="col text-end">
                                        {{ html()->button('Cancel')->class('btn btn-secondary')->attribute('onclick', 'window.history.back()')->attribute('type', 'button') }}
                                        {{ html()->submit('Update')->class('btn btn-submit btn-primary') }}
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
@endsection
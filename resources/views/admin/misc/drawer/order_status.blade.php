<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="OrderStatusSettings">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Update Order Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pe-4">
        <div class="px-lg-2 mb-4">
            <h6 class="small text-uppercase mrn"></h6>
            {{ html()->form('POST')->route('store.order.status.update')->open() }}
            <input type="hidden" name="oid" id="oid" value="" />
            <div class="row g-3">
                <div class="control-group col-md-12">
                    <label class="form-label req">Order Status </label>
                    {{ html()->select('status', $statuses, '')->class('form-control')->placeholder('Select')->required() }}
                </div>
            </div>
            <div class="raw mt-3">
                <div class="col text-end">
                    {{ html()->submit('Update')->class('btn btn-submit btn-primary') }}
                </div>
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
</div>
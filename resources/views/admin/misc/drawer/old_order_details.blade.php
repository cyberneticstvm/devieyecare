<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="oldOrderDetails">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Order / Medicine Detailed</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pe-4">
        <div class="px-lg-2 mb-4">
            <div class="oldOrderDetails">
                <h5>Order</h5>
                <table class="table">
                    <tr>
                        <th>Eye</th>
                        <th>Sph</th>
                        <th>Cyl</th>
                        <th>Axis</th>
                        <th>Add</th>
                    </tr>
                    <tr>
                        <td>RE</td>
                        <td>{{ $registrations['re_sph'] ?? '' }}</td>
                        <td>{{ $registrations['re_cyl'] ?? '' }}</td>
                        <td>{{ $registrations['re_axis'] ?? '' }}</td>
                        <td>{{ $registrations['re_add'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>LE</td>
                        <td>{{ $registrations['le_sph'] ?? '' }}</td>
                        <td>{{ $registrations['le_cyl'] ?? '' }}</td>
                        <td>{{ $registrations['le_axis'] ?? '' }}</td>
                        <td>{{ $registrations['le_add'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>RE</td>
                        <td colspan="4">{{ $registrations['re_lens'] ?? 'Na' }}</td>
                    </tr>
                    <tr>
                        <td>LE</td>
                        <td colspan="4">{{ $registrations['le_lens'] ?? 'Na' }}</td>
                    </tr>
                    <tr>
                        <td>Frame</td>
                        <td colspan="4">{{ $registrations['frame'] ?? 'Na' }}</td>
                    </tr>
                </table>
                <h5>Medicine</h5>
            </div>
        </div>
    </div>
</div>
@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Today's Pending Order for Lab</h5>
        <p class="fs-12">Today's Pending Order for Lab</p>
        <div class="row g-lg-12 g-3">
            <div class="col-lg-12">
                <section class="pt-3 mt-2 mt-md-4" id="collapse">
                    {{ html()->form('POST')->route('lab.save')->class('')->open() }}
                    <div class="card border-dashed">
                        <div class="card-body">
                            @error('orders')
                            <small class="text-danger">{{ $errors->first('orders') }}</small>
                            @enderror
                            @forelse($orders as $key => $order)
                            <div class="row mt-3">
                                <div class="col fw-bold">
                                    {{ $key + 1}}
                                </div>
                                <div class="col">
                                    {{ html()->checkbox("orders[]", false, $order->id)->class("form-check-input") }}
                                </div>
                                <div class="col fw-bold">
                                    {!! $order->registration->getMrn() !!}
                                </div>
                                <div class="col fw-bold">
                                    {{ $order->branch->name }}
                                </div>
                                <div class="col fw-bold">
                                    {{ $order->due_date?->format("d.M.Y") }}
                                </div>
                                <div class="col fw-bold">
                                    {{ $order->registration->name }}
                                </div>
                                <div class="col fw-bold">
                                    {{ $order->registration->address }}
                                </div>
                                <div class="col fw-bold">
                                    {{ $order->registration->mobile }}
                                </div>
                                <div class="col fw-bold">
                                    {{ $order->ostatus?->name }}
                                </div>
                                <div class="col fw-bold">
                                    {{ $order->remarks }}
                                </div>
                                <div class="col">
                                    <a class="btn btn-secondary collapsed" data-bs-toggle="collapse" href="#collapseExample_{{ $order->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        +
                                    </a>
                                </div>
                            </div>
                            <div class="collapse" id="collapseExample_{{ $order->id }}">
                                <div class="card card-body">
                                    <table class="table w-75 mx-auto">
                                        <thead>
                                            <tr>
                                                <th class="text-danger">Eye</th>
                                                <th class="text-danger">Sph</th>
                                                <th class="text-danger">Cyl</th>
                                                <th class="text-danger">Axis</th>
                                                <th class="text-danger">Add</th>
                                                <th class="text-danger">Dia</th>
                                                <th class="text-danger">Thick</th>
                                                <th class="text-danger">Product</th>
                                                <th class="text-danger">Qty</th>
                                                <th class="text-danger">Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($order->details as $key1 => $item)
                                            <tr>
                                                <td>{{ $item->eye }}</td>
                                                <td>{{ $item->sph }}</td>
                                                <td>{{ $item->cyl }}</td>
                                                <td>{{ $item->axis }}</td>
                                                <td>{{ $item->addition }}</td>
                                                <td>{{ $item->dia }}</td>
                                                <td>{{ $item->thickness?->name }}</td>
                                                <td>{{ $item->product->name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>
                                                    {{ html()->select('lab_note_'.$item->id, $status, NULL)->class('form-control')->placeholder('Select') }}
                                                </td>
                                            </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                    <div class="raw mt-3">
                        <div class="col text-end">
                            {{ html()->button('Cancel')->class('btn btn-secondary')->attribute('onclick', 'window.history.back()')->attribute('type', 'button') }}
                            {{ html()->submit('Save and Print')->class('btn btn-submit btn-primary') }}
                        </div>
                    </div>
                    {{ html()->form()->close() }}
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
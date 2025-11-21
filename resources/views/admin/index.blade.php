@extends("admin.base")
@section("content")
<!-- Upcoming Appointments -->
<div class="col-12">
    <div class="border-top mb-4 pt-3">
        <h5 class="fw-medium text-uppercase mb-0">Upcoming Appointments</h5>
        <p class="fs-12">Showing appointments • Local time zone</p>
        <div class="row g-lg-4 g-3">
            <div class="col-lg-8">
                <table class="Data_Table table table-round align-middle mb-0 table-hover w-100 mt-2 border-top" id="apptTable">
                    <thead>
                        <tr>
                            <th class="py-2 fw-medium small text-uppercase">Date</th>
                            <th class="py-2 fw-medium small text-uppercase">Time</th>
                            <th class="py-2 fw-medium small text-uppercase">Patient</th>
                            <th class="py-2 fw-medium small text-uppercase">Doctor</th>
                            <th class="py-2 fw-medium small text-uppercase">Type</th>
                            <th class="py-2 fw-medium small text-uppercase">Status</th>
                            <th class="py-2 fw-medium small text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2025-08-30</td>
                            <td>10:00</td>
                            <td>Riya Patel</td>
                            <td>Dr. Mehta</td>
                            <td>General Checkup</td>
                            <td><span class="badge bg-success">Confirmed</span></td>
                            <td><button class="btn py-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></button></td>
                        </tr>
                        <tr>
                            <td>2025-08-30</td>
                            <td>14:30</td>
                            <td>Arjun Verma</td>
                            <td>Dr. Iyer</td>
                            <td>Cardiology</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td><button class="btn py-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></button></td>
                        </tr>
                        <tr>
                            <td>2025-08-31</td>
                            <td>09:15</td>
                            <td>Neha Singh</td>
                            <td>Dr. Khan</td>
                            <td>Dental</td>
                            <td><span class="badge bg-info text-dark">Rescheduled</span></td>
                            <td><button class="btn py-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></button></td>
                        </tr>
                        <tr>
                            <td>2025-09-01</td>
                            <td>11:45</td>
                            <td>Vikram Shah</td>
                            <td>Dr. Rao</td>
                            <td>Physiotherapy</td>
                            <td><span class="badge bg-success">Confirmed</span></td>
                            <td><button class="btn py-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></button></td>
                        </tr>
                        <tr>
                            <td>2025-09-02</td>
                            <td>16:00</td>
                            <td>Anita Desai</td>
                            <td>Dr. Kapoor</td>
                            <td>Dermatology</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td><button class="btn py-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></button></td>
                        </tr>
                        <tr>
                            <td>2025-08-30</td>
                            <td>10:00</td>
                            <td>Riya Patel</td>
                            <td>Dr. Mehta</td>
                            <td>General Checkup</td>
                            <td><span class="badge bg-success">Confirmed</span></td>
                            <td><button class="btn py-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></button></td>
                        </tr>
                        <tr>
                            <td>2025-08-30</td>
                            <td>14:30</td>
                            <td>Arjun Verma</td>
                            <td>Dr. Iyer</td>
                            <td>Cardiology</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td><button class="btn py-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></button></td>
                        </tr>
                        <tr>
                            <td>2025-08-31</td>
                            <td>09:15</td>
                            <td>Neha Singh</td>
                            <td>Dr. Khan</td>
                            <td>Dental</td>
                            <td><span class="badge bg-info text-dark">Rescheduled</span></td>
                            <td><button class="btn py-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></button></td>
                        </tr>
                        <tr>
                            <td>2025-08-30</td>
                            <td>10:00</td>
                            <td>Riya Patel</td>
                            <td>Dr. Mehta</td>
                            <td>General Checkup</td>
                            <td><span class="badge bg-success">Confirmed</span></td>
                            <td><button class="btn py-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></button></td>
                        </tr>
                        <tr>
                            <td>2025-08-30</td>
                            <td>14:30</td>
                            <td>Arjun Verma</td>
                            <td>Dr. Iyer</td>
                            <td>Cardiology</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                            <td><button class="btn py-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></button></td>
                        </tr>
                        <tr>
                            <td>2025-08-31</td>
                            <td>09:15</td>
                            <td>Neha Singh</td>
                            <td>Dr. Khan</td>
                            <td>Dental</td>
                            <td><span class="badge bg-info text-dark">Rescheduled</span></td>
                            <td><button class="btn py-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="row g-3">
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <span class="mb-2 badge bg-success tip-badge">Daily</span>
                                <h5>Hydration Habit</h5>
                                <p class="fs-12 lh-sm mb-0 text-muted">Aim for 6–8 glasses of water. Set hourly reminders.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <span class="mb-2 badge bg-primary tip-badge">Lifestyle</span>
                                <h5>Sleep Routine</h5>
                                <p class="fs-12 lh-sm mb-0 text-muted">Stick to consistent sleep and wake times; avoid screens 1 hour before bed.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <span class="mb-2 badge bg-warning text-dark tip-badge">Activity</span>
                                <h5>Move More</h5>
                                <p class="fs-12 lh-sm mb-0 text-muted">Target 30 minutes of moderate exercise at least 5 days a week.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-3 col-sm-6">
                        <div class="card rounded-4">
                            <div class="card-body p-lg-4">
                                <span class="mb-2 badge bg-info text-dark tip-badge">Mental</span>
                                <h5>Mindfulness Check</h5>
                                <p class="fs-12 lh-sm mb-0 text-muted">Try 5 minutes of deep breathing or meditation to reduce stress.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(!Session::has('branch'))
<div class="modal-onboarding modal fade animate__animated" id="branchSelector" tabindex="-1"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {{ html()->form('POST')->route('user.branch.update')->class('')->open() }}
            <div class="modal-body p-0">
                <div class="container row">
                    <div class="col">
                        <div class="control-group col-md-12">
                            <label for="roleEx3" class="form-label mt-3 req">Select Branch</label>
                            {{ html()->select($name = 'branch', $branches, old('branch'))->class('form-control')->placeholder('Select')->required() }}
                            @error('branch')
                            <small class="text-danger">{{ $errors->first('branch') }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-submit btn-primary">Update</button>
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
</div>
@endif
@endsection
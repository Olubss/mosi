@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Enrollment List'))

@section('header-title')
    <h3 class="title">{{ __('Enrollments') }}</h3>
@endsection

@section('content')
    <!-- ****Body-Section***** -->
    <div class="app-main-outer">
        <div class="app-main-inner">
            <div class="page-title-actions px-3 d-flex align-items-center justify-content-between flex-wrap gap-3">
                <nav aria-label="breadcrumb" class="modern-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fa-solid fa-house"></i>
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fa-solid fa-layer-group"></i>
                            {{ __('Enrollment') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>
            <div class="row">
                <div class="col-md-12 my-3">
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3 justify-content-between mb-4 align-items-center">
                                <!-- Left Buttons -->
                                <div class="d-flex align-items-center gap-2">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="submit"
                                            data-bs-toggle="dropdown">Export
                                            As</button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item fw-bold" href="#" id="exportCSV">{{ __('CSV File') }}</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item fw-bold" href="#" id="exportPDF">{{ __('PDF File') }}</a>
                                            </li>

                                            <form id="filterFormCSV" action="{{ route('enrollment.exportCSV') }}"
                                                method="GET" target="_blank">
                                                <input type="hidden" name="page" value="{{ request('page') ?? 1 }}" />
                                            </form>

                                            <form id="filterForm" action="{{ route('enrollment.generate.pdf') }}"
                                                method="GET" target="_blank">
                                                <input type="hidden" name="page" value="{{ request('page') ?? 1 }}" />
                                            </form>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Right Search & Refresh -->
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('enrollment.index') }}" method="GET" class="w-100">
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded ps-4"
                                                placeholder="🔍 Search ..." name="cat_search"
                                                value="{{ request('cat_search') }}">
                                            <button class="btn btn-primary rounded ms-2 shadow-sm" type="submit"
                                                style="width: 50px; height: 50px">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped align-middle modern-table">
                                    <thead>
                                        <tr>
                                            <th><strong>#</strong></th>
                                            <th><strong>{{ __('Enroll ID') }}</strong></th>
                                            <th><strong>{{ __('Student') }}</strong></th>
                                            <th><strong>{{ __('Course Title') }}</strong></th>
                                            <th style="width: 15%"><strong>{{ __('Progress') }}</strong></th>
                                            <th><strong>{{ __('Action') }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($enrollments as $enrollment)
                                            <tr class="fade-in-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="tableId">{{ generateID($enrollment->id) }}</td>
                                                <td>
                                                    <div
                                                        class="d-flex gap-2 align-items-center justify-content-start flex-wrap">
                                                        <div class="d-flex align-items-center justify-content-start">
                                                            <img src="{{ $enrollment->user?->profilePicturePath }}"
                                                                alt="image" width="30" height="30"
                                                                style="border-radius: 50%; object-fit: cover">
                                                        </div>
                                                        <h6 class="m-0 p-0">{{ $enrollment->user?->name ?? 'N/A' }}</h6>
                                                    </div>
                                                </td>
                                                <td class="tableProduct">
                                                    <div class="product-pera">
                                                        <p class="priceDis">
                                                            @if (strlen($enrollment->course?->title) > 30)
                                                                {{ substr($enrollment->course?->title, 0, 30) . '...' }}
                                                            @else
                                                                {{ $enrollment->course?->title ?? 'N/A' }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="tableId">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="fw-bold text-primary"
                                                            style="font-size: 0.5rem ; line-height: 0.5rem;">{{ $enrollment->course_progress ?? 'N/A' }}</span>
                                                        <div class="progress w-75">
                                                            <div class="progress-bar bg-primary progress-bar-animated progress-bar-striped"
                                                                role="progressbar"
                                                                aria-valuenow="{{ $enrollment->course_progress }}"
                                                                aria-valuemin="0" aria-valuemax="100"
                                                                style="width: {{ $enrollment->course_progress }}%;">
                                                                {{ $enrollment->course_progress }}%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="d-flex gap-2 align-items-center">
                                                    @if ($enrollment->trashed())
                                                        <a class="drop-item tooltip-custom"
                                                            href="{{ route('enrollment.restore', $enrollment->id) }}"
                                                            target="_blank">
                                                            <i class="fa-solid fa-rotate me-1 text-danger"></i>
                                                            <span
                                                                class="tooltip-text">{{ __('Restore Enrollment') }}</span>
                                                        </a>
                                                    @else
                                                        <a class="drop-item tooltip-custom" href="javascript::void(0)"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#enrollmentOverview{{ $enrollment->id }}">
                                                            <i class="fa-regular fa-eye me-1 text-primary"></i>
                                                            <span class="tooltip-text">{{ __('Overview') }}</span>
                                                        </a>
                                                        <a class="drop-item tooltip-custom"
                                                            href="{{ route('enrollment.suspended', $enrollment->id) }}"
                                                            target="_blank">
                                                            <i class="bi bi-dash-circle text-warning me-1"></i>
                                                            <span
                                                                class="tooltip-text">{{ __('Suspend Enrollment') }}</span>
                                                        </a>
                                                        <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                            onclick="deleteAction('{{ route('enrollment.destroy', $enrollment->id) }}')">
                                                            <i class="fa-solid fa-trash-can me-1 text-danger"></i>
                                                            <span
                                                                class="tooltip-text">{{ __('Delete Enrollment') }}</span>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>

                                            {{-- certificate name change --}}
                                            <!-- Modal -->
                                            <div class="modal fade" id="certificateModal{{ $enrollment->id }}"
                                                tabindex="-1" aria-labelledby="certificateModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="certificateModalLabel">Change
                                                                Student
                                                                Name</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('enrollment.enrollment.update_certificate_name', $enrollment->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                {{-- <input type="hidden" id="studentId"> --}}
                                                                <div class="mb-3">
                                                                    <label for="studentName" class="form-label">Student
                                                                        Name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="student_name" id="studentName"
                                                                        value="{{ $enrollment->certificate_user_name ?? 'N/A' }}">
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit"
                                                                        class="btn btn-secondary btn-sm">Save
                                                                        Changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- enrollment overview modal start -->
                                            <div class="modal fade" id="enrollmentOverview{{ $enrollment->id }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                {{ __('Enroll ID') }} #{{ $enrollment->id }}
                                                            </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12 py-1">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="me-3">
                                                                            <h5 class="mb-0">{{ __('Student') }}:</h5>
                                                                        </div>
                                                                        <div>
                                                                            <p
                                                                                class="mb-0 d-flex gap-2 align-items-center">
                                                                                <img src="{{ $enrollment->user?->profilePicturePath }}"
                                                                                    alt="image" width="30"
                                                                                    height="30"
                                                                                    style="border-radius: 50%; object-fit: cover">
                                                                                {{ $enrollment->user->name }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 py-1">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="me-3">
                                                                            <h5 class="mb-0">{{ __('Course Title') }}:
                                                                            </h5>
                                                                        </div>
                                                                        <div>
                                                                            <p class="mb-0">
                                                                                {{ $enrollment->course?->title }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 py-1">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <h5 class="mb-0">{{ __('Progress') }}:</h5>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-0">
                                                                            {{ $enrollment->course_progress }}%</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 py-1">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <h5 class="mb-0">{{ __('Course Price') }}:</h5>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-0">
                                                                            {{ currency($enrollment->course_price) }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-12 py-1">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <h5 class="mb-0">{{ __('Transaction Amount') }}:
                                                                        </h5>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-0">
                                                                            {{ currency($enrollment?->transactions->first()?->payment_amount ?? 0.0) }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 py-1">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <h5 class="mb-0">{{ __('Last Activity') }}:</h5>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-0">
                                                                            {{ $enrollment->last_activity ?? 'N/A' }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-12 py-1">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <h5 class="mb-0">{{ __('Status') }}:</h5>
                                                                    </div>
                                                                    <div>
                                                                        @if ($enrollment->trashed())
                                                                            <div class="statusItem">
                                                                                <div class="circleDot animatedPending">
                                                                                </div>
                                                                                <div class="statusText">
                                                                                    <span
                                                                                        class="stutsPanding">{{ __('Deleted') }}</span>
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <div class="statusItem">
                                                                                <div class="circleDot animatedCompleted">
                                                                                </div>
                                                                                <div class="statusText">
                                                                                    <span
                                                                                        class="stutsCompleted">{{ __('Active') }}</span>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- enrollment overview modal end -->
                                        @empty
                                            <tr>
                                                <td colspan="9">
                                                    <h5 class="text-danger text-center m-0">
                                                        {{ __('No Enrollment Available') }}</h5>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $enrollments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ****End-Body-Section**** -->
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('exportCSV').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('filterFormCSV').submit();
        });

        document.getElementById('exportPDF').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('filterForm').submit();
        });
    </script>
@endpush

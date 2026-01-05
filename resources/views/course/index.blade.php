@extends($layout_path)

@section('title', $app_setting['name'] . ' | Course List')

@section('header-title')
    <h3 class="title">{{ __('Course List') }}</h3>
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
                            <i class="fa-solid fa-book"></i>
                            {{ __('Course') }}
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
                    <div class="card shadow-lg border-0 rounded-3 mb-5">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3 justify-content-between mb-4 align-items-center">

                                <!-- Left Buttons -->
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('course.create') }}"
                                        class="btn btn-primary btn-sm px-4 py-2 shadow-sm rounded-pill">
                                        <i class="fa-solid fa-plus me-1"></i> {{ __('New Course') }}
                                    </a>
                                    <a href="{{ route('course.restore.list') }}"
                                        class="btn btn-outline-warning btn-sm px-4 py-2 shadow-sm rounded-pill">
                                        <i class="bi bi-arrow-clockwise me-1"></i> {{ __('Restore Course') }}
                                    </a>
                                </div>

                                <!-- Right Search & Refresh -->
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('course.index') }}" method="GET" class="w-100">
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded ps-4"
                                                placeholder="🔍 Search course..." name="cat_search"
                                                value="{{ request('cat_search') }}">
                                            <button class="btn btn-primary rounded ms-2 shadow-sm" type="submit"
                                                style="width: 50px; height: 50px">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive-xl">
                                <table class="table table-striped align-middle modern-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('ID') }}</th>
                                            <th>{{ __('Free & Publish') }}</th>
                                            <th>{{ __('Course') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Instructor') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="courseTable">
                                        @forelse ($courses as $course)
                                            <tr class="fade-in-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ generateID($course->id) }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-start gap-2 align-items-center">
                                                        <input type="radio" class="form-check-input"
                                                            name="exampleRadios{{ $course->id }}"
                                                            onclick="sureAction('{{ route('course.free', $course->id) }}')"
                                                            {{ $course->is_free ? 'checked' : '' }}>
                                                        <span
                                                            class="badge {{ $course->is_free ? 'bg-success' : 'bg-dark' }}">
                                                            {{ $course->is_free ? 'Free' : 'Paid' }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('course.show', $course->id) }}" target="_blank"
                                                        class="d-flex align-items-center text-decoration-none">
                                                        <img src="{{ $course->mediaPath }}"
                                                            class="rounded-circle me-3 shadow-sm"
                                                            style="width:30px; height:30px; object-fit:cover;">
                                                        <span class="fw-semibold text-dark">
                                                            {{ strlen($course->title) > 20 ? substr($course->title, 0, 20) . '...' : $course->title }}
                                                        </span>
                                                    </a>
                                                </td>
                                                <td class="fw-bold">
                                                    @if ($app_setting['currency_position'] == 'Left')
                                                        {{ $app_setting['currency_symbol'] }}{{ $course->price ?? $course->regular_price }}
                                                    @else
                                                        {{ $course->price ?? $course->regular_price }}{{ $app_setting['currency_symbol'] }}
                                                    @endif
                                                </td>
                                                <td>{{ $course->instructor?->user?->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($course->is_active == false)
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedPending"></div>
                                                            <div class="statusText">
                                                                <span class="stutsPanding">{{ __('Pending') }}</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedCompleted"></div>
                                                            <div class="statusText">
                                                                <span class="stutsCompleted">{{ __('Active') }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="drop-item tooltip-custom"
                                                        href="{{ route('course.show', $course->id) }}">
                                                        <i class="fa-regular fa-eye me-1 text-primary"></i>
                                                        <span class="tooltip-text">{{ __('View Course') }}</span>
                                                    </a>
                                                    <a class="drop-item tooltip-custom"
                                                        href="{{ route('course.edit', $course->id) }}" target="_blank">
                                                        <i class="fa-solid fa-pen-to-square me-1 text-warning"></i>
                                                        <span class="tooltip-text">{{ __('Edit Course') }}</span>
                                                    </a>
                                                    <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                        onclick="deleteAction('{{ route('course.destroy', $course->id) }}')">
                                                        <i class="fa-solid fa-trash-can me-1 text-danger"></i>
                                                        <span class="tooltip-text">{{ __('Delete Course') }}</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-danger py-4">
                                                    {{ __('No course data found') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $courses->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- ****End-Body-Section**** -->
    </div>
@endsection

@extends($layout_path)

@section('title', $app_setting['name'] . ' | Course List')

@section('header-title')
    <h3 class="title">{{ __('Trashed Courses') }}</h3>
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
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3 justify-content-between mb-4 align-items-center">

                                <!-- Left Buttons -->
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('course.create') }}"
                                        class="btn btn-primary btn-sm px-4 py-2 shadow-sm rounded-pill">
                                        <i class="fa-solid fa-plus me-1"></i> {{ __('New Course') }}
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
                            <div class="table-responsive-xl">
                                <table class="table table-striped align-middle modern-table">
                                    <thead>
                                        <tr>
                                            <th><strong>#</strong></th>
                                            <th><strong>ID</strong></th>
                                            <th><strong>Free & Publish</strong></th>
                                            <th><strong>Course</strong></th>
                                            <th><strong>Price</strong></th>
                                            <th><strong>Instructor</strong></th>
                                            <th><strong>Status</strong></th>
                                            <th><strong>Action</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($courses as $course)
                                            <tr class="fade-in-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ generateID($course->id) }}
                                                </td>
                                                <td>
                                                    <div
                                                        class="d-flex
                                    justify-content-start gap-2">
                                                        <input data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="{{ $course->is_free ? 'Free' : 'Paid' }}"
                                                            href="#" class="form-check-input" type="radio"
                                                            name="exampleRadios{{ $course->id }}" id="courseFreeRadio"
                                                            onclick="sureAction('{{ route('course.free', $course->id) }}')"
                                                            {{ $course->is_free ? 'checked' : '' }}>
                                                        <span
                                                            class="badge {{ $course->is_free ? 'bg-success' : 'bg-dark' }}">{{ $course->is_free ? 'Free' : 'Paid' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="listproduct-section">
                                                        <div class="courseImage">
                                                            <img src="{{ $course->mediaPath }}"
                                                                class="img-fluid w-100 h-100 object-fit-cover rounded-circle">
                                                        </div>
                                                        <div class="product-pera">
                                                            <p class="priceDis">
                                                                @if (strlen($course->title) > 20)
                                                                    {{ substr($course->title, 0, 20) . '...' }}
                                                                @else
                                                                    {{ $course->title }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($app_setting['currency_position'] == 'Left')
                                                        {{ $app_setting['currency_symbol'] }}{{ $course->price ? $course->price : $course->regular_price }}
                                                    @else
                                                        {{ $course->price ? $course->price : $course->regular_price }}{{ $app_setting['currency_symbol'] }}
                                                    @endif
                                                </td>
                                                <td>{{ $course->instructor->user->name }}</td>
                                                <td>
                                                    @if ($course->trashed())
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedPending"></div>
                                                            <div class="statusText">
                                                                <span class="stutsPanding">Deleted</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedCompleted"></div>
                                                            <div class="statusText">
                                                                <span class="stutsCompleted">Active</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                        onclick="restoreAction('{{ route('course.restore', $course->id) }}')">
                                                        <i class="fa-solid fa-rotate me-1 text-danger"></i>
                                                        <span class="tooltip-text">{{ __('Restore Course') }}</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-danger">
                                                    {{ __('No data found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $courses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ****End-Body-Section**** -->
    </div>
@endsection

@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Select Exam Course'))

@section('header-title')
    <h3 class="title">{{ __('Select a course to view exams') }}</h3>
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
                            {{ __('Select Course to view Exams') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>

            <div class="row" id="deleteTableItem">
                <div class="col-md-12 my-3">
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3 justify-content-end mb-4 align-items-center">
                                <!-- Right Search & Refresh -->
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('exam.select_course') }}" method="GET" class="w-100">
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded ps-4"
                                                placeholder="🔍 Search..." name="cat_search"
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
                                            <th><strong>{{ __('Thumbnail') }}</strong></th>
                                            <th><strong>{{ __('Course Name') }}</strong></th>
                                            <th><strong>{{ __('Category') }}</strong></th>
                                            <th><strong>{{ __('Price') }}</strong></th>
                                            <th><strong>{{ __('Action') }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($courses as $course)
                                            <tr class="fade-in-row">
                                                <td>
                                                    <div class="d-flex justify-content-start align-items-center">
                                                        <img src="{{ $course?->mediaPath }}" width="100%" height="40"
                                                            alt="image" style="border-radius: 4px; object-fit: cover">
                                                    </div>
                                                </td>
                                                <td class="tableProduct">
                                                    <div class="product-pera">
                                                        <a href="{{ route('course.edit', $course->id) }}"
                                                            class="priceDis">{{ $course?->title }}</a>
                                                    </div>
                                                </td>
                                                <td class="tableId">{{ $course->category?->title }}</td>
                                                <td class="tableId">
                                                    @php
                                                        $price =
                                                            $course->price && $course->regular_price
                                                                ? $course->price
                                                                : $course->regular_price;
                                                    @endphp
                                                    @if ($app_setting['currency_position'] == 'Left')
                                                        {{ $app_setting['currency_symbol'] }}{{ $price }}
                                                    @else
                                                        {{ $price }}{{ $app_setting['currency_symbol'] }}
                                                    @endif
                                                </td>
                                                <td style="min-width: 120px;">
                                                    <a class="action-icon btn-outline-primary d-flex justify-content-center p-2 rounded-3"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-custom-class="custom-tooltip"
                                                        data-bs-title="{{ __('View Exams') }}"
                                                        href="{{ route('exam.index', $course->id) }}">
                                                        {{ __('View Exams') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <h5 class="text-danger text-center m-0">{{ __('No Course Available') }}
                                                    </h5>
                                                </td>
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

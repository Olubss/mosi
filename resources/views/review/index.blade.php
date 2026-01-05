@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Review List'))

@section('header-title')
    <h3 class="title">{{ __('Reviews') }}</h3>
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
                            {{ __('Review') }}
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
                                    <form action="{{ route('review.index') }}" method="GET" class="w-100">
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
                                            <th><strong>{{ __('Course Name') }}</strong></th>
                                            <th><strong>{{ __('Student') }}</strong></th>
                                            <th><strong>{{ __('Rating') }}</strong></th>
                                            <th><strong>{{ __('Comment') }}</strong></th>
                                            <th><strong>{{ __('Action') }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($reviews as $review)
                                            <tr class="fade-in-row">
                                                <td>{{ generateID($review->id) }}</td>
                                                <td class="fw-bold">
                                                    @if (strlen($review->course?->title) > 30)
                                                        {{ substr($review->course?->title, 0, 30) . '...' }}
                                                    @else
                                                        {{ $review->course?->title ?? 'N/A' }}
                                                    @endif
                                                </td>
                                                <td class="tableId">{{ $review->user?->name }}</td>
                                                <td class="tableId">
                                                    @php
                                                        $rating = $review->rating;
                                                        $fullStars = floor($rating);
                                                        $hasHalfStar = $rating - $fullStars >= 0.5;
                                                    @endphp

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $fullStars)
                                                            <i class="bi bi-star-fill bs-gold-star"></i>
                                                        @elseif ($hasHalfStar && $i == ceil($rating))
                                                            <i class="bi bi-star-half bs-gold-star"></i>
                                                        @else
                                                            <i class="bi bi-star bs-gold-star"></i>
                                                        @endif
                                                    @endfor
                                                </td>

                                                <td class="tableId">
                                                    @if (strlen($review->comment) > 50)
                                                        {{ substr($review->comment, 0, 50) . '...' }}
                                                    @else
                                                        {{ $review->comment }}
                                                    @endif
                                                </td>

                                                <td class="tableAction">
                                                    <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                        onclick="deleteAction('{{ route('review.destroy', $review->id) }}')">
                                                        <i class="fa-solid fa-trash-can me-1 text-danger"></i>
                                                        <span class="tooltip-text">{{ __('Delete Review') }}</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">
                                                    <h5 class="text-danger text-center m-0">{{ __('No data Available') }}
                                                    </h5>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $reviews->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ****End-Body-Section**** -->
    </div>
@endsection

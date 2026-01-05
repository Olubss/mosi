@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Testimonial List'))

@section('header-title')
    <h3 class="title">{{ __('Testimonial Management') }}</h3>
@endsection

@section('content')

    <div class="app-main-outer">
        <div class="app-main-inner">
            {{-- top --}}
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
                            {{ __('Testimonial') }}
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
                            <div class="d-flex flex-wrap gap-3 justify-content-between mb-4 align-items-center">

                                <!-- Left Buttons -->
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('testimonial.create') }}"
                                        class="btn btn-primary btn-sm px-4 py-2 shadow-sm rounded-pill">
                                        <i class="fa-solid fa-plus me-1"></i> {{ __('Add New Testimonial') }}
                                    </a>
                                </div>

                                <!-- Right Search & Refresh -->
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('testimonial.index') }}" method="GET" class="w-100">
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
                            <div class="table-responsive-lg">
                                <table class="table table-striped align-middle modern-table">
                                    <thead>
                                        <tr>
                                            <th><strong>#</strong></th>
                                            <th><strong>{{ __('Name') }}</strong></th>
                                            <th><strong>{{ __('Designation') }}</strong></th>
                                            <th><strong>{{ __('Review') }}</strong></th>
                                            <th><strong>{{ __('Status') }}</strong></th>
                                            <th><strong>{{ __('Action') }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($testimonials as $testimonial)
                                            <tr class="fade-in-row">
                                                <td>{{ generateID($testimonial->id) }}</td>
                                                <td>
                                                    <div
                                                        class="d-flex justify-content-start align-items-center gap-3 flex-wrap">
                                                        <div class="d-flex align-items-center justify-content-start">
                                                            <img src="{{ $testimonial->mediaPath }}" alt="image"
                                                                width="30" height="30"
                                                                style="border-radius: 50%; object-fit: cover">
                                                        </div>
                                                        <p class="priceDis">{{ ucwords($testimonial->name) }}</p>
                                                    </div>
                                                </td>

                                                <td>
                                                    {{ ucwords($testimonial->designation) }}
                                                </td>

                                                <td>
                                                    @php
                                                        $rating = $testimonial->rating;
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

                                                <td>
                                                    @if (!$testimonial->is_active)
                                                        <div
                                                            class="statusItem d-flex justify-content-start align-items-center">
                                                            <div class="circleDot animatedPending"></div>
                                                            <div class="statusText">
                                                                <span class="stutsPanding">{{ __('Pending') }}</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div
                                                            class="statusItem d-flex justify-content-start align-items-center">
                                                            <div class="circleDot animatedCompleted"></div>
                                                            <div class="statusText">
                                                                <span class="stutsCompleted">{{ __('Active') }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($testimonial->trashed())
                                                        <a class="drop-item tooltip-custom"
                                                            href="{{ route('testimonial.restore', $testimonial->id) }}">
                                                            <i class="fa-solid fa-rotate me-1 text-danger"></i>
                                                            <span class="tooltip-text">{{ __('Restore Testimonial') }}</span>
                                                        </a>
                                                    @else
                                                        <a class="drop-item tooltip-custom"
                                                            href="{{ route('testimonial.edit', $testimonial->id) }}"
                                                            target="_blank">
                                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i>
                                                            <span class="tooltip-text">{{ __('Edit Testimonial') }}</span>
                                                        </a>
                                                        <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                            onclick="deleteAction('{{ route('testimonial.destroy', $testimonial->id) }}')">
                                                            <i class="fa-solid fa-trash-can me-1 text-danger"></i>
                                                            <span
                                                                class="tooltip-text">{{ __('Delete Testimonial') }}</span>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">
                                                    <h5 class="text-danger text-center m-0">
                                                        {{ __('No Queries Available') }}</h5>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $testimonials->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- bottom --}}
        </div>
    </div>


@endsection

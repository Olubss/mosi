@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Admin Organization Plan'))

@section('header-title')
    <h3 class="title">{{ __('Organization Plans') }}</h3>
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
                            {{ __('Organization Plans') }}
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
                            <div class="table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><strong>#</strong></th>
                                            <th><strong>{{ __('Title') }}</strong></th>
                                            <th><strong>{{ __('Price') }}</strong></th>
                                            <th><strong>{{ __('Type') }}</strong></th>
                                            <th><strong>{{ __('Active Status') }}</strong></th>
                                            <th><strong>{{ __('Action') }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($plans as $plan)
                                            <tr>
                                                <td>{{ generateID($plan->id) }}</td>
                                                <td class="tableId fw-bold">{{ $plan->title }}</td>
                                                <td class="tableId fw-bold">{{ currency($plan->price) }}</td>
                                                <td class="tableId">
                                                    <span
                                                        class="border px-2 py-1 rounded text-capitalize {{ $plan->plan_type == 'yearly' ? 'border-warning text-warning' : 'border-success text-success' }}">
                                                        {{ $plan->plan_type }}
                                                    </span>
                                                </td>
                                                <td class="tableId">
                                                    @if (!$plan->is_active)
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedPending"></div>
                                                            <div class="statusText">
                                                                <span class="stutsPanding">{{ __('De-Activated') }}</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedCompleted"></div>
                                                            <div class="statusText">
                                                                <span class="stutsCompleted">{{ __('Activated') }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="tableAction">
                                                    <a class="drop-item tooltip-custom"
                                                        href="{{ route('organizations.plan.edit', $plan->id) }}"
                                                        target="_blank">
                                                        <i class="fa-solid fa-pen-to-square me-1 text-warning"></i>
                                                        <span class="tooltip-text">{{ __('Edit Plan') }}</span>
                                                    </a>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="7">
                                                    <h5 class="text-danger text-center m-0">
                                                        {{ __('No Plans Available') }}</h5>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- {{ $requests->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ****End-Body-Section**** -->
    </div>
@endsection

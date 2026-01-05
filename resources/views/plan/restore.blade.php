@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Subscription Trash List'))

@section('header-title')
    <h3 class="title">{{ __('Subscription Trash List') }}</h3>
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
                            {{ __('Plan Trash') }}
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
                                <table class="table table-striped align-middle modern-table">
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
                                            <tr class="fade-in-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="tableId fw-bold">{{ $plan->title }}</td>
                                                <td class="tableId fw-bold">{{ currency($plan->price) }}</td>
                                                <td class="tableId">
                                                    <span
                                                        class="badge {{ $plan->plan_type == 'yearly' ? 'bg-warning' : 'bg-success' }}">
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
                                                    <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                        onclick="restoreAction('{{ route('plan.restore', $plan->id) }}')">
                                                        <i class="fa-solid fa-rotate me-1 text-danger"></i>
                                                        <span class="tooltip-text">{{ __('Restore') }}</span>
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

@push('styles')
    <style>
        .break {
            border-top: 1px solid #f1f1f1;
            margin: 20px 0;
            width: 100%;
        }

        .planOverviewModal .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .planOverviewModal .modal-title {
            font-weight: bold;
        }

        .planOverviewModal .info-label {
            font-weight: 600;
            color: #6c757d;
            width: 120px;
        }

        .planOverviewModal .info-value {
            font-weight: 500;
            color: #212529;
        }

        .planOverviewModal .info-row {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .planOverviewModal .statusItem {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .planOverviewModal .circleDot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .planOverviewModal .animatedCompleted {
            background-color: #28a745;
            animation: pulse-green 1.5s infinite;
        }

        .planOverviewModal .animatedPending {
            background-color: #dc3545;
            animation: pulse-red 1.5s infinite;
        }

        @keyframes pulse-green {
            0% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.5);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
            }
        }

        @keyframes pulse-red {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.5);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        .planOverviewModal .student-img {
            border-radius: 50%;
            object-fit: cover;
            width: 40px;
            height: 40px;
            border: 1px solid #ccc;
        }
    </style>
@endpush

@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Newslatter Subscribers'))

@section('header-title')
    <h3 class="title">{{ __('Newslatter Subscribers') }}</h3>
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
                            {{ __('Newslatter Subscribers') }}
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
                            <div class="table-responsive">
                                <table class="table table-striped align-middle modern-table">
                                    <thead>
                                        <tr>
                                            <th><strong>#</strong></th>
                                            <th><strong>{{ __('ID') }}</strong></th>
                                            <th><strong>{{ __('Email') }}</strong></th>
                                            <th><strong>{{ __('Status') }}</strong></th>
                                            @if (Auth::user()->hasRole('admin'))
                                                <th><strong>{{ __('Action') }}</strong></th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($subscribers as $subscribe)
                                            <tr class="fade-in-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ generateID($subscribe->id) }}</td>
                                                <td class="tableId">{{ $subscribe->email }}</td>

                                                <td class="tableStatus">
                                                    @if ($subscribe->status == 0)
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
                                                @if (Auth::user()->hasRole('admin'))
                                                    <td class="tableAction">
                                                        @if ($subscribe->trashed())
                                                            <a class="drop-item tooltip-custom"
                                                                href="{{ route('newslatter.restore', $subscribe->id) }}"
                                                                target="_blank">
                                                                <i class="fa-solid fa-rotate me-1 text-danger"></i>
                                                                <span class="tooltip-text">{{ __('Restore Subscriber') }}</span>
                                                            </a>
                                                        @else
                                                            <a class="drop-item tooltip-custom"
                                                                href="{{ route('newslatter.send.mail', $subscribe->id) }}">
                                                                <i class="fa-solid fa-paper-plane me-1 text-primary"></i>
                                                                <span
                                                                    class="tooltip-text">{{ __('Send Welcome Mail') }}</span>
                                                            </a>
                                                            <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                                onclick="deleteAction('{{ route('newslatter.delete', $subscribe->id) }}')">
                                                                <i class="fa-solid fa-trash-can me-1 text-danger"></i>
                                                                <span
                                                                    class="tooltip-text">{{ __('Delete Subscriber') }}</span>
                                                            </a>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9">
                                                    <h5 class="text-danger text-center m-0">
                                                        {{ __('No Subscriber Available') }}
                                                    </h5>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $subscribers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ****End-Body-Section**** -->
    </div>
@endsection

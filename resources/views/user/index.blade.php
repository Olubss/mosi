@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('User List'))

@section('header-title')
    <h3 class="title">{{ __('Students Management') }}</h3>
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
                            {{ __('Students') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>

            <div class="row" id="deleteTableItem">
                <div class="col-md-12">
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3 justify-content-between mb-4 align-items-center">

                                <!-- Left Buttons -->
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('user.create') }}"
                                        class="btn btn-shadow btn-outline-primary rounded-pill">
                                        {{ __('+ New Student') }}
                                    </a>
                                </div>

                                <!-- Right Search & Refresh -->
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('user.index') }}" method="GET" class="w-100">
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
                                            <th><strong>{{ __('ID') }}</strong></th>
                                            <th><strong>{{ __('Name') }}</strong></th>
                                            <th><strong>{{ __('Email') }}</strong></th>
                                            <th><strong>{{ __('Phone') }}</strong></th>
                                            <th><strong>{{ __('Account Verified') }}</strong></th>
                                            <th><strong>{{ __('Status') }}</strong></th>
                                            @if (Auth::user()->hasRole('admin') ||
                                                    Auth::user()->hasRole('organization') ||
                                                    Auth::user()->is_admin ||
                                                    Auth::user()->is_org)
                                                <th><strong>{{ __('Action') }}</strong></th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                            <tr class="fade-in-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ generateID($user->id) }}</td>
                                                <td class="tableId">
                                                    <div class="d-flex justify-content-start align-items-center gap-2">
                                                        <div class="d-flex justify-content-start align-items-center"
                                                            style="width: 30px; height: 30px">
                                                            <img src="{{ $user->profilePicturePath }}"
                                                                class="w-100 h-100 object-fit-cover rounded-circle">
                                                        </div>
                                                        <p class="priceDis">{{ $user->name }}</p>
                                                    </div>
                                                </td>
                                                <td class="tableId">{{ $user->email }}</td>
                                                <td class="tableId">{{ $user->phone }}</td>
                                                <td class="tableCustomar">
                                                    @if ($user->email_verified_at || $user->is_active)
                                                        <span
                                                            class="badge rounded-pill text-bg-success">{{ __('Yes') }}</span>
                                                    @else
                                                        <span
                                                            class="badge rounded-pill text-bg-danger">{{ __('No') }}</span>
                                                    @endif
                                                </td>
                                                <td class="tableStatus">
                                                    @if ($user->trashed())
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedPending"></div>
                                                            <div class="statusText">
                                                                <span class="stutsPanding">{{ __('Deleted') }}</span>
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
                                                @if (Auth::user()->hasRole('admin') ||
                                                        Auth::user()->hasRole('organization') ||
                                                        Auth::user()->is_admin ||
                                                        Auth::user()->is_org)
                                                    <td class="tableAction">
                                                        <div class="d-flex align-items-center gap-2">
                                                            @if ($user->trashed())
                                                                <a class="drop-item tooltip-custom"
                                                                    href="{{ route('user.restore', $user->id) }}"
                                                                    target="_blank">
                                                                    <i class="fa-solid fa-rotate me-1 text-danger"></i>
                                                                    <span
                                                                        class="tooltip-text">{{ __('Restore User') }}</span>
                                                                </a>
                                                            @else
                                                                <a class="drop-item tooltip-custom"
                                                                    href="{{ route('user.edit', $user->id) }}"
                                                                    target="_blank">
                                                                    <i
                                                                        class="fa-solid fa-pen-to-square me-1 text-warning"></i>
                                                                    <span class="tooltip-text">{{ __('Edit User') }}</span>
                                                                </a>
                                                                @if (!$user->is_admin && !$user->instructor)
                                                                    <a class="drop-item tooltip-custom"
                                                                        href="{{ route('user.edit', $user->id) }}"
                                                                        target="_blank">
                                                                        <i class="bi bi-person-fill-up me-1 text-dark"></i>
                                                                        <span
                                                                            class="tooltip-text">{{ __('Promote User') }}</span>
                                                                    </a>
                                                                @endif
                                                                @if ($user->id != Auth::user()->id && !$user->is_admin)
                                                                    <a class="drop-item tooltip-custom"
                                                                        href="javascript:void(0)"
                                                                        onclick="deleteAction('{{ route('user.destroy', $user->id) }}')">
                                                                        <i
                                                                            class="bi bi-person-fill-slash me-1 text-danger"></i>
                                                                        <span
                                                                            class="tooltip-text">{{ __('Suspend User') }}</span>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9">
                                                    <h5 class="text-danger text-center m-0">{{ __('No User Available') }}
                                                    </h5>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ****End-Body-Section**** -->
    </div>
@endsection

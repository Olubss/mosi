@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Authorized Organization'))

@section('header-title')
    <h3 class="title">{{ __('Authorized Organization') }}</h3>
@endsection

@section('content')
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
                            {{ __('Authorized Organization') }}
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
                                    <form action="{{ route('organizations.index') }}" method="GET" class="w-100">
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded ps-4"
                                                placeholder="🔍 Search ..." name="search" value="{{ request('search') }}">
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
                                            <th><strong>{{ __('Author Name') }}</strong></th>
                                            <th><strong>{{ __('Company Name') }}</strong></th>
                                            <th><strong>{{ __('Email') }}</strong></th>
                                            <th><strong>{{ __('Domain Address') }}</strong></th>
                                            <th><strong>{{ __('Account Verified') }}</strong></th>
                                            @if (Auth::user()->hasRole('admin') || Auth::user()->is_admin)
                                                <th><strong>{{ __('Action') }}</strong></th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users ?? [] as $user)
                                            <tr class="fade-in-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ generateID($user->id) }}</td>
                                                <td class="tableId">
                                                    <div
                                                        class="d-flex justify-content-start align-items-center gap-2 flex-wrap">
                                                        <div class="d-flex justify-content-start align-items-center"
                                                            style="width: 30px; height: 30px">
                                                            <img src="{{ $user->user->profilePicturePath }}"
                                                                class="w-100 h-100 object-fit-cover rounded-circle">
                                                        </div>
                                                        <p class="priceDis">{{ $user->user->name }}</p>
                                                    </div>
                                                </td>
                                                <td class="tableId">
                                                    {{ $user->name }}
                                                </td>
                                                <td class="tableId">{{ $user->user->email }}</td>
                                                <td class="tableId">
                                                    <span
                                                        class="border px-2 py-1 rounded text-primary fw-bold text-truncate border-primary">{{ $user->domain ?? 'N/A' }}</span>
                                                </td>
                                                <td class="tableStatus">
                                                    @if ($user->user->email_verified_at == null)
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
                                                                <span class="stutsCompleted">{{ __('Verified') }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                @if (Auth::user()->hasRole('admin') ||
                                                        Auth::user()->hasRole('organization') ||
                                                        Auth::user()->is_admin ||
                                                        Auth::user()->is_org)
                                                    <td class="tableAction">
                                                        <div class="action-icon">
                                                            @if ($user->trashed())
                                                                <a class="drop-item tooltip-custom"
                                                                    href="{{ route('user.restore', $user->id) }}"
                                                                    target="_blank">
                                                                    <i class="fa-solid fa-rotate me-1 text-danger"></i>
                                                                    <span class="tooltip-text">{{ __('Restore') }}</span>
                                                                </a>
                                                            @else
                                                                <a class="drop-item tooltip-custom"
                                                                    href="{{ route('organizations.edit', $user->user->id) }}"
                                                                    target="_blank">
                                                                    <i class="fa-solid fa-pen-to-square me-1 text-warning"></i>
                                                                    <span class="tooltip-text">{{ __('Edit') }}</span>
                                                                </a>
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
                            {{-- {{ $users->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ****End-Body-Section**** -->
    </div>
@endsection

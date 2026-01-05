@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Featured Instructors'))

@section('header-title')
    <h3 class="title">{{ __('Featured Instructors') }}</h3>
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
                            {{ __('Featured Instructors') }}
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
                                    <a href="{{ route('instructor.create') }}"
                                        class="btn btn-primary btn-sm px-4 py-2 shadow-sm rounded-pill">
                                        <i class="fa-solid fa-plus me-1"></i> {{ __('New Instructor') }}
                                    </a>
                                </div>

                                <!-- Right Search & Refresh -->
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('instructor.featured') }}" method="GET" class="w-100">
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
                                            <th><strong>{{ __('User') }}</strong></th>
                                            <th><strong>{{ __('Email') }}</strong></th>
                                            <th><strong>{{ __('Title') }}</strong></th>
                                            <th><strong>{{ __('Is Featured') }}</strong></th>
                                            <th><strong>{{ __('Action') }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($instructors as $instructor)
                                            <tr class="fade-in-row">
                                                <td class="tableId">{{ generateID($loop->iteration) }}</td>
                                                <td class="tableProduct">
                                                    <div class="d-flex align-items-center flex-wrap gap-3">
                                                        <div class="d-flex justify-content-start align-items-center"
                                                            style="width: 30px; height: 30px;">
                                                            <img src="{{ $instructor->user->profilePicturePath }}"
                                                                alt="image" class="rounded w-100 h-100 object-fit-cover"
                                                                style="border-radius: 50%;">
                                                        </div>
                                                        <p class="priceDis">{{ $instructor->user->name }}</p>
                                                    </div>
                                                </td>
                                                <td class="tableId">{{ $instructor->user->email }}</td>
                                                <td class="tableId">{{ $instructor->title }}</td>
                                                <td class="tableStatus">
                                                    @if (!$instructor->is_featured)
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedPending"></div>
                                                            <div class="statusText">
                                                                <span class="statusPending">{{ __('Inactive') }}</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="statusItem">
                                                            <div class="circleDot animatedCompleted"></div>
                                                            <div class="statusText">
                                                                <span class="statusconfirm">{{ __('Active') }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="tableAction">
                                                    <div class="action-icon">
                                                        @if ($instructor->trashed())
                                                            <a class="drop-item tooltip-custom"
                                                                href="{{ route('instructor.restore', $instructor->id) }}">
                                                                <i
                                                                    class="fa-solid fa-arrow-rotate-left me-1 text-danger"></i>
                                                                <span
                                                                    class="tooltip-text">{{ __('Restore Instructor') }}</span>
                                                            </a>
                                                        @else
                                                            <a class="drop-item tooltip-custom"
                                                                href="{{ route('instructor.edit', $instructor->id) }}"
                                                                target="_blank">
                                                                <i class="fa-solid fa-pen-to-square me-1 text-warning"></i>
                                                                <span
                                                                    class="tooltip-text">{{ __('Edit Instructor') }}</span>
                                                            </a>
                                                            <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                                onclick="deleteAction('{{ route('instructor.destroy', $instructor->id) }}')">
                                                                <i class="fa-solid fa-trash-can me-1 text-danger"></i>
                                                                <span
                                                                    class="tooltip-text">{{ __('Suspend Instructor') }}</span>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7">
                                                    <h5 class="text-danger text-center m-0">
                                                        {{ __('No Instructor Available') }}</h5>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $instructors->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ****End-Body-Section**** -->
    </div>
@endsection

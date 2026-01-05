@extends($layout_path)

@section('title', $app_setting['name'] . ' | Chapter List')

@section('header-title')
    <h3 class="title">{{ __('Chapter - ') . $course->title }}</h3>
@endsection

@section('content')
    <!-- ****Body-Section***** -->
    <div class="app-main-outer">
        <div class="app-main-inner">
            <div class="page-title-actions px-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
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
                            {{ __('Chapter List') }}
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
                                    <a href="{{ route('chapter.create', $course->id) }}"
                                        class="btn btn-primary btn-sm px-4 py-2 shadow-sm rounded-pill">
                                        <i class="fa-solid fa-plus me-1"></i> {{ __('New Chapter') }}
                                    </a>
                                </div>

                                <!-- Right Search & Refresh -->
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('chapter.index', $course->id) }}" method="GET" class="w-100">
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded ps-4"
                                                placeholder="🔍 Search Chapter ..." name="cat_search"
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
                                            <th><strong>Chapter Title</strong></th>
                                            <th><strong>Sequence</strong></th>
                                            <th><strong>Number of Contents</strong></th>
                                            <th><strong>Action</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($chapters as $chapter)
                                            <tr class="fade-in-row">
                                                <td class="tableId">{{ generateID($loop->iteration) }}</td>
                                                <td class="tableId">
                                                    @if (strlen($chapter->title) > 50)
                                                        {{ substr($chapter->title, 0, 50) . '...' }}
                                                    @else
                                                        {{ $chapter->title }}
                                                    @endif
                                                </td>
                                                <td class="tableId">{{ $chapter->serial_number }}</td>
                                                <td class="tableId">{{ $chapter->contents->count() }}</td>
                                                <td class="tableAction">
                                                    <a class="drop-item tooltip-custom"
                                                        href="{{ route('chapter.edit', $chapter->id) }}" target="_blank">
                                                        <i class="fa-solid fa-pen-to-square me-1 text-warning"></i>
                                                        <span class="tooltip-text">{{ __('Edit Chapter') }}</span>
                                                    </a>
                                                    <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                        onclick="deleteAction('{{ route('chapter.destroy', $chapter->id) }}')">
                                                        <i class="fa-solid fa-trash-can me-1 text-danger"></i>
                                                        <span class="tooltip-text">{{ __('Delete Chapter') }}</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <h5 class="text-danger text-center m-0">
                                                        {{ __('No Chapter Available') }}</h5>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $chapters->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ****End-Body-Section**** -->
    </div>
@endsection


@push('scripts')
    <script>
        let successMessage = localStorage.getItem('chapterSuccess');
        if (successMessage) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: `${successMessage}`,
            });

            localStorage.removeItem('chapterSuccess');
        }
    </script>
@endpush

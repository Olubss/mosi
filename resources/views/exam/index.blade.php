@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Exam List'))

@section('header-title')
    <h3 class="title">{{ __('Showing Exams for - ') . $course->title }}</h3>
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
                            {{ __('Exam List') }}
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
                                    <a href="{{ route('exam.create', $course->id) }}"
                                        class="btn btn-primary btn-sm px-4 py-2 shadow-sm rounded-pill">
                                        <i class="fa-solid fa-plus me-1"></i> {{ __('New Exam') }}
                                    </a>
                                </div>
                                <!-- Right Search & Refresh -->
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('exam.index', $course->id) }}" method="GET" class="w-100">
                                        <div class="input-group">
                                            <input type="text" class="form-control rounded ps-4"
                                                placeholder="🔍 Search course..." name="cat_search"
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
                                            <th><strong>{{ __('Exam Title') }}</strong></th>
                                            <th><strong>{{ __('Total Questions') }}</strong></th>
                                            <th><strong>{{ __('Duration') }}</strong></th>
                                            <th><strong>{{ __('Mark Per Question') }}</strong></th>
                                            <th><strong>{{ __('Pass Marks') }}</strong></th>
                                            <th><strong>{{ __('Action') }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($exams as $exam)
                                            <tr class="fade-in-row">
                                                <td class="tableId">{{ generateID($loop->iteration) }}</td>
                                                <td class="tableId">
                                                    @if (strlen($exam->title) > 50)
                                                        {{ substr($exam->title, 0, 50) . '...' }}
                                                    @else
                                                        {{ $exam->title }}
                                                    @endif
                                                </td>
                                                <td class="tableId">{{ $exam->questions->count() }}</td>
                                                <td class="tableId">{{ $exam->duration }}</td>
                                                <td class="tableId">{{ $exam->mark_per_question }}</td>
                                                <td class="tableId">{{ $exam->pass_marks }}</td>
                                                <td class="tableAction">
                                                    <a class="drop-item tooltip-custom"
                                                        href="{{ route('exam.edit', $exam->id) }}" target="_blank">
                                                        <i class="fa-solid fa-pen-to-square me-1 text-warning"></i>
                                                        <span class="tooltip-text">{{ __('Edit Exam') }}</span>
                                                    </a>
                                                    <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                        onclick="deleteAction('{{ route('exam.destroy', $exam->id) }}')">
                                                        <i class="fa-solid fa-trash-can me-1 text-danger"></i>
                                                        <span class="tooltip-text">{{ __('Delete Exam') }}</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7">
                                                    <h5 class="text-danger text-center m-0">{{ __('No Exam Available') }}
                                                    </h5>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $exams->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ****End-Body-Section**** -->
    </div>
@endsection

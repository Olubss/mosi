@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Category List'))

@section('header-title')
    <h3 class="title">{{ __('Categories') }}</h3>
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
                            {{ __('New Category') }}
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
                                    <a href="{{ route('category.create') }}"
                                        class="btn btn-primary btn-sm px-4 py-2 shadow-sm rounded-pill">
                                        <i class="fa-solid fa-plus me-1"></i> {{ __('New Category') }}
                                    </a>
                                </div>

                                <!-- Right Search & Refresh -->
                                <div class="d-flex flex-column justify-content-end align-items-end contain-width gap-3">
                                    <form action="{{ route('category.index') }}" method="GET" class="w-100">
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
                                            <th><strong>{{ __('Title') }}</strong></th>
                                            <th><strong>{{ __('Featured') }}</strong></th>
                                            <th><strong>{{ __('Color') }}</strong></th>
                                            <th><strong>{{ __('Status') }}</strong></th>
                                            <th><strong>{{ __('Action') }}</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody id="shortableCategory">
                                        @forelse ($categories as $category)
                                            <tr data-id="{{ $category->id }}" class="fade-in-row">
                                                <td>{{ generateID($categories->firstItem() + $loop->index) }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                                        <div class="d-flex align-items-center justify-content-start">
                                                            <img src="{{ $category->imagePath }}" alt="image"
                                                                width="30" height="30"
                                                                style="border-radius: 50%; object-fit: cover">
                                                        </div>
                                                        <p class="priceDis">{{ $category->title }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($category->is_featured)
                                                        <span
                                                            class="badge rounded-pill text-bg-success">{{ __('Yes') }}</span>
                                                    @else
                                                        <span
                                                            class="badge rounded-pill text-bg-danger">{{ __('No') }}</span>
                                                    @endif
                                                </td>

                                                <td><span class="px-3 py-1 rounded"
                                                        style="background-color: {{ $category->color }}"></span> &nbsp;
                                                    {{ $category->color }}</td>

                                                <td>
                                                    @if (!$category->is_featured)
                                                        <div
                                                            class="statusItem d-flex justify-content-start align-items-center">
                                                            <div class="circleDot animatedPending"></div>
                                                            <div class="statusText">
                                                                <span class="stutsPanding">{{ __('Inacitve') }}</span>
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
                                                    @if ($category->trashed())
                                                        <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                            onclick="restoreAction('{{ route('category.restore', $category->id) }}')">
                                                            <i class="fa-solid fa-rotate me-1 text-danger"></i>
                                                            <span class="tooltip-text">{{ __('Restore Category') }}</span>
                                                        </a>
                                                    @else
                                                        <a class="drop-item tooltip-custom"
                                                            href="{{ route('category.edit', $category->id) }}"
                                                            target="_blank">
                                                            <i class="fa-solid fa-pen-to-square me-1 text-warning"></i>
                                                            <span class="tooltip-text">{{ __('Edit Category') }}</span>
                                                        </a>
                                                        <a class="drop-item tooltip-custom" href="javascript:void(0)"
                                                            onclick="deleteAction('{{ route('category.destroy', $category->id) }}')">
                                                            <i class="fa-solid fa-trash-can me-1 text-danger"></i>
                                                            <span class="tooltip-text">{{ __('Delete Category') }}</span>
                                                        </a>
                                                        <a class="drop-item tooltip-custom" href="javascript:void(0)">
                                                            <i class="fa-solid fa-up-down-left-right"></i>
                                                            <span class="tooltip-text">{{ __('Move Category') }}</span>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">
                                                    <h5 class="text-danger text-center m-0">
                                                        {{ __('No Category Available') }}
                                                    </h5>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $categories->links() }}
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
        var el = document.getElementById('shortableCategory');
        var sortable = Sortable.create(el, {
            animation: 150,
            onEnd: function(evt) {
                let sortedIds = [];
                document.querySelectorAll('#shortableCategory tr').forEach((row, index) => {
                    sortedIds.push({
                        id: row.getAttribute('data-id'),
                        display_order: index + 1
                    });
                });

                fetch('{{ route('category.sort') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            sortedCategories: sortedIds
                        })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
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
                                title: "{{ __('Table Order Update Successfully') }}"
                            });
                        } else {
                            alert('Failed to update order');
                        }
                    });
            }
        });
    </script>
@endpush

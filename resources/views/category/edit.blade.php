@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Category Edit'))

@section('header-title')
    <h3 class="title">{{ __('Update Category') }}</h3>
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
                            {{ __('Update Category') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>


            {{-- <div class="row" id="deleteTableItem">
                <div class="col-md-12 my-3">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="main-card card d-flex h-100 flex-column">
                        <div class="card-body">
                            <h5 class="card-title py-2">{{ __('Edit Category') }}</h5>
                            <form action="{{ route('category.update', $category->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="row">
                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="titleInput" class="form-label">{{ __('Category Title') }}</label>
                                            <input type="text" required name="title" value="{{ $category->title }}"
                                                class="form-control" id="titleInput">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="exampleInputFile">{{ __('Category Icon') }} (JPG, JPEG,
                                                PNG)</label>
                                            <img src="{{ $category->imagePath }}" class="d-block mb-3" alt="Current image"
                                                height="150px">
                                            <label for="imageInput" class="form-label">
                                                {{ __('Select category icon') }}
                                            </label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input name="media" type="file"
                                                        class="custom-file-input form-control" id="imageInput">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="colorInput" class="form-label">
                                                {{ __('Choose a color for category background') }}
                                            </label>
                                            <input name="color" type="color" class="form-control form-control-color"
                                                id="colorInput" value="{{ $category->color }}"
                                                title="{{ __('Choose your color') }}">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input id="featuredInput" name="is_featured" class="form-check-input"
                                                    type="checkbox" @if ($category->is_featured) checked @endif>
                                                <label for="featuredInput" class="form-check-label">
                                                    {{ __('Feature on Homepage') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="row" id="deleteTableItem">
                <div class="col-8 mt-5 mx-auto">

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-4 shadow-sm fade show">
                            <ul class="m-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Modern Card -->
                    <div class="card border-0 shadow-xl rounded-5 overflow-hidden form-glass">
                        <div class="card-body p-5">
                            <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row g-4">

                                    <!-- Category Title -->
                                    <div class="col-md-6">
                                        <label for="titleInput" class="form-label fw-semibold">
                                            {{ __('Category Title') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="title" required id="titleInput"
                                            class="form-control form-control-lg rounded-4 shadow-sm mt-2"
                                            placeholder="{{ __('Enter category title') }}..."
                                            value="{{ $category->title }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            {{ __('Background Color') }}
                                        </label>

                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                            <!-- Hidden Input -->
                                            <input type="hidden" name="color" id="colorInput" value="{{ $category->color }}">

                                            <!-- Color Swatches -->
                                            <div class="color-swatch rounded-circle border shadow-sm"
                                                style="background:#3E1E68;" data-color="#3E1E68"></div>
                                            <div class="color-swatch rounded-circle border shadow-sm"
                                                style="background:#6D44B8;" data-color="#6D44B8"></div>
                                            <div class="color-swatch rounded-circle border shadow-sm"
                                                style="background:#9333EA;" data-color="#9333EA"></div>
                                            <div class="color-swatch rounded-circle border shadow-sm"
                                                style="background:#F43F5E;" data-color="#F43F5E"></div>
                                            <div class="color-swatch rounded-circle border shadow-sm"
                                                style="background:#F97316;" data-color="#F97316"></div>
                                            <div class="color-swatch rounded-circle border shadow-sm"
                                                style="background:#FACC15;" data-color="#FACC15"></div>
                                            <div class="color-swatch rounded-circle border shadow-sm"
                                                style="background:#10B981;" data-color="#10B981"></div>
                                            <div class="color-swatch rounded-circle border shadow-sm"
                                                style="background:#0EA5E9;" data-color="#0EA5E9"></div>
                                            <div class="color-swatch rounded-circle border shadow-sm"
                                                style="background:#64748B;" data-color="#64748B"></div>
                                        </div>

                                        <!-- Preview -->
                                        <div class="mt-3 d-flex align-items-center">
                                            <span class="fw-semibold fs-4">{{ __('Selected Color:') }}</span>
                                            <div id="colorPreview"
                                                class="d-inline-block ms-2 border rounded-circle shadow-sm"
                                                style="width: 40px; height: 40px; background: {{ $category->color }};">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            {{ __('Category Icon') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="upload-box rounded-5 text-center p-4 shadow-sm hover-glow mt-3"
                                            onclick="document.getElementById('imageInput').click()">
                                            <div class="mb-3">
                                                <img id="imagePreview"
                                                    src="{{ $category->imagePath ?? 'https://placehold.co/150x150' }}"
                                                    alt="Preview" class="rounded-4 shadow-sm"
                                                    style="max-height: 140px; object-fit: contain;">
                                            </div>
                                            <div class="text-muted fw-semibold">
                                                <i class="fa-solid fa-cloud-arrow-up fa-lg me-2 text-primary"></i>
                                                {{ __('Click or Drop image here') }}
                                            </div>
                                        </div>
                                        <input type="file" name="media" id="imageInput" accept="image/*" class="d-none"
                                            onchange="previewCategoryImage(event)">
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12 d-flex align-items-center justify-content-between mt-5">
                                        <!-- Featured Toggle -->
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-switch form-switch-lg">
                                                <div class="d-flex align-items-center">
                                                    <input id="featuredInput" name="is_featured" {{ $category->is_featured ? 'checked' : '' }}
                                                        class="form-check-input shadow-sm" type="checkbox">
                                                    <label for="featuredInput" class="form-check-label fw-semibold ms-2">
                                                        {{ __('Feature on Homepage') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="btn btn-primary btn-gradient btn-lg px-5 rounded-pill shadow-lg d-inline-flex align-items-center gap-2">
                                            <i class="fa-solid fa-plus-circle"></i>
                                            {{ __('Create Category') }}
                                        </button>
                                    </div>

                                </div>
                            </form>
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
        /* Upload Box Hover */

        .upload-box {
            cursor: pointer;
            border: 2px dashed #ced4da;
            transition: all 0.3s ease-in-out;
        }

        .hover-glow {
            transition: all 0.3s ease-in-out;
        }

        .hover-glow:hover {
            background: rgba(110, 66, 193, 0.05);
            border-color: #6D44B8 !important;
            transform: translateY(-2px);
        }

        /* Gradient Button */
        .btn-gradient {
            color: #fff;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
        }

        .color-swatch {
            width: 45px;
            height: 45px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .color-swatch:hover {
            transform: scale(1.1);
            border: 2px solid #000 !important;
        }

        .color-swatch.active {
            border: 3px solid #000 !important;
            transform: scale(1.1);
        }
    </style>
@endpush

@push('scripts')
    <script>
        // image preview
        function previewCategoryImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('imagePreview').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.getElementById('colorInput').addEventListener('input', function() {
            document.getElementById('colorPreview').style.background = this.value;
        });

        // Color Swatches
        document.querySelectorAll('.color-swatch').forEach(swatch => {
            swatch.addEventListener('click', function() {
                let color = this.getAttribute('data-color');
                document.getElementById('colorInput').value = color;
                document.getElementById('colorPreview').style.background = color;

                // Active state
                document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
@endpush

@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('Instructor Edit'))

@section('header-title')
    <h3 class="title">{{ __('Update Instructor') }}</h3>
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
                            {{ __('Update Instructor') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>

            <div class="row">
                <div class="col-md-10 mx-auto my-3">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('instructor.update', $instructor->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="modern-form">
                                    <!-- Section: Basic Info -->
                                    <div class="form-section">
                                        <h5 class="section-title">👤 Basic Info</h5>
                                        <div class="row g-4">
                                            <div class="col-md-4">
                                                <label class="form-label">{{ __('Name') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ $instructor->user->name }}"
                                                    maxlength="50" id="instructorName" onchange="countNameChar()"
                                                    class="form-control modern-input" placeholder="Enter user name">
                                                <small class="text-muted d-block mt-1">Characters: <span
                                                        id="charCountName">0</span>/50</small>
                                                @error('name')
                                                    <small class="text-danger fw-bold">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">{{ __('Email') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" name="email" value="{{ $instructor->user->email }}"
                                                    class="form-control modern-input" placeholder="Enter user email">
                                                @error('email')
                                                    <small class="text-danger fw-bold">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">{{ __('Phone') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="phone"
                                                    value="{{ $instructor->user->phone ? $instructor->user->phone : '01' . rand(100000000, 999999999) }}"
                                                    class="form-control modern-input" placeholder="Enter user phone">
                                                @error('phone')
                                                    <small class="text-danger fw-bold">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section: Instructor Info -->
                                    <div class="form-section">
                                        <h5 class="section-title">📖 Instructor Info</h5>
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Instructor Title') }}</label>
                                                <input type="text" id="instructorTitle" name="title" maxlength="60"
                                                    value="{{ old('title') ?? $instructor->title }}"
                                                    onchange="updateCharCount()" class="form-control modern-input"
                                                    placeholder="Enter instructor title">
                                                <small class="text-muted d-block mt-1">Characters: <span
                                                        id="charCount">0</span>/60</small>
                                                @error('title')
                                                    <small class="text-danger fw-bold">{{ $message }}</small>
                                                @enderror

                                                <label class="form-label mt-4">{{ __('Instructor About') }}</label>
                                                <textarea name="about" rows="8" class="form-control modern-input" placeholder="Write about instructor...">{{ old('about') ?? $instructor->about }}</textarea>
                                                @error('about')
                                                    <small class="text-danger fw-bold">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <div class="image-preview mb-3">
                                                    <img id="courseImagePreview"
                                                        src="{{ $instructor->user->profilePicturePath ?? 'https://placehold.co/600x400' }}"
                                                        alt="Profile Picture Preview">
                                                </div>
                                                <label class="form-label">{{ __('Profile Picture') }} (JPG, JPEG,
                                                    PNG)*</label>
                                                <label for="formFileImage" class="upload-box">
                                                    <i class="fa-solid fa-cloud-arrow-up me-2"></i> Choose File
                                                </label>
                                                <input name="profile_picture" class="d-none" id="formFileImage"
                                                    type="file"
                                                    onchange="document.getElementById('courseImagePreview').src = window.URL.createObjectURL(this.files[0])" />
                                                @error('profile_picture')
                                                    <small class="text-danger fw-bold">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section: Signature -->
                                    <div class="form-section">
                                        <h5 class="section-title">📝 Add Signature</h5>
                                        <div class="row g-4">
                                            <div class="col-md-4 mt-4">
                                                <label for="uploadSignature" class="additionThumbnail"
                                                    style="width: 100%; height: 220px; object-fit: fill">
                                                    <img src="{{ $instructor->signaturePath ?? asset('enrollment/upload.png') }}"
                                                        id="attribute38preview0" alt="" width="100%"
                                                        height="100%" style="object-fit: cover">
                                                    <button onclick="" id="removeAttribute38Thumbnail0"
                                                        type="button"
                                                        class="delete btn btn-sm btn-outline-danger circleIcon"
                                                        style="display: none">
                                                        <img src="http://pcbuilderbd.test/assets/icons-admin/trash.svg"
                                                            loading="lazy" alt="trash">
                                                    </button>
                                                </label>
                                                <input id="uploadSignature" accept="image/*" type="file"
                                                    name="signature" class="d-none"
                                                    onchange="document.getElementById('attribute38preview0').src = window.URL.createObjectURL(this.files[0])">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section: Security -->
                                    <div class="form-section">
                                        <h5 class="section-title">🔐 Security</h5>
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Password') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="password" name="password" class="form-control modern-input"
                                                    placeholder="Enter password">
                                                @error('password')
                                                    <small class="text-danger fw-bold">{{ $message }}</small>
                                                    <ul class="small text-warning mt-2">
                                                        <li>At least 8 characters</li>
                                                        <li>One uppercase & lowercase letter</li>
                                                        <li>One number</li>
                                                        <li>One special character</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('Confirm Password') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="password" name="password_confirmation"
                                                    class="form-control modern-input" placeholder="Re-enter password">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section: Settings -->
                                    <div class="form-section">
                                        <h5 class="section-title">⚙️ Permissions</h5>
                                        <div class="d-flex flex-wrap gap-4">
                                            <div class="form-check">
                                                <input id="featuredInput" name="is_featured" type="checkbox"
                                                    class="form-check-input"
                                                    {{ $instructor->is_featured ? 'checked' : '' }}>
                                                <label for="featuredInput" class="form-check-label">Feature on
                                                    Homepage</label>
                                            </div>
                                            <div class="form-check">
                                                <input id="activeInput" name="is_active" type="checkbox"
                                                    class="form-check-input"
                                                    {{ $instructor->is_active ? 'checked' : '' }}>
                                                <label for="activeInput" class="form-check-label">Verify Account by
                                                    Default</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="form-footer text-end mt-4">
                                        <button type="submit" class="btn btn-primary btn-modern-submit">
                                            <i class="fa-solid fa-user-plus me-2"></i> {{ __('Update Instructor') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- ****End-Body-Section**** -->
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .modern-form {
            margin: auto;
            display: flex;
            flex-direction: column;
        }

        .form-section {
            border-radius: 1rem;
            padding: 1rem;
            transition: 0.3s;
        }

        .section-title {
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #3E1E68;
            border-left: 4px solid #3E1E68;
            padding-left: 10px;
        }

        .modern-input {
            border-radius: 0.6rem;
            border: 1px solid #ddd;
            padding: 10px 14px;
            transition: all 0.2s ease;
        }

        .modern-input:focus {
            border-color: #3E1E68;
            box-shadow: 0 0 0 3px rgba(62, 30, 104, 0.15);
        }

        /* Image preview */
        .image-preview {
            width: 100%;
            height: 220px;
            border-radius: 1rem;
            background: #f9f9fb;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .upload-box {
            display: inline-block;
            padding: 0.8rem 1.2rem;
            border: 2px dashed #bbb;
            border-radius: 0.8rem;
            cursor: pointer;
            background: #f5f5f7;
            color: #555;
            font-weight: 500;
            transition: 0.2s;
        }

        .upload-box:hover {
            background: #ececff;
            border-color: #3E1E68;
            color: #3E1E68;
        }

        /* Button */
        .btn-modern-submit {
            padding: 0.8rem 2rem;
            border-radius: 0.8rem;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-modern-submit:hover {
            transform: translateY(-2px);
        }
    </style>
@endpush


@push('scripts')
    {{-- instructor title char count --}}
    <script>
        // Wait for the DOM to fully load before adding the event listener
        document.addEventListener('DOMContentLoaded', function() {
            // Get references to the input field and character count display
            const titleInput = document.getElementById('instructorTitle');
            const charCountDisplay = document.getElementById('charCount');
            // Function to update the character count
            charCountDisplay.textContent = titleInput.value.length;

            function updateCharCount() {
                charCountDisplay.textContent = titleInput.value.length;
            }
            // Attach the event listener to update count in real time
            titleInput.addEventListener('input', updateCharCount);
        });
    </script>


    {{-- instructor name char count --}}
    <script>
        // Wait for the DOM to fully load before adding the event listener
        document.addEventListener('DOMContentLoaded', function() {
            // Get references to the input field and character count display
            const titleInput = document.getElementById('instructorName');
            const charCountDisplay = document.getElementById('charCountName');
            // Function to update the character count
            charCountDisplay.textContent = titleInput.value.length;

            function countNameChar() {
                charCountDisplay.textContent = titleInput.value.length;
            }
            // Attach the event listener to update count in real time
            titleInput.addEventListener('input', countNameChar);
        });
    </script>
@endpush

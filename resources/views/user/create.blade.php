@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('User Create'))

@section('header-title')
    <h3 class="title">{{ __('Create User Profile') }}</h3>
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
                            {{ __('New Profile') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>

            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="p-4">
                @csrf

                <div class="card shadow-sm border-0 rounded-4 mx-auto" style="max-width: 900px;">
                    <div class="card-body p-5">
                        <div class="row g-5 align-items-start">
                            <!-- Profile Image Section -->
                            <div class="col-md-4 text-center">
                                <div class="position-relative d-inline-block">
                                    <div class="rounded-circle overflow-hidden border border-3 border-primary shadow-sm"
                                        style="width: 160px; height: 160px;">
                                        <img id="courseImagePreview" src="/assets/images/profile/demo-profile.png"
                                            class="w-100 h-100" style="object-fit: cover">
                                    </div>
                                    <label for="formFileImage"
                                        class="btn btn-sm btn-primary shadow position-absolute d-flex justify-content-center align-items-center"
                                        style="bottom: 8px; right:8px; width:40px; height:40px; border-radius:50%; font-size:14px;">
                                        <i class="fa fa-camera"></i>
                                    </label>
                                    <input name="profile_picture" id="formFileImage" type="file" class="d-none"
                                        onchange="document.getElementById('courseImagePreview').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                <small class="d-block mt-2 text-muted">{{ __('JPG, JPEG, PNG up to 2MB') }}</small>
                                @error('profile_picture')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- User Information -->
                            <div class="col-md-8">
                                <div class="row g-4">
                                    <!-- Name -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">{{ __('Full Name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control rounded-3"
                                            placeholder="{{ __('Enter full name') }}" value="{{ old('name') }}">
                                        @error('name')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Email & Phone -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Email') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control rounded-3"
                                            placeholder="{{ __('Enter email') }}" value="{{ old('email') }}">
                                        @error('email')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Phone') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control rounded-3"
                                            placeholder="{{ __('Enter phone number') }}" value="{{ old('phone') }}">
                                        @error('phone')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Password') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control rounded-3"
                                            placeholder="{{ __('Enter password') }}">
                                        @error('password')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Confirm Password') }}</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control rounded-3 @if (strpos($errors->first('password'), 'confirmation does not match') !== false) is-invalid @endif"
                                            placeholder="{{ __('Re-enter password') }}">
                                        @error('password_confirmation')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="mt-5">
                            <h6 class="fw-bold mb-3">{{ __('Permissions') }}</h6>
                            <div class="d-flex flex-wrap gap-4">
                                <div class="form-check">
                                    <input id="activeInput" name="is_active" class="form-check-input" type="checkbox">
                                    <label for="activeInput" class="form-check-label">
                                        {{ __('Verify Account by Default') }}
                                    </label>
                                </div>
                                @if (auth()->user()->is_root &&
                                        auth()->user()->is_org == false &&
                                        auth()->user()->organization == null &&
                                        !auth()->user()->hasRole('instructor') &&
                                        !auth()->user()->hasRole('organization'))
                                    <div class="form-check">
                                        <input id="adminInput" name="is_admin" class="form-check-input" type="checkbox">
                                        <label for="adminInput" class="form-check-label">
                                            {{ __('Allow Admin Privileges') }}
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 px-5">
                                <i class="fa fa-plus"></i> {{ __('Add New Profile') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>


            <!-- ****End-Body-Section**** -->
        </div>
    </div>
@endsection

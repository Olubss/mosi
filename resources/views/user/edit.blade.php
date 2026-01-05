@extends($layout_path)

@section('title', $app_setting['name'] . ' | ' . __('User Edit'))

@section('header-title')
    <h3 class="title">{{ __('Update Profile') }}</h3>
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
                            {{ __('Profile Update') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>

            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card shadow-sm border-0 rounded-4 mx-auto my-4" style="max-width: 1000px;">
                    <div class="card-body p-5">

                        <div class="row g-5 align-items-start">
                            <!-- Profile Image -->
                            <div class="col-md-4 text-center">
                                <div class="position-relative d-inline-block">
                                    <div class="rounded-circle overflow-hidden border border-3 border-primary shadow-sm"
                                        style="width: 160px; height: 160px;">
                                        <img id="courseImagePreview" src="{{ $user->profilePicturePath }}"
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
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control rounded-3"
                                            placeholder="{{ __('Enter user name') }}"
                                            value="{{ old('name', $user->name) }}">
                                        @error('name')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Email') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control rounded-3"
                                            placeholder="{{ __('Enter user email') }}"
                                            value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Phone') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control rounded-3"
                                            placeholder="{{ __('Enter user phone') }}"
                                            value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- WhatsApp -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('WhatsApp Contact No') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="whatsapp" class="form-control rounded-3"
                                            placeholder="{{ __('Enter WhatsApp Contact') }}"
                                            value="{{ old('whatsapp', $user->whatsapp) }}">
                                        @error('whatsapp')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">{{ __('Gender') }}</label>
                                        <select class="form-select rounded-3" name="gender">
                                            <option value="">{{ __('Select Gender') }}</option>
                                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>
                                                {{ __('Male') }}</option>
                                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>
                                                {{ __('Female') }}</option>
                                            <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>
                                                {{ __('Other') }}</option>
                                        </select>
                                        @error('gender')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Designation & Company -->
                                    @if (auth()->user()->hasRole('organization') ||
                                            auth()->user()->is_org ||
                                            auth()->user()->is_admin ||
                                            auth()->user()->hasRole('admin'))
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">{{ __('Designation') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="designation" class="form-control rounded-3"
                                                placeholder="{{ __('Enter Designation') }}"
                                                value="{{ $user?->organization?->designation }}">
                                            @error('designation')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">{{ __('Company Name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="company_name" class="form-control rounded-3"
                                                placeholder="{{ __('Enter company name') }}"
                                                value="{{ $user?->organization?->name }}">
                                            @error('company_name')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- About + Signature -->
                        <div class="row g-4 mt-5">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">{{ __('About Me') }} <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control rounded-3" name="about" rows="6" placeholder="{{ __('Enter about text') }}">{{ old('about', $user?->about) }}</textarea>
                                @error('about')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">{{ __('Signature') }}</label>
                                <label for="uploadSignature" class="d-block border rounded-3 position-relative"
                                    style="height: 150px; cursor: pointer;">
                                    <img src="{{ $user->signaturePath ?? asset('enrollment/upload.png') }}"
                                        id="attribute38preview0" alt="Signature Preview" class="w-100 h-100"
                                        style="object-fit: contain">
                                    <button id="removeAttribute38Thumbnail0" type="button"
                                        class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                        style="display: none">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </label>
                                <input id="uploadSignature" accept="image/*" type="file" name="signature"
                                    class="d-none"
                                    onchange="document.getElementById('attribute38preview0').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                        </div>

                        <!-- Password + Birthday -->
                        <div class="row g-4 mt-4">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">{{ __('Password') }} <span
                                        class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control rounded-3"
                                    placeholder="{{ __('Enter user password') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">{{ __('Confirm Password') }}</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control rounded-3 @if (strpos($errors->first('password'), 'confirmation does not match') !== false) is-invalid @endif"
                                    placeholder="{{ __('Enter user password again') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">{{ __('Date of Birth') }}</label>
                                <input type="date" name="birthday" class="form-control rounded-3"
                                    value="{{ $user?->birthday ?? '' }}">
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="mt-5">
                            <h6 class="fw-bold mb-3">{{ __('Permissions') }}</h6>
                            <div class="d-flex flex-wrap gap-4">
                                <div class="form-check">
                                    <input id="activeInput" name="is_active" class="form-check-input" type="checkbox"
                                        @if ($user->email_verified_at != null) checked @endif>
                                    <label for="activeInput" class="form-check-label">
                                        {{ __('Verify Account by Default') }}
                                    </label>
                                </div>
                                @if (auth()->user()->is_root && $user->is_org == false && $user->organization == null)
                                    <div class="form-check">
                                        <input id="adminInput" name="is_admin" class="form-check-input" type="checkbox"
                                            @if ($user->id == auth()->user()->id) disabled @endif
                                            @if ($user->is_admin) checked @endif>
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
                                <i class="fa fa-plus"></i> {{ __('Update Profile') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>


            <!-- ****End-Body-Section**** -->
        </div>
    </div>
@endsection

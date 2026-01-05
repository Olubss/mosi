@extends('layouts.app')

@section('title', $app_setting['name'] . ' | ' . __('Settings'))

@section('header-title')
    <h3 class="title">{{ __('Social Media Settings') }}</h3>
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
                            {{ __('Social Media Settings') }}
                        </li>
                    </ol>
                </nav>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="refresh-btn">
                    <i class="fa-solid fa-retweet"></i>
                    <span>{{ __('Refresh Page') }}</span>
                </a>
            </div>

            {{-- content start here --}}

            <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row my-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        @foreach ($socialMedias as $media)
                                            <div class="col-md-6 mb-3">
                                                <label for="facebook_link" class="form-label"> <i
                                                        class="{{ $media->icon }} fs-6"></i>
                                                    {{ $media->title }} {{ __('Link') }}</label>
                                                <input type="text" class="form-control" id="facebook_link"
                                                    name="social_links[{{ $media->id }}]"
                                                    placeholder="{{ $media->url ?? $media->title }} Link"
                                                    value="{{ $media->url }}" />
                                                @error('social_links.' . $media->id)
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endforeach
                                        <div class="col-md-12 my-3">
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-lg btn-primary py-2 px-5">
                                                        {{ __('Update') }}
                                                    </button>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            {{-- content end here --}}

        </div>
    </div>
    <!-- ****Body-Section***** -->
@endsection

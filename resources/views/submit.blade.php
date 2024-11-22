@extends('layouts.app')

@section('title', trans('communitytube::messages.submit_title'))

@section('content')
    <div class="container mt-5">
        <div class="col-lg-8 mx-auto">
            <form action="{{ route('communitytube.submit.send') }}" method="POST">
                @csrf
                <h1 class="text-center mb-4">{{ trans('communitytube::messages.submit_title') }}</h1>
                <h4 class="text-center mb-4 text-muted">{{ trans('communitytube::messages.submit_description') }}</h4>
                
                <div class="mb-3">
                    <label class="form-label" for="linkInput">{{ trans('communitytube::messages.submit.video_link') }}</label>
                    <input type="text" class="form-control @error('link') is-invalid @enderror" id="linkInput" name="link" placeholder="{{ trans('communitytube::messages.link-placeholder') }}" maxlength="100">
                    @error('link')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="titleInput">{{ trans('communitytube::messages.submit.title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="titleInput" name="title">
                    <small class="form-text text-muted">{{ trans('communitytube::messages.submit.title_limit') }}</small>
                    @error('title')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="descInput">{{ trans('communitytube::messages.submit.desc') }}</label>
                    <input type="text" class="form-control @error('desc') is-invalid @enderror" id="descInput" name="description" maxlength="250">
                    <small class="form-text text-muted">{{ trans('communitytube::messages.submit.desc_limit') }}</small>
                    @error('desc')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                @if($user && $user->can('communitytube.bypass_verification'))
                    <div class="mb-3 form-check form-switch d-flex align-items-center">
                        <input type="checkbox" class="form-check-input me-2" id="bypassVerifSwitch" name="bypass_verification">
                        <label class="form-check-label" for="bypassVerifSwitch">{{ trans('communitytube::messages.submit.bypass_verification') }}</label>
                    </div>
                @endif

                @if($user && $user->can('communitytube.set_video_author'))
                    <div class="mb-3">
                        <label class="form-label" for="authorInput">{{ trans('communitytube::messages.submit.author') }}</label>
                        <input type="text" class="form-control" id="authorInput" name="author">
                        <small class="form-text text-muted">{{ trans('communitytube::messages.submit.title_author') }}</small>
                    </div>
                @endif

                @if($user && $user->can('communitytube.manage'))
                    <div class="mb-3 form-check form-switch d-flex align-items-center">
                        <input type="checkbox" class="form-check-input me-2" id="addAsHidden" name="add_as_hidden">
                        <label class="form-check-label" for="addAsHidden">{{ trans('communitytube::messages.submit.add_as_hidden') }}</label>
                    </div>
                @endif

                <div class="text-center">
                    <button type="submit" class="btn btn-success mt-4">
                        <i class="bi bi-cloud-arrow-up"></i> {{ trans('communitytube::messages.buttons.submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

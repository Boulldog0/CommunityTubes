@extends('admin.layouts.admin')

@section('title', trans('communitytube::messages.admin.title.edit'))

@section('content')
<div class="container my-4">
    <div class="card shadow-sm p-4">
        <div class="card-body">
            <h1 class="text-center">{{ trans('communitytube::messages.admin.title.edit') }}</h1>
            <p class="text-center text-muted">{{ trans('communitytube::messages.admin.description.edit') }}</p>
            @if(!$video->verified)
                <div class="alert alert-warning text-center mt-3">
                    🕰️ {{ trans('communitytube::messages.admin.video_waiting') }} 🕰️
                </div>
            @else
                <div class="alert alert-success text-center mt-3">
                    ✅ {{ trans('communitytube::messages.admin.video_verified') }} ✅
                </div>
            @endif
            @if(session('c_success'))
                 <div class="alert alert-success text-center">
                    ✅ {{ session('c_success') }} ✅
                </div>
            @endif
            <div class="card mx-auto mb-4 shadow-sm" style="max-width: 600px;">
                <div class="position-relative">
                    <a href="{{ $video->video_url }}" target="_blank">
                        <img src="{{ $video->thumbnail_url }}" class="card-img-top" alt="{{ $video->title }}">
                    </a>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('communitytube.video', ['id' => $video->id]) }}" class="btn btn-outline-primary mt-2">
                        <i class="bi bi-eye"></i> {{ trans('communitytube::messages.admin.see_video_profil') }}
                    </a>
                </div>
            </div>

            <form action="{{ route('communitytube.admin.edit.save', ['id' => $video->id]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="linkInput">{{ trans('communitytube::messages.submit.video_link') }}</label>
                    <input type="text" class="form-control @error('link') is-invalid @enderror" id="linkInput" name="link" placeholder="{{ trans('communitytube::messages.link-placeholder') }}" value="{{ old('link', $video->video_url) }}" maxlength="100">
                    @error('link')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="titleInput">{{ trans('communitytube::messages.submit.title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="titleInput" name="title" value="{{ old('title', $video->title) }}">
                    <small class="form-text text-muted">{{ trans('communitytube::messages.submit.title_limit') }}</small>
                    @error('title')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="descInput">{{ trans('communitytube::messages.submit.desc') }}</label>
                    <input type="text" class="form-control @error('desc') is-invalid @enderror" id="descInput" name="description" value="{{ old('desc', $video->description) }}" maxlength="250">
                    <small class="form-text text-muted">{{ trans('communitytube::messages.submit.desc_limit') }}</small>
                    @error('desc')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                @if($user && $user->can('communitytube.set_video_author'))
                    <div class="mb-3">
                        <label class="form-label" for="authorInput">{{ trans('communitytube::messages.submit.author') }}</label>
                        <input type="text" class="form-control" id="authorInput" name="author" value="{{ old('title', $video->video_author_name) }}">
                        <small class="form-text text-muted">{{ trans('communitytube::messages.submit.title_author') }}</small>
                    </div>
                @endif

                <div class="mb-3 form-check form-switch d-flex align-items-center">
                    <input type="checkbox" class="form-check-input me-2" id="pinVideo" name="pin" {{ $video->pined ? 'checked' : '' }}>
                    <label class="form-check-label" for="pinVideo">{{ trans('communitytube::messages.admin.pin_video') }}</label>
                </div>

                <div class="mb-3 form-check form-switch d-flex align-items-center">
                    <input type="checkbox" class="form-check-input me-2" id="hideVideo" name="hide" {{ $video->hidden ? 'checked' : '' }}>
                    <label class="form-check-label" for="hideVideo">{{ trans('communitytube::messages.admin.hide_video') }}</label>
                </div>

                @if($video->verified)
                    <div class="mb-3">
                        <label class="form-label" for="verified">{{ trans('communitytube::messages.admin.video_verified_by') }}</label>
                        <input type="text" class="form-control" id="verified" name="verified" value="{{ $video->verifier_username}}" readonly>
                    </div>
                @endif

                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                    </button>
                    <a href="{{ route('communitytube.admin.index') }}" class="btn btn-secondary mt-3 ms-2">
                        <i class="bi bi-arrow-left"></i> {{ trans('communitytube::messages.buttons.back_to_settings') }}
                    </a>
                </div>
            </form>

            <hr class="my-4">
            <div class="text-center">
                @if(!$video->verified)
                    <form action="{{ route('communitytube.admin.verif.accept', ['id' => $video->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success me-2">
                            <i class="bi bi-check-circle"></i> {{ trans('communitytube::messages.buttons.verif_accept') }}
                        </button>
                    </form>
                    <form action="{{ route('communitytube.admin.delete', ['id' => $video->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-ban"></i> {{ trans('communitytube::messages.buttons.verif_deny') }}
                        </button>
                    </form>
                @else
                    <form action="{{ route('communitytube.admin.delete', ['id' => $video->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> {{ trans('communitytube::messages.buttons.delete') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

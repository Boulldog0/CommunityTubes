@extends('layouts.app')

@section('title', trans('communitytube::messages.video_title'))

@section('content')
    <div class="container my-5">
        <h1 class="text-center">{{ trans('communitytube::messages.video_title') }}</h1>

        @if(!$video->verified)
            <div class="alert alert-warning text-center mt-3">
                ⚠️ {{ trans('communitytube::messages.video_restricted') }} ⚠️
            </div>
        @endif

        @if(!$video->hidden || $video->hidden && $user && $user->can('communitytube.manage'))
            <div class="card mx-auto shadow-sm" style="max-width: 600px;">
                <div class="position-relative">
                    <a href="{{ $video->video_url }}" target="_blank">
                        <div class="position-absolute top-0 end-0 m-2 d-flex flex-row">
                            @if($video->hidden)
                                <button class="btn btn-secondary btn-sm me-2" style="z-index:10; opacity:0.90;" disabled>
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                @endif
                                @if($video->pined)
                                    <button class="btn btn-warning btn-sm me-2" style="z-index:10; opacity:0.90;"  disabled>
                                        <i class="bi bi-pin"></i>
                                    </button>
                                @endif
                            </div>
                        <img src="{{ $video->thumbnail_url }}" class="card-img-top" alt="{{ $video->title }}">
                    </a>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $video->title }}</h5>
                    <p class="card-text">{{ $video->description }}</p>         
                </div>
                <div class="card-body">
                    @if($video->video_author_name)
                        <p class="card-text text-muted">{{ trans('communitytube::messages.designated_author')}} {{ $video->video_author_name }}</p>
                    @endif
                    <p class="card-text text-muted">{{ trans('communitytube::messages.submitted_by')}} {{ $video->author_name }}</p>
                    <p class="card-text text-muted">{{ trans('communitytube::messages.submitted_at')}} {{ $video->created_at->translatedFormat('d/m/Y H:i') }}</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('communitytube.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-return-left"></i> {{ trans('communitytube::messages.buttons.return_index') }}
                    </a>
                    @if($user && $user->can('communitytube.manage'))
                        <a href="{{ route('communitytube.admin.edit', ['id' => $video->id]) }}" class="btn btn-outline-warning">
                            <i class="bi bi-pencil"></i> {{ trans('communitytube::messages.buttons.edit_video') }}
                        </a>
                    @endif
                    <form action="{{ route('communitytube.like', ['id' => $video->id]) }}" method="POST" >
                        @csrf
                        @if($user && \Azuriom\Plugin\CommunityTube\Models\CommunityTubeLikes::hasLiked($user->id, $video->id))
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-heart-fill"></i> {{ $video->likes }}
                            </button>
                        @else
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-heart"></i> {{ $video->likes }}
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center mt-3">
                ⚠️ {{ trans('communitytube::messages.video_hidden') }} ⚠️
            </div>
            <a href="{{ route('communitytube.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-return-left"></i> {{ trans('communitytube::messages.buttons.return_index') }}
            </a>
        @endif
    </div>
@endsection

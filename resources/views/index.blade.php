@extends('layouts.app')

@section('title', trans('communitytube::messages.title'))

@section('content')
    <div class="mb-3">
        <h1>{{ trans('communitytube::messages.title') }}</h1>
        <div class="row">
            @if($videos->isNotEmpty())
                @foreach($videos as $video)
                    @if($video->verified && (!$video->hidden || $video->hidden && $user && $user->can('communitytube.manage')) || !$video->verified && $user->can('communitytube.manage') && (!$video->hidden || $video->hidden && $user && $user->can('communitytube.manage')))
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                <a href="{{ $video->video_url }}" target="_blank">
                                    <div class="position-absolute top-0 end-0 m-2 d-flex flex-row">
                                        @if(!$video->verified)
                                            <button class="btn btn-danger btn-sm me-2" style="z-index:10; opacity:0.90;"  disabled>
                                                <i class="bi bi-patch-check"></i>
                                            </button>
                                        @endif
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
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-center">{{ $video->title }}</h5>
                                    <p class="card-text text-center text-truncate">{{ Str::limit($video->description, 100) }}</p>
                                    <p class="card-text text-muted">{{ trans('communitytube::messages.submitted_by')}} {{ $video->author_name }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('communitytube.video', ['id' => $video->id]) }}" class="btn btn-primary w-100">
                                            <i class="bi bi-eye"></i> {{ trans('communitytube::messages.see_more') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <form action="{{ route('communitytube.like', ['id' => $video->id]) }}" method="POST" >
                                        @csrf
                                        @if($user && \Azuriom\Plugin\CommunityTube\Models\CommunityTubeLikes::hasLiked($user->id, $video->id))
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-heart-fill"></i> {{ \Azuriom\Plugin\CommunityTube\Models\CommunityTubeLikes::where('video_id', $video->id)->count() }}
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-heart"></i> {{ \Azuriom\Plugin\CommunityTube\Models\CommunityTubeLikes::where('video_id', $video->id)->count() }}
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="alert alert-warning text-center">
                    ❌ {{ trans('communitytube::messages.no_video') }} ❌
                </div>
            @endif
        </div>
        @if($user && $user->can('communitytube.submit'))
            <div class="d-flex justify-content-center mt-3">
                <a href="{{ route('communitytube.submit') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> {{ trans('communitytube::messages.buttons.submit_new') }}
                </a>
            </div>
        @endif
    </div>
@endsection

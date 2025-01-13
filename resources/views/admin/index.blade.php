@extends('admin.layouts.admin')

@section('title', trans('communitytube::messages.admin.title.settings'))

@section('content')
<div class="container my-4">
    <div class="card shadow-sm p-4">
        <div class="card-body">
            <div class="mb-5">
                <h3 class="mb-4">{{ trans('communitytube::messages.admin.title.videos') }}</h3>
                
                @php
                    $unverifiedVideos = $videos->filter(function($video) {
                        return !$video->verified;
                    });
                @endphp

                @if($videos->isNotEmpty())
                    @if($unverifiedVideos->isNotEmpty())
                        <h4 class="text-danger mb-3">{{ trans('communitytube::messages.admin.non-verified-videos') }}</h4>
                        @foreach($unverifiedVideos as $video)
                            <div class="row align-items-center py-3 border-bottom">
                                <div class="col-auto">
                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="img-fluid rounded" style="width: 80px; height: auto;">
                                </div>
                                <div class="col">
                                    <h5 class="mb-1">{{ $video->title }}</h5>
                                    <p class="text-muted mb-0">
                                        {{ \Illuminate\Support\Str::limit($video->description, 35) }}
                                    </p>
                                </div>
                                <div class="col text-end">
                                    <h6 class="text-warning mb-1">⚠️ {{ trans('communitytube::messages.admin.video_waiting') }} ⚠️</h6>
                                    <p class="card-text text-muted mb-0">
                                        {{ trans('communitytube::messages.submitted_by') }} 
                                        {{ \Azuriom\Models\User::find($video->submitter)?->name ?? trans('communitytube::messages.unknow_user') }}
                                    </p>
                                </div>
                                <div class="col-auto">
                                    @if($video->hidden)
                                        <button class="btn btn-secondary btn-sm me-2">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('communitytube.admin.edit', ['id' => $video->id]) }}" class="btn btn-primary btn-sm" title="{{ trans('communitytube::messages.admin.edit') }}">
                                       <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <hr class="my-5">
                    <h4 class="text-success mb-3">{{ trans('communitytube::messages.admin.verified-videos') }}</h4>
                    
                    @foreach($videos as $video)
                        @if($video->verified)
                            <div class="row align-items-center py-3 border-bottom">
                                <div class="col-auto">
                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="img-fluid rounded" style="width: 80px; height: auto;">
                                </div>
                                <div class="col">
                                    <h5 class="mb-1">{{ $video->title }}</h5>
                                    <p class="text-muted mb-0">
                                        {{ \Illuminate\Support\Str::limit($video->description, 50) }}
                                    </p>
                                </div>
                                <div class="col text-end">
                                    <p class="card-text text-muted mb-0">
                                        {{ trans('communitytube::messages.submitted_by') }} 
                                        {{ \Azuriom\Models\User::find($video->submitter)?->name ?? trans('communitytube::messages.unknow_user') }}
                                    </p>
                                </div>
                                <div class="col-auto">
                                    @if($video->hidden)
                                        <button class="btn btn-secondary btn-sm me-2">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    @endif
                                   <button class="btn btn-danger btn-sm me-2">
                                       <i class="bi bi-heart"></i> {{ \Azuriom\Plugin\CommunityTube\Models\CommunityTubeLikes::where('video_id', $video->id)->count() }}
                                   </button>
                                   @if($video->pined)
                                       <button class="btn btn-warning btn-sm me-2" title="{{ trans('communitytube::messages.admin.pinned') }}">
                                           <i class="bi bi-pin-angle"></i>
                                       </button>
                                   @endif
                                   <a href="{{ route('communitytube.admin.edit', ['id' => $video->id]) }}" class="btn btn-primary btn-sm" title="{{ trans('communitytube::messages.admin.edit') }}">
                                       <i class="bi bi-pencil-square"></i>
                                   </a>
                               </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="alert alert-warning text-center mt-3">
                        ⚠️ {{ trans('communitytube::messages.no_video') }} ⚠️
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

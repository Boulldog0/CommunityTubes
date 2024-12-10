@extends('admin.layouts.admin')

@section('title', trans('communitytube::messages.admin.title.verif'))

@section('content')
<div class="container my-4">
    <div class="card shadow-sm p-4">
        <div class="card-body">
            <h1 class="text-center">{{ trans('communitytube::messages.admin.title.verif') }}</h1>
            <p class="text-center text-muted">{{ trans('communitytube::messages.admin.description.verif') }}</p>
            
            @php
                $unverifiedVideos = $videos->filter(function($video) {
                    return !$video->verified;
                });
            @endphp

            @if($unverifiedVideos->isNotEmpty())
                @foreach($unverifiedVideos as $video)
                    <div class="row align-items-center border-bottom py-3">
                        <div class="col-auto">
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="img-fluid" style="width: 80px; height: auto;">
                        </div>
                        <div class="col">
                            <h5 class="mb-1">{{ $video->title }}</h5>
                            <p class="text-muted mb-0">
                                {{ \Illuminate\Support\Str::limit($video->description, 50) }}
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
            @else
                <div class="alert alert-success text-center mt-3">
                    ✅ {{ trans('communitytube::messages.admin.no_video_waiting') }} ✅
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

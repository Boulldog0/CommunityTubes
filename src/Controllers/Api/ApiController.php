<?php

namespace Azuriom\Plugin\CommunityTube\Controllers\Api;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Azuriom\Models\User;
use Azuriom\Plugin\CommunityTube\Models\CommunityTube;

class ApiController extends Controller
{
    public function getAll(Request $request) {
        $videos = CommunityTube::all();
        $result = [];
    
        foreach($videos as $video) {
            $submitter = User::find($video->submitter);
    
            $result[$video->id] = [
                "name" => $video->title,
                "thumbnail" => $video->thumbnail,
                "submitter" => $submitter ? $submitter->name : null,
                "pined" => $video->pined,
                "description" => $video->description,
                "author" => $video->video_author_name,
                "hidden" => $video->hidden,
                "url" => $video->video_url,
                "verified" => $video->verified,
                "creation_date" => $video->created_at,
            ];
        }
    
        return response()->json($result);
    }   
    
    public function getAllIds(Request $request) {
        $videos = CommunityTube::all();
        $ids = [];
    
        foreach($videos as $video) {
            $ids[] = $video->id;
        }
    
        return response()->json($ids);
    }

    public function getLatest(Request $request) {
        $videos = CommunityTube::query()
        ->orderByDesc('created_at') 
        ->get();

        foreach($videos as $video) {
            if($video->verified && !$video->hidden) {
                return response()->json(['video_id' => $video->id]);
            } 
        }
    }

    public function getVideo(Request $request) {
        $video_id = $request->video_id;

        if(!$video_id) {
            return response()->json(['error' => 'No "video_id" argument found']);
        }

        $video = CommunityTube::get($video_id);

        if(!$video || $video === null) {
            return response()->json(['error:' => 'Video not found']);
        }

        $submitter = User::find($video->submitter);

        $result = [
            "name" => $video->title,
            "thumbnail" => $video->thumbnail,
            "submitter" => $submitter ? $submitter->name : null,
            "pined" => $video->pined,
            "description" => $video->description,
            "author" => $video->video_author_name,
            "hidden" => $video->hidden,
            "url" => $video->video_url,
            "verified" => $video->verified,
            "creation_date" => $video->created_at,
        ];

        return response()->json($result);
    }
}

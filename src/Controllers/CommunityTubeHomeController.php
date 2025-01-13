<?php

namespace Azuriom\Plugin\CommunityTube\Controllers;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Azuriom\Plugin\CommunityTube\Models\CommunityTube;
use Illuminate\Http\Request;
use Azuriom\Models\User;

class CommunityTubeHomeController extends Controller
{
    public function index()
    {
        $videos = CommunityTube::query()
            ->orderByDesc('pined') 
            ->orderByDesc('created_at') 
            ->get();
    
        return view('communitytube::index', [
            'videos' => $videos,
            'user' => Auth::user(),
        ]);
    }
    
    public function submit()
    {
        $user = Auth::user();

        if($user && $user->can('communitytube.submit')) {   
            return view('communitytube::submit', [
                'user' => $user,
            ]);
        } else {
            return $this->index();
        }
    }

    public function video($id)
    {
        $user = Auth::user();
        $video = CommunityTube::find($id);
    
        if(!$video) {
            return redirect()->route('communitytube.index')
                             ->with('error', trans('communitytube::messages.no_video_found'));
        }
    
        if(!$video->verified && !$user->can('communitytube.manage')) {
            return redirect()->route('communitytube.index')
                             ->with('error', trans('communitytube::messages.restricted_video'));
        }

        return view('communitytube::video', [
            'video' => $video,
            'user' => $user,
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'link' => ['required', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/'],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        if(!$user) {
            return redirect()->route('communitytube.index')
                ->with('error', trans('communitytube::messages.must_be_login'));
        }

        if($request->has('bypass_verification') && !$user->can('communitytube.bypass_verification')) {
            return redirect()->route('communitytube.index')
                ->with('error', trans('communitytube::messages.no-permission'));
        }

        if($request->has('add_as_hidden') && !$user->can('communitytube.manage')) {
            return redirect()->route('communitytube.index')
                ->with('error', trans('communitytube::messages.no-permission'));
        }

        if($request->has('author') && !$user->can('communitytube.set_video_author')) {
            return redirect()->route('communitytube.index')
                ->with('error', trans('communitytube::messages.no-permission'));
        }
    
        $link = $request->input('link');

        preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $link, $matches);
        $videoId = $matches[1] ?? null;
    
        if(!$videoId) {
            return redirect()->back()->with('error', trans('communitytube::messages.invalid_link'));
        }

        $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
    
        if(!@getimagesize($thumbnailUrl)) {
            $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
        }
        
        $description = $request->get('description') == null ? trans('communitytube::messages.default_description') : $request->get('description');

        CommunityTube::insert([
            'video_url' => $link,
            'title' => $request->input('title'),
            'description' => $description,
            'thumbnail_url' => $thumbnailUrl,
            'submitter' => $user->id,
            'hidden' => $request->has('add_as_hidden') && $request->boolean('add_as_hidden'),
            'verified' => $request->has('bypass_verification') && $request->boolean('bypass_verification'),
            'verifier' => $request->boolean('bypass_verification') ? $user->id : null,
            'verified_at' => $request->boolean('bypass_verification') ? now() : null,
            'video_author_name' => $request->input('author'),
            'pined' => False,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('communitytube.index')
            ->with('success', trans('communitytube::messages.video_submitted_with_success'));
    }
    
}

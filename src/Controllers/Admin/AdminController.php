<?php

namespace Azuriom\Plugin\CommunityTube\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Azuriom\Plugin\CommunityTube\Models\CommunityTube;

class AdminController extends Controller
{
    public function index()
    {
        return view('communitytube::admin.index', [
            'videos' => CommunityTube::all(),
        ]);
    }

    public function accept(Request $request, $id) 
    {
        $user = Auth::user();
    
        if(!$user || !$user->can('communitytube.manage')) {
            return redirect()->route('communitytube.index')
                             ->with('c_error', trans('communitytube::messages.no-permission'));
        }
    
        $video = CommunityTube::find($id);

        if(!$video) {
            return redirect()->route('communitytube.index')
                             ->with('c_error', trans('communitytube::messages.video_not_found'));
        }

        $video->update([
            'verified' => true,
            'verified_by' => $user->id,
            'verified_at' => now(),
            'verifier_username' => $user->name,
        ]);    
    
        return redirect()->route('communitytube.admin.edit', ['id' => $id])
                         ->with('c_success', trans('communitytube::messages.admin.video_validated'));
    }

    public function delete(Request $request, $id) 
    {
        $user = Auth::user();
    
        if(!$user || !$user->can('communitytube.manage')) {
            return redirect()->route('communitytube.index')
                             ->with('c_error', trans('communitytube::messages.no-permission'));
        }

        $video = CommunityTube::where('id', $id);
    
        if(!$video) {
            return redirect()->route('communitytube.index')
                             ->with('c_error', trans('communitytube::messages.video_not_found'));
        }
    
       $video->delete();

        return redirect()->route('communitytube.admin.index')
                         ->with('c_success', trans('communitytube::messages.admin.video_deleted_c_successfully'));
    } 

    public function verif() 
    {
        return view('communitytube::admin.verif', [
            'videos' => CommunityTube::all(),
        ]);
    } 
    
    public function edit($id)
    {
        $video = CommunityTube::find($id);
        $user = Auth::user();

        return view('communitytube::admin.edit', [
            'video' => $video,
            'user' => $user,
        ]);
    }

    public function edit_submit(Request $request, $id)
    {
        $user = Auth::user();
    
        if(!$user || !$user->can('communitytube.manage')) {
            return redirect()->route('communitytube.index')
                             ->with('c_error', trans('communitytube::messages.no-permission'));
        }
    
        $title = $request->input('title');
        $description = $request->input('description');
        $video_url = $request->input('link');
        $pined = $request->boolean('pin'); 
        $hidden = $request->boolean('hide');
        $author = $request->input('author');
    
        $video = CommunityTube::find($id);
    
        $video->update([
            'title' => $title,
            'description' => $description,
            'video_url' => $video_url,
            'pined' => $pined,
            'video_author_name' => $author,
            'hidden' => $hidden,
            'updated_at' => now(),
        ]);
    
        return redirect()->route('communitytube.admin.index')
                         ->with('c_success', trans('communitytube::messages.admin.video_edited_c_successfully'));
    }    
}

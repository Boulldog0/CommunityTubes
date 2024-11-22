<?php
namespace Azuriom\Plugin\CommunityTube\Controllers;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Azuriom\Plugin\CommunityTube\Models\CommunityTube;
use Azuriom\Plugin\CommunityTube\Models\CommunityTubeLikes;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('c_error', trans('communitytube::messages.must_be_login'));
        }

        $video = CommunityTube::find($id);
        if (!$video) {
            return redirect()->back()->with('c_error', trans('communitytube::messages.no_video_found'));
        }

        $like = CommunityTubeLikes::where('user_id', $user->id)
                                  ->where('video_id', $video->id)
                                  ->first();

        if ($like) {
            $like->delete();
            $video->update([
                'likes' => $video->likes - 1,
            ]);
            return redirect()->back()->with('c_success', trans('communitytube::messages.like_removed_c_successfully'));
        } else {
            CommunityTubeLikes::create([
                'user_id' => $user->id,
                'video_id' => $video->id,
            ]);
            $video->update([
                'likes' => $video->likes + 1,
            ]);
            return redirect()->back()->with('c_success', trans('communitytube::messages.like_added_c_successfully'));
        }
    }
}

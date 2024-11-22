<?php

namespace Azuriom\Plugin\CommunityTube\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityTubeLikes extends Model
{
    protected $table = 'communitytubes_likes';

    protected $fillable = [
        'video_id',
        'user_id',
    ];

    public static function hasLiked($userId, $videoId)
    {
        if(!$userId) return false;
        return self::where('user_id', $userId)
                   ->where('video_id', $videoId)
                   ->exists();
    }
}
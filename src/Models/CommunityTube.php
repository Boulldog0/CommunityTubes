<?php

namespace Azuriom\Plugin\CommunityTube\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityTube extends Model
{
    protected $table = 'communitytube_videos';

    protected $fillable = [
        'title',
        'description',
        'video_url',
        'verified',
        'verifier',
        'verified_at',
        'video_author_name',
        'likes',
        'pined',
        'hidden',
    ];
}

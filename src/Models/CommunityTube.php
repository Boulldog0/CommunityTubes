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
        'verified_by',
        'verified_at',
        'verifier_username',
        'video_author_name',
        'likes',
        'pined',
        'hidden',
    ];
}

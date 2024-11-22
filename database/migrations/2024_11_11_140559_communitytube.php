<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communitytube_videos', function(Blueprint $table) {
            $table->id();
            $table->string('video_url');
            $table->string('thumbnail_url');
            $table->integer('author_id');
            $table->string('author_name');
            $table->string('title');
            $table->string('description');
            $table->integer('likes');
            $table->boolean('verified');
            $table->boolean('pined');
            $table->string('video_author_name')->nullable();
            $table->boolean('hidden');
            $table->integer('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('verifier_username')->nullable();
            $table->timestamps();
        });

        Schema::create('communitytubes_likes', function(Blueprint $table) {
            $table->id();
            $table->integer('video_id');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communitytube_videos');
    }
};

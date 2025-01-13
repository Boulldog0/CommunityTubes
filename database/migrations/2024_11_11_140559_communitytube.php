<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communitytube_videos', function (Blueprint $table) {
            $table->id();
            $table->string('video_url');
            $table->string('thumbnail_url');
            $table->unsignedBigInteger('submitter'); 
            $table->string('title');
            $table->text('description');
            $table->boolean('verified')->default(false);
            $table->boolean('pined')->default(false);
            $table->string('video_author_name')->nullable();
            $table->boolean('hidden')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verifier')->nullable();
            $table->timestamps();
        });

        Schema::create('communitytube_likes', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('video_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('video_id')->references('id')->on('communitytube_videos')->cascadeOnDelete();
            $table->unique(['video_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communitytube_likes');
        Schema::dropIfExists('communitytube_videos');
    }
};

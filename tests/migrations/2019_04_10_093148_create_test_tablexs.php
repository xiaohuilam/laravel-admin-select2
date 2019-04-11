<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestTablexs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');

            $table->timestampsTz();
            $table->softDeletesTz();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->index();
            $table->text('content');

            $table->timestampsTz();
            $table->softDeletesTz();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->morphs('commentable');

            $table->timestampsTz();
            $table->softDeletesTz();
        });

        Schema::create('taggable', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id')->index();
            $table->morphs('taggable');

            $table->timestampsTz();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('taggable');
        Schema::dropIfExists('tags');
    }
}

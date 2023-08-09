<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('title');
            $table->string('image');
            $table->string('description');
            $table->string('amount');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->index('user_id');


        });
        $procedure = "CREATE OR REPLACE FUNCTION get_post_count(p_author_id IN posts.id%TYPE)
                        RETURN NUMBER  IS   v_post_count NUMBER;

                        BEGIN
                            SELECT COUNT(id) INTO v_post_count    FROM posts   WHERE user_id = p_author_id;
                            RETURN v_post_count;

                        EXCEPTION

                            WHEN NO_DATA_FOUND THEN
                                RETURN 0; -- Author not found, return 0 posts
                            WHEN OTHERS THEN
                                RAISE; -- raise the exception

                        END;";

        \DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}

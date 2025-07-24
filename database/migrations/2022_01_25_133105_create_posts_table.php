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
            $table->string('home_name');
            $table->string('telephone', 20);
            $table->string('home_type', 100);
            $table->string('accommodation_type', 100);
            $table->integer('num_rooms')->default(0);
            $table->integer('num_bathrooms')->default(0);
            $table->string('description');
            $table->string('location');
            $table->decimal('longitude', 11,8);
            $table->decimal('latitude',10,8);
            $table->enum('price_type',['per_night','per_month']);
            $table->string('amount');
            $table->decimal('price',10,2);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->index('user_id');


        });
        /**
         * Oracle Database.
         * $procedure = "CREATE OR REPLACE FUNCTION get_post_count(p_author_id IN posts.id%TYPE)
         * RETURN NUMBER  IS   v_post_count NUMBER;
         *
         * BEGIN
         * SELECT COUNT(id) INTO v_post_count    FROM posts   WHERE user_id = p_author_id;
         * RETURN v_post_count;
         *
         * EXCEPTION
         *
         * WHEN NO_DATA_FOUND THEN
         * RETURN 0; -- Author not found, return 0 posts
         * WHEN OTHERS THEN
         * RAISE; -- raise the exception
         *
         * END;";
         */

        DB::unprepared("DROP FUNCTION IF EXISTS get_post_count");

        DB::unprepared("
    CREATE FUNCTION get_post_count(p_author_id INT)
    RETURNS INT
    DETERMINISTIC
    BEGIN
        DECLARE v_post_count INT DEFAULT 0;
        SELECT COUNT(id) INTO v_post_count FROM posts WHERE user_id = p_author_id;
        RETURN v_post_count;
    END
");
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

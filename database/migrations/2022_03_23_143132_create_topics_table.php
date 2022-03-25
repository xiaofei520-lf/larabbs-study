<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
	public function up()
	{
		Schema::create('topics', function(Blueprint $table) {
            $table->increments('id');
            $table->text('title')->nullable()->comment('标题');
            $table->text('body')->nullable()->comment('内容');
            $table->text('excerpt')->nullable()->comment('摘录');
            $table->integer('user_id')->unsigned()->comment('用户');
            $table->integer('category_id')->unsigned()->comment('分类');
            $table->integer('reply_count')->default(0)->index();
            $table->integer('view_count')->unsigned()->default(0)->index();
            $table->integer('vote_count')->default(0)->index();
            $table->integer('last_reply_user_id')->unsigned()->default(0)->index();
            $table->integer('order')->default(0)->index();
            $table->enum('is_excellent', ['yes',  'no'])->default('no')->index();
            $table->enum('is_blocked', ['yes',  'no'])->default('no')->index();
            $table->text('body_original')->nullable();
            $table->text('slug')->nullable();
            $table->enum('is_tagged', ['yes',  'no'])->default('no')->index();
            $table->softDeletes();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('topics');
	}
};

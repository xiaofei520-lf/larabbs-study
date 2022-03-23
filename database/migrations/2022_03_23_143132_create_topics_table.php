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
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('topics');
	}
};

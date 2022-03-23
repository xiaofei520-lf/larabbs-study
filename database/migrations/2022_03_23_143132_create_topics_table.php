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
            
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('topics');
	}
};

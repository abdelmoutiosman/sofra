<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->text('body');
			$table->integer('order_id')->unsigned();
			$table->integer('notificateable_id');
			$table->string('notificateable_type');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}
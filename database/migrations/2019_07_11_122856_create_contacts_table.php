<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->text('content');
			$table->enum('type', array('complaint', 'suggestion', 'inquiry'));
			$table->integer('contactable_id');
			$table->string('contactable_type');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}
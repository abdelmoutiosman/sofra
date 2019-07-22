<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->text('notes');
			$table->enum('state', array('pending', 'accepted', 'rejected', 'delivered', 'decliened'));
			$table->integer('client_id')->unsigned();
			$table->integer('resturant_id')->unsigned();
			$table->integer('payment_method_id')->unsigned();
			$table->decimal('cost', 8,2)->default('0');
			$table->decimal('delivery_cost', 8,2)->default('0');
			$table->decimal('total_price', 8,2)->default('0');
			$table->decimal('commission', 8,2)->default('0');
			$table->decimal('net', 8,2)->default('0');
			$table->text('address');
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
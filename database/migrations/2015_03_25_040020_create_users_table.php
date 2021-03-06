<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('slug');
			$table->string('role');
            $table->string('email')->unique();
			$table->string('password');
            $table->string('telephone')->nullable();
            $table->integer('extension')->nullable();
            $table->string('skype_name')->nullable();
			$table->integer('department_id')->foreign('department_id')->references('id')->on('departments');
			$table->integer('location_id')->foreign('location_id')->references('id')->on('locations');
            $table->boolean('super_user')->default(0);
			$table->boolean('confirmed')->default(0);
			$table->string('confirmation_token')->nullable();
			$table->rememberToken();
			$table->timestamps();
			$table->index('department_id');
			$table->index('location_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}

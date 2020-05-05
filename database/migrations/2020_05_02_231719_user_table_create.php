<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
//            $table->unsignedBigInteger('list_id');
            $table->string('email', 40)->unique();
            $table->string('password',20);
            $table->string('api_token',100)->nullable();
            $table->string('active',20)->default(0);
            $table->string('role',20)->default(0);
            $table->timestamps();

            //         $table->foreign('list_id')->references('id')->on('lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

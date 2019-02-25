<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id_orders');
            $table->string('name_cus');
            $table->string('no_meja');
            $table->integer('qty');
            $table->integer('total');
            $table->string('status');
            $table->integer("created_by");
            $table->integer("updated_by")->nullable();
            $table->integer("deleted_by")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

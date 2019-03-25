<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDetailsOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id');
            $table->integer('food_id');
            $table->integer('qty');
            $table->integer('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details_order');
    }
}

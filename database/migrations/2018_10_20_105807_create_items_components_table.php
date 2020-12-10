<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_components', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('item_id')->index();

            $table->unsignedInteger('component_id')->index();

            $table->decimal('concentration',10,5)->default(0.00100);

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
        Schema::dropIfExists('items_components');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMixesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mixes_items', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('mix_id')->index();
            $table->foreign('mix_id')
                ->references('id')->on('mixes')
                ->onDelete('cascade');

            $table->unsignedInteger('item_id')->index();
            $table->foreign('item_id')
                ->references('id')->on('items')
                ->onDelete('cascade');

            $table->decimal('percentage',5,2);

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
        Schema::dropIfExists('mixes_items');
    }
}

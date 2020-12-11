<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name',255)->index();
            $table->string('code',255)->index()->unique();
            $table->string('print_code',255);
            $table->text('notes',255)->nullable();
            $table->text('print_notes',255)->nullable();
            $table->decimal('concentration_sum',10,5)->nullable();
            $table->date('issue_date');
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
        Schema::dropIfExists('items');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModulesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("modules", function(Blueprint $table){
            $table->increments('id');
            $table->string("name");
            $table->string("description");
            $table->unsignedInteger("status_id");
            $table->timestamps();

            $table->foreign("status_id")->on("statuses")->references("id")->onDelete("no action")->onUpdate("no action");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("modules");
    }
}

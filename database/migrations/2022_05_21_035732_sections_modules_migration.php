<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SectionsModulesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("sections_modules", function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger("module_id");
            $table->string("name");
            $table->unsignedInteger("status_id");
            $table->timestamps();

            $table->foreign("status_id")->on("statuses")->references("id")->onDelete("no action")->onUpdate("no action");
            $table->foreign("module_id")->on("modules")->references("id")->onDelete("no action")->onUpdate("no action");
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

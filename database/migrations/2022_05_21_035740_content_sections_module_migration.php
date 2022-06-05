<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContentSectionsModuleMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("content_sections_modules", function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger("section_module_id");
            $table->string("type");
            $table->string("content")->nullable();
            $table->unsignedInteger("status_id");
            $table->timestamps();

            $table->foreign("status_id")->on("statuses")->references("id")->onDelete("no action")->onUpdate("no action");
            $table->foreign("section_module_id")->on("modules")->references("id")->onDelete("no action")->onUpdate("no action");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("content_sections_modules");
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuestionsModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("questions_modules", function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger("content_section_module_id");
            $table->string("question");
            $table->integer("question_number");
            $table->timestamps();

            $table->foreign("content_section_module_id")->on("content_sections_modules")->references("id")->onDelete("no action")->onUpdate("no action");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("questions_modules");  
    }
}

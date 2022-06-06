<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnswersModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("answers_modules", function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger("question_module_id");
            $table->string("answers");
            $table->integer("is_correct");
            $table->timestamps();

            $table->foreign("question_module_id")->on("questions_modules")->references("id")->onDelete("no action")->onUpdate("no action");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("answers_modules");
    }
}

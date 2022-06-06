<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("users", function(Blueprint $table){
            $table->increments("id");
            $table->string("uid");
            $table->string("fullname");
            $table->string("email")->unique();
            $table->string("password");
            $table->string("document_type");
            $table->string("document");
            $table->string("nationality");
            $table->string("address");
            $table->string("country");
            $table->string("city");
            $table->integer("module_finished")->default(0);
            $table->integer("section_finished")->default(0);
            $table->unsignedInteger("status_id");
            $table->timestamps();

            $table->foreign("status_id")->on("statuses")->references("id")->onUpdate("no action")->onDelete("no action");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("users");
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestcasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testcases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category1', 225);
            $table->string('category2', 225)->nullable()->default("");
            $table->string('category3', 225)->nullable()->default("");
            $table->text('process1');
            $table->text('process2')->nullable()->default(null);
            $table->text('expected_result');
            $table->text('note')->nullable()->default(null);
            $table->string('project_name', 225);
            $table->string('screen_name', 225);
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
        Schema::dropIfExists('testcases');
    }
}

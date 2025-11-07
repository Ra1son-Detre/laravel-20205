<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment');
            $table->timestamps();
            $table->string('author')->nullable();
            $table->morphs('commentable');
            
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('krepselis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('skelbimas_id');
            $table->integer('kiekis')->default(1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('skelbimas_id')->references('id')->on('skelbimai')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('krepselis');
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('skelbimu_nuotraukos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('skelbimas_id');
            $table->string('failo_url', 255);
            $table->timestamps();

            $table->foreign('skelbimas_id')->references('id')->on('skelbimai')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skelbimu_nuotraukos');
    }
};


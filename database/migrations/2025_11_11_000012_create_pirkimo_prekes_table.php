<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pirkimo_prekes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pirkimas_id');
            $table->unsignedBigInteger('skelbimas_id');
            $table->decimal('kaina', 10, 2);
            $table->integer('kiekis')->default(1);
            $table->timestamps();

            $table->foreign('pirkimas_id')->references('id')->on('pirkimai')->onDelete('cascade');
            $table->foreign('skelbimas_id')->references('id')->on('skelbimai')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pirkimo_prekes');
    }
};


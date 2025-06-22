<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pstco_kalinga', function (Blueprint $table) {
            $table->id(); 
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 8);  
            $table->decimal('longitude', 11, 8); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pstco_kalinga');
    }
};


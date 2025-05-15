<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Create coordinates table
        Schema::create('coordinates', function (Blueprint $table) {
            $table->id('loc_id'); // auto-increment, primary key
            $table->decimal('latitude', 10, 8); // 10 digits, 8 after decimal for precision
            $table->decimal('longitude', 11, 8); // 11 digits, 8 after decimal for precision
            $table->timestamps();
        });

        // Create tbl_kalinga table
        Schema::create('tbl_kalinga', function (Blueprint $table) {
            $table->id('proj_id'); // auto-increment, primary key
            $table->unsignedBigInteger('proj_loc'); // foreign key reference to coordinates table
            $table->string('org_name');
            $table->string('proj_type');
            $table->string('proj_name');
            $table->text('proj_desc');
            $table->timestamp('proj_created');
            $table->string('proj_address');
            $table->string('sector');
            $table->string('status');

            // Define foreign key constraint
            $table->foreign('proj_loc')->references('loc_id')->on('coordinates')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        // Drop the tables if the migration is rolled back
        Schema::dropIfExists('tbl_kalinga');
        Schema::dropIfExists('coordinates');
    }
};

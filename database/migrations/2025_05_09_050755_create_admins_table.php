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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();
        });
    
        // Check if the admin already exists, and insert if not
        if (\DB::table('admins')->count() == 0) {
            \DB::table('admins')->insert([
                'username' => 'admin',
                'password' => \Hash::make('admin'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->enum('tipo', ['empleado', 'admin'])->nullable();
                $table->string('especialidad')->nullable();
                $table->rememberToken();
                $table->timestamps();
                $table->string('telefono')->nullable(); 
                $table->string('rfc', 255)->nullable();
            });
        }
        // Insertar los datos
        DB::table('users')->insert([
            ['id' => 4, 
            'name' => 'ANGELA MELENDEZ', 
            'email' => 'angela@gmail.com', 'email_verified_at' => NULL, 
            'password' => '$2y$12$IQ1Vk32i.Q/H8mntbJZCDuPWmHQwYguP39SXesqajfcfFJ8uPeZCq', 
            'tipo' => 'admin', 
            'remember_token' => 'O8vg4uw8kNvbFYf7mo9OX0SFvgBg6pngeOrfhldNsorJgYc8FAFppeQisZuN', 
            'created_at' => '2024-06-06 00:54:25', 'updated_at' => '2024-11-27 06:57:18', 
            'telefono' => NULL, 
            'rfc' => NULL],
            ['id' => 11, 'name' => 'ANGIE MELENDEZ', 'email' => 'angie@gmail.com', 'email_verified_at' => NULL, 
            'password' => '$2y$12$IQ1Vk32i.Q/H8mntbJZCDuPWmHQwYguP39SXesqajfcfFJ8uPeZCq', 'tipo' => 'empleado', 
            'remember_token' => NULL, 'created_at' => '2024-11-28 03:26:52', 'updated_at' => '2024-11-28 04:08:16', 
            'telefono' => '8342451633', 'rfc' => 'TAK123312'],
            ['id' => 15, 'name' => 'Damaris', 'email' => 'damaris@gmail.com', 'email_verified_at' => NULL, 
            'password' => '$2y$12$ChcnUwKRlPCNRgDu96DFrO.pggky8DhylChmOXcs723EhupxeWDKq', 'tipo' => 'empleado', 
            'remember_token' => NULL, 'created_at' => '2024-11-28 04:14:17', 'updated_at' => '2024-11-28 04:14:17', 
            'telefono' => '8341111111', 'rfc' => 'damaris01'],
            ['id' => 16, 'name' => 'Jesus', 'email' => 'chuy@gmail.com', 'email_verified_at' => NULL, 
            'password' => '$2y$12$j54aq1Ppx//KgMg82OQ7vu9V/OgKJvrCvESUm.PZH50J/YaI3Sw0y', 'tipo' => 'empleado', 
            'remember_token' => NULL, 'created_at' => '2024-11-28 04:14:57', 'updated_at' => '2024-11-28 04:14:57', 
            'telefono' => '8340000000', 'rfc' => 'Jesus03']
        ]);

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::enableForeignKeyConstraints();
    }
};

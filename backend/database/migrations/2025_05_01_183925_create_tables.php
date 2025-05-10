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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(0);
            $table->boolean('is_blocked')->default(0);
            $table->unsignedBigInteger('plan_id')->nullable();
        });

        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            $table->string('key')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->json('benefits')->nullable();
            $table->double('price')->default(0);
            $table->timestamps();
        });

        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
           
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->text('message');
            $table->json('filenames')->nullable();
            $table->timestamps();
        });

        Schema::create('skin_conditions', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image_filename')->nullable();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('transaction_id')->nullable();
            $table->double('amount')->default(0);
            $table->string('plan')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropAllTables();
    }
};

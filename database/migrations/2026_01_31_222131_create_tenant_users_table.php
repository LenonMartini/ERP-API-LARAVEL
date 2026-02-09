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
        Schema::create('tenant_users', function (Blueprint $table) {
            $table->id();

            // FK para tenants
            $table->foreignId('tenant_id')
                ->constrained()
                ->cascadeOnDelete();

            // FK para users (UUID)
            $table->uuid('user_id');

            $table->timestamps();

            // 🔒 Um usuário só pode pertencer a UM tenant
            $table->unique('user_id');

            // FK manual porque users.id é UUID
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_users');
    }
};

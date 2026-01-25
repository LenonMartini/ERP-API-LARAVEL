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
        Schema::create('branch_fiscal_settings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('branch_id');

            $table->enum('environment', ['HOMOLOGATION', 'PRODUCTION']);

            // NF-e
            $table->string('nfe_series', 3);
            $table->integer('nfe_last_number')->default(0);

            // NFC-e
            $table->string('nfce_series', 3)->nullable();
            $table->integer('nfce_last_number')->nullable();
            $table->string('nfce_csc_id')->nullable();
            $table->string('nfce_csc_code')->nullable();

            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_fiscal_settings');
    }
};

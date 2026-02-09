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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tenant_id');

            // Regime tributário (CRT)
            $table->unsignedBigInteger('crt_id');

            // Identificação
            $table->string('name'); // Razão social
            $table->string('trade_name')->nullable(); // Nome fantasia
            $table->string('code', 14); // código interno
            $table->string('cnpj', 14)->unique();
            $table->string('state_registration'); // IE
            $table->string('municipal_registration')->nullable(); // IM
            $table->string('status')->default('ACTIVE');

            // Endereço (SEFAZ)
            $table->string('zip_code', 8);
            $table->string('address');
            $table->string('address_number');
            $table->string('address_complement')->nullable();
            $table->string('neighborhood');
            $table->string('city');
            $table->string('ibge_city_code', 7);
            $table->string('state', 2);

            // Contato
            $table->string('phone', 15);

            $table->timestamps();

            $table->unique(['tenant_id', 'code']);

            $table->foreign('tenant_id')->references('id')->on('tenants');

            $table->foreign('crt_id')->references('id')->on('tax_regimes');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};

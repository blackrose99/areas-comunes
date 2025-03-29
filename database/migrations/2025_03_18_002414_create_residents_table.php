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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('last_name');
            $table->string('document')->index();
            $table->string('document_type');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('status');
            $table->softDeletes();
            $table->unique(columns: ['document', 'email', 'phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};

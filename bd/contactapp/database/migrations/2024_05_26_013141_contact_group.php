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
       
        Schema::create('contact_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contacts_id')->constrained('contacts')->onDelete('cascade');
            $table->foreignId('groups_id')->constrained('groups')->onDelete('cascade');
            $table->timestamps();
        });
        }
        
     
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_group');
        }
};

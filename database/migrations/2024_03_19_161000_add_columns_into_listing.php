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
        if (!Schema::hasColumn('listings', 'bedroom')) {
            Schema::table('listings', function (Blueprint $table) {
                $table->unsignedBigInteger('bedroom')->after('type')->nullable();
                $table->foreign('bedroom')->references('id')->on('beds')->onDelete('cascade');
            });
        }

        if (!Schema::hasColumn('listings', 'bathroom')) {
            Schema::table('listings', function (Blueprint $table) {
                $table->unsignedBigInteger('bathroom')->after('type')->nullable();
                $table->foreign('bathroom')->references('id')->on('baths')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            //
        });
    }
};

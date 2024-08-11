<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::raw('CREATE DATABASE IF NOT EXISTS '. env('DB_DATABASE'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};

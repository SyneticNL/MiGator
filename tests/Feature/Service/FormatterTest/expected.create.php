<?php

declare(strict_types=1);

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
        Schema::create('foos', static function (Blueprint $table) {
            $table->id();
            $table->text('baz');
            $table->integer('bar');
        });

        Schema::create('bars', static function (Blueprint $table) {
            $table->text('foo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};

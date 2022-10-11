<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class users_typos extends Migration
{
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table) {
        $table->id();
        $table->string('name');
        });
    }

    public function down(): void
    {
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Section\Enums\Type;

return new class extends Migration
{
    /**
     * Update theme appearance primary color to #FFA500 (orange).
     */
    public function up(): void
    {
        if (!Schema::hasTable('sections')) {
            return;
        }

        DB::table('sections')
            ->where('type', Type::THEME_APPEARANCE)
            ->where('key', 'primary_color')
            ->update(['value' => '#FFA500']);
    }

    /**
     * Revert to previous default (blue).
     */
    public function down(): void
    {
        if (!Schema::hasTable('sections')) {
            return;
        }

        DB::table('sections')
            ->where('type', Type::THEME_APPEARANCE)
            ->where('key', 'primary_color')
            ->update(['value' => '#2d70d9']);
    }
};

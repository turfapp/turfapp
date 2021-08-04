<?php

/*
 * TurfApp - An alternative for paper tally lists.
 * Copyright (C) 2021  Marijn van Wezel
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

use App\Models\TurfLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Class TurfLogsStockeditdry
 *
 * This migration alters the "turf_logs" table to add the following items to the "turf_log_type" enum:
 *
 * - "stockeditdry"
 */
class TurfLogsStockeditdry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->alterEnum('turf_logs', 'turf_log_type', ['increment', 'decrement', 'useradd', 'userleave', 'userdel', 'updatesettings', 'creategroup', 'userreset', 'userpromote', 'userdemote', 'stockedit', 'stockeditdry']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::transaction(function() {
            TurfLog::where('turf_log_type', 'stockeditdry')->delete();
            $this->alterEnum('turf_logs', 'turf_log_type', ['increment', 'decrement', 'useradd', 'userleave', 'userdel', 'updatesettings', 'creategroup', 'userreset', 'userpromote', 'userdemote', 'stockedit']);
        });
    }

    /**
     * Alter an enum field constraints.
     *
     * @see https://stackoverflow.com/a/36198549/7513161
     *
     * @param string $table
     * @param string $field
     * @param array $options
     */
    protected function alterEnum(string $table, string $field, array $options): void
    {
        $check = "${table}_${field}_check";

        $enum_list = [];

        foreach($options as $option) {
            $enum_list[] = sprintf("'%s'::CHARACTER VARYING", $option);
        }

        $enum_string = implode(', ', $enum_list);

        DB::transaction(function () use ($table, $field, $check, $options, $enum_string) {
            DB::statement(sprintf('ALTER TABLE %s DROP CONSTRAINT %s;', $table, $check));
            DB::statement(sprintf('ALTER TABLE %s ADD CONSTRAINT %s CHECK (%s::TEXT = ANY (ARRAY[%s]::TEXT[]))', $table, $check, $field, $enum_string));
        });
    }
}

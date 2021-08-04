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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class TurfLogsTable
 *
 * This migration creates the "turf_logs" table.
 *
 * @see \App\Models\TurfLog for the associated model
 */
class TurfLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turf_logs', function (Blueprint $table) {
            // Columns
            $table->id();
            $table->enum('turf_log_type', ['increment', 'decrement']);

            $table->foreignId('group_id');
            $table->foreignId('actor_user_id');
            $table->foreignId('receiver_user_id');

            // Foreign keys
            $table->foreign('group_id')
                ->references('id')
                ->on('groups');

            $table->foreign('actor_user_id')
                ->references('id')
                ->on('users');

            $table->foreign('receiver_user_id')
                ->references('id')
                ->on('users');

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('turf_logs');
    }
}

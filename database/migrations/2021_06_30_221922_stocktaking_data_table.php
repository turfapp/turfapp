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
 * Class StocktakingDataTable
 *
 * This migration creates the "stocktaking_data" table.
 *
 * @see \App\Models\StocktakingData for the associated model
 */
class StocktakingDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocktaking_data', function (Blueprint $table) {
            // Columns
            $table->id();

            $table->integer('total_num_tallies');
            $table->integer('total_difference');
            $table->integer('current_inventory');

            $table->foreignId('group_id');

            // Foreign keys
            $table->foreign('group_id')
                ->references('id')
                ->on('groups');

            // Indexes
            $table->unique(['group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stocktaking_data');
    }
}

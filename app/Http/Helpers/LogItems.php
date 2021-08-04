<?php

/*
 * TurfApp - TurfApp - An alternative for paper tally lists.
 *  Copyright (C) 2021  Marijn van Wezel
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

namespace App\Http\Helpers;

use App\Models\TurfLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Trait LogItems
 *
 * @package App\Http\Controllers\App\Group
 */
trait LogItems
{
    /**
     * Groups the given collection of log items by their creation date and returns the result
     * as a new collection.
     *
     * @param Collection $log_items
     * @return Collection
     */
    public function groupLogItemsByDate(Collection $log_items): Collection
    {
        return $log_items->groupBy(function (TurfLog $log_item) {
            return Carbon::parse($log_item->created_at)->formatLocalized('%e %B, %Y');
        });
    }
}

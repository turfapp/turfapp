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

namespace App\Http\Helpers\Awards;

use App\Models\Membership;
use App\Models\TurfAggregation;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class TallyKingAward
 *
 * This award is awarded to the person that has received the most +tally's in
 * any group of a specific group. In other words, this award considers only
 * people in the current group (the group the user is looking at), but considers
 * +tally's in all groups.
 *
 * @package App\Data\Awards
 */
class TallyKingAward implements Award
{
    private const AGGREGATION_TIMESPAN_IN_DAYS = 7;
    private static array $aggregation_data_cache;

    /**
     * BeerKingAward constructor.
     *
     * @param Membership $membership Unused in this award
     */
    public function __construct(Membership $membership)
    {
        // $membership is unused in this award
    }

    /**
     * @inheritDoc
     */
    public function getAwardHTML(): string
    {
        $title = htmlspecialchars(__('Tally King'));
        return sprintf('<span title="%s"><i class="fas fa-crown"></i></span>', $title);
    }

    /**
     * @inheritDoc
     */
    public static function isGranted(Membership $membership): bool
    {
        $membership_group_id = $membership->group->id;
        $membership_group_members = $membership->group->memberships;

        if (!isset(self::$aggregation_data_cache[$membership_group_id])) {
            // The maximum age of tally's we are considering. A tally from more than AGGREGATION_TIMESPAN_IN_DAYS
            // days ago is not taken into account when calculating who gets to be "tally king".
            $aggregation_timestamp = Carbon::today()->subDays(self::AGGREGATION_TIMESPAN_IN_DAYS);

            /** @var Collection $total_amount_data */
            $total_amount_aggregate_data = TurfAggregation::where('created_at', '>=', $aggregation_timestamp)
                // We do not consider any tally's that were removed when calculating who becomes "tally king"
                ->where('amount', '>', 0)
                // Group the data based on the user_id and calculate the total sum of tally's that person
                // received in the dataset. This gives us a model that has a user_id, a group_id and the
                // TOTAL amount of POSITIVE tally's that person received in the past AGGREGATION_TIMESPAN_IN_DAYS
                // days
                ->groupBy('user_id')
                ->selectRaw('SUM(amount) as total_amount, user_id')
                // Order the data to easily get the membership with the highest "total_amount",
                // TODO: This can be optimized; we do not need a sorted set, we only need the greatest
                ->orderBy('total_amount', 'DESC')
                ->get();

            // We now filter all memberships that are not in the given memberships group. It would be better and more
            // efficient if this could be done in the query. The naive approach that was tried to incorporate this
            // feature in the query is to use another "where" clause, however, this causes the rows the "SUM" function
            // takes into account to only contain rows for the current group. This is not what we want; we want
            // "total_amount" to reflect the TOTAL amount of tally's over ALL groups.
            // TODO: Incorporate this into the query
            self::$aggregation_data_cache[$membership_group_id] = $total_amount_aggregate_data->filter(
                fn (TurfAggregation $model) => $membership_group_members->contains('user_id', $model->user->id)
            );
        }

        /** @var Collection $aggregation_data */
        $aggregation_data = self::$aggregation_data_cache[$membership_group_id];
        /** @var TurfAggregation $aggregation_model */
        $aggregation_model = $aggregation_data->first();

        return $aggregation_model !== null && $aggregation_model->user->id === $membership->user->id;
    }
}

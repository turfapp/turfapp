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

/**
 * Class Awards
 *
 * Container for helper functions concerning awards.
 *
 * @package App\Data\Awards
 */
class Awards
{
    private const AVAILABLE_AWARDS = [
        TallyKingAward::class
    ];

    /**
     * @var Award[][] Key-value pair of cached awards, where the key is the ID of the
     * membership, and the value the array of awards for that membership. Because
     * awards are calculated on the fly, and we want to minimize these expensive
     * calculations, all calls to Awards::forMembership() are cached. As such, only
     * the first call with a specific membership will be expensive.
     */
    private static array $awards_cache = [];

    /**
     * Returns which awards the given membership currently has. Awards are not static
     * for a specific membership. The list of awards is based on the current state of
     * the system.
     *
     * Calls to this function are cached. Therefore, only the first call with a
     * specific membership will be expensive.
     *
     * @param Membership $membership
     * @return Award[]
     */
    public static function forMembership(Membership $membership): array
    {
        $membership_id = $membership->id;

        if (!isset(self::$awards_cache[$membership_id])) {
            /** @var Award $c The class name of the award class */
            $granted_awards = array_filter(self::AVAILABLE_AWARDS, fn($c) => $c::isGranted($membership));
            /** @var Award[] $award_classes */
            $award_classes = array_map(fn($c) => new $c($membership), $granted_awards);

            self::$awards_cache[$membership_id] = $award_classes;
        }

        return self::$awards_cache[$membership_id];
    }
}

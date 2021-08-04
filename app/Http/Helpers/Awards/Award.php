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
 * Interface Award
 *
 * @package App\Data\Awards
 */
interface Award
{
    /**
     * Award constructor.
     *
     * @param Membership $membership The member for which this award was granted. May be used to return
     * additional metadata associated with a reward in the award's HTML code.
     */
    public function __construct(Membership $membership);

    /**
     * Returns the HTML for this award as it will be inserted into the ".awards" container. This HTML is not
     * escaped, therefore this function MUST return safe HTML!
     *
     * The reason we use a very generic function that just returns the HTML of an award instead of several
     * functions that construct the way the award is displayed through a template is because the display of
     * each award differs too much. Awards also need to be future-proof such that streaks or other metadata
     * can be displayed through the awards interface.
     *
     * @note This function MUST return safe HTML as the return value of this function will not be
     * escaped
     *
     * @return string The HTML to display in the ".awards" container
     */
    public function getAwardHTML(): string;

    /**
     * Returns whether or not this award is currently granted to the given member.
     *
     * @param Membership $membership The member for which to check if this award is granted
     * @return bool True if this award is currently granted, false otherwise
     */
    public static function isGranted(Membership $membership): bool;
}

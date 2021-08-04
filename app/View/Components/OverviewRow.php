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

namespace App\View\Components;

use App\Models\Membership;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Class OverviewRow
 *
 * @package App\View\Components
 */
class OverviewRow extends Component
{
    /**
     * @var bool Whether to print the username in bold
     */
    public bool $bold;

    /**
     * @var Membership The membership to display this row
     */
    public Membership $membership;

    /**
     * Create a new component instance.
     *
     * @param Membership $membership The membership to display this row
     */
    public function __construct(Membership $membership, bool $bold = false)
    {
        $this->bold = $bold;
        $this->membership = $membership;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.overview-row');
    }
}

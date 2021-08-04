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

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

/**
 * Class LogOverview
 *
 * @package App\View\Components
 */
class LogOverview extends Component
{
    /**
     * @var Collection The sections (groups) in this log overview, usually based on the
     * log's creation date
     */
    public Collection $groups;

    /**
     * @var int The number of log items that will be shown
     */
    public int $shown;

    /**
     * @var int The total number of log items
     */
    public int $total;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Collection $groups, int $shown, int $total)
    {
        $this->groups = $groups;
        $this->shown = $shown;
        $this->total = $total;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.log-overview');
    }
}

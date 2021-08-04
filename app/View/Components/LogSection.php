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
 * Class LogSection
 *
 * @package App\View\Components
 */
class LogSection extends Component
{
    /**
     * @var string The date for this log section
     */
    public string $log_date;

    /**
     * @var Collection The log items in this log section
     */
    public Collection $log_items;

    /**
     * Create a new component instance.
     *
     * @var string $log_date The date for this log section
     * @var Collection $log_items The log items in this log section
     *
     * @return void
     */
    public function __construct(string $date, Collection $items)
    {
        $this->log_date = $date;
        $this->log_items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.log-section');
    }
}

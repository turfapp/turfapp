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

namespace App\Listeners\Log;

use App\Factories\LogFactory;
use App\Listeners\Listener;
use App\Models\TurfLog;

/**
 * Class LoggingListener
 *
 * The base class for event listeners that interact with log models.
 *
 * @see TurfLog
 * @package App\Listeners\Log
 */
abstract class LoggingListener implements Listener
{
    /**
     * @var LogFactory The factory class used to construct new log models.
     */
    protected LogFactory $logFactory;

    /**
     * LogEventListener constructor.
     *
     * @param LogFactory $logFactory The factory class used to construct new log models
     */
    public function __construct(LogFactory $logFactory)
    {
        $this->logFactory = $logFactory;
    }
}

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

namespace App\Factories;

use App\Models\Group;
use App\Models\TurfLog;
use App\Models\User;
use InvalidArgumentException;

/**
 * Class LogFactory
 *
 * This class is responsible for creating TurfLog models.
 *
 * @package App\Factories
 */
class LogFactory implements Factory
{
    /**
     * List of valid log types.
     */
    public const TYPES = [
        'increment',
        'decrement',
        'useradd',
        'userleave',
        'userdel',
        'updatesettings',
        'creategroup',
        'userreset',
        'userpromote',
        'userdemote',
        'stockedit',
        'stockeditdry'
    ];

    /**
     * @var string The log type to construct
     */
    private string $type;

    /**
     * @var array The (additional) parameter to use in the construction
     */
    private array $parameters = [];

    /**
     * @var User The actor in the log
     */
    private User $actor;

    /**
     * @var User The receiver in the log
     */
    private User $receiver;

    /**
     * @var Group The group this log belongs to
     */
    private Group $group;

    /**
     * Set the log type.
     *
     * @param string $type
     * @return $this
     */
    public function withType(string $type): self
    {
        if (!in_array($type, self::TYPES)) {
            throw new InvalidArgumentException();
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Sets the additional parameters to use.
     *
     * @param array $parameters
     * @return $this
     */
    public function withParameters(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @param User $receiver
     * @return $this
     */
    public function withReceiver(User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @param User $actor
     * @return $this
     */
    public function withActor(User $actor): self
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * @param Group $group
     * @return $this
     */
    public function forGroup(Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function create(): TurfLog
    {
        $object = new TurfLog();

        $object->turf_log_type = $this->type;
        $object->group_id = $this->group->id;
        $object->receiver_user_id = $this->receiver->id;
        $object->actor_user_id = $this->actor->id;
        $object->turf_log_params = $this->parameters;

        return $object;
    }
}

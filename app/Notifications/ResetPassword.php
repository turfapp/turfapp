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

namespace App\Notifications;

use App\Mail\StandardEmail;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBaseNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

/**
 * An alternate ResetPassword notification class that overrides the route name
 * in the "toMail" function and provides localisation.
 */
class ResetPassword extends ResetPasswordBaseNotification
{
    /**
     * @inheritDoc
     */
    public function toMail($notifiable): MailMessage
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            $url = url(route('auth.password.reset.token', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        }

        return $this->buildMailMessage($url);
    }

    /**
     * @inheritDoc
     */
    public function buildMailMessage($url): MailMessage
    {
        $expiresIn = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

        return (new MailMessage())
            ->priority(2)
            ->subject(Lang::get('Reset your password'))
            ->view('emails.auth.reset-password', ['url' => $url, 'expires_in' => $expiresIn]);
    }
}

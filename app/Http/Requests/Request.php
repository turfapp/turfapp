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

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Request
 *
 * Wrapper class around FormRequest to support multiple request methods in a single
 * request object.
 *
 * @package App\Http\Requests
 */
abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    final public function authorize(): bool
    {
        return $this->authorizeAll() && match ($this->getMethod()) {
            'POST' => $this->authorizePost(),
            'GET' => $this->authorizeGet(),
            'PUT' => $this->authorizePut(),
            'PATCH' => $this->authorizePatch(),
            'DELETE' => $this->authorizeDelete()
        };
    }

    /**
     * This method is called for each request method. If it returns false, the request is
     * always blocked, otherwise the request specific authorize method is interrogated.
     *
     * @return bool
     */
    abstract public function authorizeAll(): bool;

    /**
     * This authorize method is called when a POST request is received.
     *
     * @return bool
     */
    public function authorizePost(): bool
    {
        return true;
    }

    /**
     * This authorize method is called when a GET request is received.
     *
     * @return bool
     */
    public function authorizeGet(): bool
    {
        return true;
    }

    /**
     * This authorize method is called when a PUT request is received.
     *
     * @return bool
     */
    public function authorizePut(): bool
    {
        return true;
    }

    /**
     * This authorize method is called when a PATCH request is received.
     *
     * @return bool
     */
    public function authorizePatch(): bool
    {
        return true;
    }

    /**
     * This authorize method is called when a DELETE request is received.
     *
     * @return bool
     */
    public function authorizeDelete(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return string[]
     */
    final public function rules(): array
    {
        return match ($this->getMethod()) {
            'POST' => $this->rulesPost(),
            'GET' => $this->rulesGet(),
            'PUT' => $this->rulesPut(),
            'PATCH' => $this->rulesPatch(),
            'DELETE' => $this->rulesDelete()
        };
    }

    /**
     * Get the validation rules when a POST request is received.
     *
     * @return string[]
     */
    public function rulesPost(): array
    {
        return [];
    }

    /**
     * Get the validation rules when a GET request is received.
     *
     * @return string[]
     */
    public function rulesGet(): array
    {
        return [];
    }

    /**
     * Get the validation rules when a PUT request is received.
     *
     * @return string[]
     */
    public function rulesPut(): array
    {
        return [];
    }

    /**
     * Get the validation rules when a PATCH request is received.
     *
     * @return string[]
     */
    public function rulesPatch(): array
    {
        return [];
    }

    /**
     * Get the validation rules when a DELETE request is received.
     *
     * @return string[]
     */
    public function rulesDelete(): array
    {
        return [];
    }
}

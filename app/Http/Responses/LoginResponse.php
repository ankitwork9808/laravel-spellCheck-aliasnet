<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Redirect;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;

class LoginResponse implements LoginResponseContract
{
    /**
     * toResponse
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function toResponse($request) : RedirectResponse
    {
        if (auth()->user()->type == 'Admin' || auth()->user()->type == 'Detector') {

            return Redirect::route('admin.dashboard');

        }elseif (auth()->user()->type == 'Manager') {

            return Redirect::route('manager.dashboard');

        }
    }
}
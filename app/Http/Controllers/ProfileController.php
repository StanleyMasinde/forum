<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    /**
     * Displays a user's profile.
     * This is publicly available.
     *
     * @param  Illuminate\Http\Request $request
     * @param  App\User                $user
     * @return Illuminate\Http\Response
     */
    public function index (Request $request, User $user)
    {
        return view('user.profile.index', [
            'user' => $user,
        ]);
    }
}

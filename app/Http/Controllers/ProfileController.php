<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $activities = Activity::feed($user);
//        dd($activities);

        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $activities,
        ]);
    }
}

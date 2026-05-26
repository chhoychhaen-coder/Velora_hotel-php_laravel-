<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function show(): View
    {
        return view('front.team', [
            'team' => User::whereIn('role', ['receptionist', 'manager', 'admin', 'staff'])->get(),
        ]);
    }
}

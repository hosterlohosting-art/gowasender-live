<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    /**
     * Show the Cloud API setup tutorial.
     *
     * @return \Illuminate\Http\Response
     */
    public function cloudapi()
    {
        return view('user.tutorial.cloudapi');
    }
}

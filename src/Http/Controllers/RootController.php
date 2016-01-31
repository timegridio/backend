<?php

namespace Timegridio\Backend\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class RootController extends Controller
{
    /**
     * get Index.
     *
     * @return Response Show Root dashboard
     */
    public function getIndex()
    {
        logger()->info(__METHOD__);
        logger()->warning('[ROOT ACCESS]');

        //////////////////
        // FOR REFACTOR //
        //////////////////

        $users = User::all();

        return view('Backend::dashboard', compact('users'));
    }

    /**
     * Switch authentication into another user for support purpose.
     *
     * @return Response Show Root dashboard
     */
    public function getSudo($userId)
    {
        logger()->info(__METHOD__);

        logger()->warning("[!] ROOT SUDO userId:{$userId}");
        auth()->loginUsingId($userId);

        flash()->warning('ADVICE: THIS IS FOR AUTHORIZED USE ONLY AND YOUR ACTIONS ARE BEING RECORDERED !!!');

        return redirect()->route('user.directory.list');
    }
}

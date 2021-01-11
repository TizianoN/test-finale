<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Server;

class AppController extends Controller
{
    /**
    * Show the profile for a given user.
    *
    * @return \Illuminate\View\View
    */
    public function dashboard()
    {
      return view('dashboard');
    }

    public function showServer( $serverId )
    {
      $server = Server::find($serverId);
      return view('serverDetail', [
        'server_available_ram' => $server->getAvailableRam(),
        'server' => $server->toArray(),
      ]);
    }
}

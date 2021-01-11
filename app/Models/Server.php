<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'servers';
    
    public $timestamps = false;

    public function getAvailableRam()
    {
      $serverRam = $this->ram;
      $vpsRam = Vps::where('server_id', '=', $this->id)->sum('ram');
      return $serverRam - $vpsRam;
    }
}

<?php
	namespace App\Http\Controllers;

	use App\Models\Server;
	use App\Models\Vps;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Response;

	class ApiController extends Controller
	{
		/**
		*
		* @method POST
		* @param $r : Request
		* @return bool
		*
		* Aggiunge un server alla tabella 'servers'
		*/
	    public function addServer( Request $r ) {
	    	$serverName = ( $r->filled( 'serverName' ) ) ? $r->serverName : null;
	    	$serverRam  = ( $r->filled( 'serverRam' ) ) ? $r->serverRam : null;

	    	if( empty( $serverName ) || empty( $serverRam ) ) {
	    		// Error
	    		$data['success'] = false;
	    		$data['message'] = "I campi 'nome' e 'ram' sono obbligatori.";
	    		return json_encode( $data , JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
	    	}

	    	$server = new Server();
	    	$server->name = $serverName;
	    	$server->ram  = $serverRam;

	    	try {
	    		$server->save();
	    		$data['success'] = true;
	    		$data['message'] = 'Server creato correttamente';
	    		return json_encode( $data , JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
	    	} catch (Exception $e)  {
	    		$data['success'] = false;
	    		$data['message'] = $e->getMessage();
	    		return json_encode( $data , JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
	    	}
	    }

	    /**
			*
	    * @method GET
	    * @param $id : Server ID
	    * @return JSON String
	    *
			* Restituisce un JSON di ogni server presente
	    */

	    public function getAllServers( ) {
	    	$servers = Server::all();

    		return json_encode( $servers , JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
	    }

	    /**
			*
	    * @method GET
	    * @param $id : Server ID
	    * @return JSON String
	    *
			* Restituisce un JSON del server indicato
	    */

	    public function getServerById( int $id ) {
	    	$server = Server::find( $id );
	    	if( empty( $server ) ) {
	    		$data['success'] = false;
	    		$data['message'] = 'Server not found';
	    		return json_encode( $data , JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
	    	}

    		return json_encode( $server , JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );

	    }

	    /**
	    *
	    * @method GET
	    * @param $name : Server Name
	    * @return JSON String
	    *
	    * Restituisce un JSON con la lista dei server con il nome indicato '$name'
	    */

	    public function getServerByName( String $name ) {
	    	$servers = Server::where( 'name' , 'like' , '%' . $name . '%')->get();
	    	return json_encode( $servers , JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
	    }

	    /**
	    *
	    * @method POST | PUT
			* @param $r : Request
			* @return Bool
			*
			* Crea una VPS all'interno di un server
			*/

	    public function createVPS( Request $r ) {
	    	$serverId = ( $r->filled( 'serverId' ) ) ? $r->serverId : null;
	    	$vpsRam 	= ( $r->filled( 'vpsRam' ) ) ? $r->vpsRam : null;
	    	$vpsName  = ( $r->filled( 'vpsName' ) ) ? $r->vpsName : null;

	    	if( empty( $serverId ) || empty( $vpsRam ) ) {
	    		// Error
	    		$data['success'] = false;
	    		$data['message'] = "The fields 'Name' and 'RAM' are required";
	    		return json_encode( $data , JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
	    	}

				$server = Server::find( $serverId );
				$available_ram = $server->getAvailableRam();
	    	if( $vpsRam > $available_ram ) {
	    		// Error
	    		$data['success'] = false;
	    		$data['message'] = "Not enough RAM.";
	    		return json_encode( $data , JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
	    	}

	    	$vps = new Vps();
	    	$vps->server_id = $serverId;
	    	$vps->name 			= $vpsName;
	    	$vps->ram 			= $vpsRam;

	    	try {
	    		$vps->save();
	    		$data['success'] = true;
	    		$data['message'] = 'VPS creato correttamente';
	    		return json_encode( $data , JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
	    	} catch (Exception $e)  {
	    		$data['success'] = false;
	    		$data['message'] = $e->getMessage();
	    		return json_encode( $data , JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
	    	}
	    }

	    /**
	    *
	    * @method GET
	    * @param $serverId : Id del server
	    * @return JSON String
	    *
	    * Restituisce la lista delle VPS di un server in formato JSON
	    */

	    public function getVPSOfServer( int $serverId ) {
	    	$vps = Vps::where( 'server_id' , '=' , $serverId)->get();
	    	return json_encode( $vps , JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
	    }

	    /**
	    *
	    * @method GET
	    * @param $serverId: Id del server
	    * @return int
	    *
	    * Ritorna il valore della RAM residua nel server
	    *
	    */

	    public function getAvailableRam( int $serverId ) {
	    	$server = Server::find( $serverId );
	    	return Response::json( $server->getAvailableRam() );
	    }

	    /**
	    *
	    * @method DELETE
	    * @param $id : Id della VPS da eliminare
	    * @return Bool
	    *
	    * Elimina la VPS indicata da '$id'
	    */

	    public function deleteVPS( int $serverId ) {
				Vps::where('id', '=', $serverId)->delete();
	    	return true;
	    }

	    /**
	    *
	    * @method DELETE
	    * @param $id : Id della VPS da eliminare
	    * @return Bool
	    *
	    * Elimina la VPS indicata da '$id'
	    */

	    public function deleteServer( int $serverId ) {
				echo $serverId;
				Vps::where( 'server_id' , '=' , $serverId)->delete();
				Server::where('id', '=', $serverId)->delete();
	    	return true;
	    }

	}

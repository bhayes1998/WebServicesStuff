<?php
/*
 * Scott Campbell
 * RoomController -> handle room requests
 * */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7;
use \GuzzleHttp\Exception\RequestException;
use \GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;

class Weather extends Controller
{
	public function getTemp() {
		if (isset($_SERVER['REQUEST_URI'])) {
                        $parts = explode("/",$_SERVER['REQUEST_URI']);
                        for ($i=0;$i<count($parts);$i++) {
                                $parts[$i] = htmlspecialchars($parts[$i]);
                        }
                } else {
                        $parts = array();
                }

                array_shift($parts);
                $clientZip = new Client([
                        'base_uri' => 'http://api.openweathermap.org/geo/1.0/',
                ]);
                $responseZip = $clientZip->request('GET','zip',
                        ['query' => [
                                'zip' => end($parts),
                                'APPID' => 'b3ea9041c7b81868083b7016b2558f93'
                        ]]);
                $bodyZip = $responseZip->getBody();
                $jsonDataZip = json_decode($bodyZip,true);

		Cache::put('lat', $jsonDataZip['lat'], $seconds=15);
		Cache::put('lon', $jsonDataZip['lon'], $seconds=15);

		$clientCoord = new Client([
                        'base_uri' => 'http://api.openweathermap.org/data/2.5/',
                ]);
                $responseCoord = $clientCoord->request('GET','weather',
                        ['query' => [
				'lat' => Cache::get('lat'),
				'lon' => Cache::get('lon'),
				'units' => 'imperial',
                                'APPID' => 'b3ea9041c7b81868083b7016b2558f93'
                        ]]);
                $bodyCoord = $responseCoord->getBody();
		$jsonDataCoord = json_decode($bodyCoord,true);
		
		$body = json_encode(array(
			'city' => $jsonDataCoord['name'],
			'temp' => $jsonDataCoord['main']['temp'],
			'zip' => end($parts),
			'cache' => '(LIVE)'
		));
		Cache::put('temp', $body, $seconds=15);
		return $body;
	}

	public function index() {
		if (isset($_SERVER['REQUEST_URI'])) {
                        $parts = explode("/",$_SERVER['REQUEST_URI']);
                        for ($i=0;$i<count($parts);$i++) {
                                $parts[$i] = htmlspecialchars($parts[$i]);
                        }
                } else {
                        $parts = array();
                }

                array_shift($parts);


                if (Cache::get('temp')) {
			$jsonData = json_decode(Cache::get('temp'),true);
			if ($jsonData['zip'] == end($parts)) {
				$jsonData['cache'] = '(CACHED)';
				$temp = json_encode($jsonData);
			} else {
				$temp = $this->getTemp();
			}

                } else {
                        $temp = $this->getTemp();
                }

                return response()->json(["message" => $temp], 201);
        }

}
?>

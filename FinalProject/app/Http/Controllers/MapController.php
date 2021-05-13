<?php
namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;
use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7;
use \GuzzleHttp\Exception\RequestException;
use \GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class MapController extends Controller
{

	public function getTemp($lat, $lon) {

		Cache::put('lat', $lat, $seconds=300);
		Cache::put('lon', $lon, $seconds=300);

		$clientCoord = new Client([
                        'base_uri' => 'https://api.openweathermap.org/data/2.5/',
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
			'cache' => '(LIVE)'
		));
		Cache::put('temp', $body, $seconds=300);
		return $body;
	}

	public function getWiki($city) {

                $client = new Client([
                        'base_uri' => 'https://en.wikipedia.org/w/',
                ]);
                $response = $client->request('GET', 'api.php',
                        ['query' => [
                                'action' => 'query',
                                'prop' => 'extracts',
                                'explaintext' => '1',
				'exchars' => '300',
				'titles' => $city,
				'format' => 'json',
				'formatversion' => '2'
			]]);
                $body = $response->getBody();
                $jsonData = json_decode($body,true);

                return $jsonData;
        }


        public function getMap() {
                $query = parse_url('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

                $path = explode("/", $query['path']);
                $city = $path[count($path)-1];

                return view('map', ['city' => $city]);
        }

        public function getCityInfo() {
                $client = new Client([
                        'base_uri' => 'https://campbest.451.csi.miamioh.edu/globalCityList/public/api/v1/city/',
                        'verify' => false
                ]);

                $query = parse_url('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		
		try {
                $path = explode("/", $query['path']);
                $city = $path[count($path)-1];
                $response = $client->request('GET', $city);
		$body = $response->getBody();
		
		$jsonDataCities = json_decode($body,true);
		if (Cache::get('temp')) {
			$jsonData = json_decode(Cache::get('temp'),true);

			error_log($jsonData['city'] . ", " . $city, 3, '/var/www/html/cse451-hayesbm3-web/FinalProject/app/Http/Controllers/error.txt');
			if (strtolower($jsonData['city']) == urldecode(strtolower($city))) {
				$jsonData['cache'] = '(CACHED)';
				$temp = json_encode($jsonData);
			} else {
				$temp = $this->getTemp($jsonDataCities['cities'][0]['LAT'], $jsonDataCities['cities'][0]['LON']);
			}

                } else {
                        $temp = $this->getTemp($jsonDataCities['cities'][0]['LAT'], $jsonDataCities['cities'][0]['LON']);
		}
		
		$wiki = $this->getWiki(ucwords(urldecode($city)));

                return response()->json(['body' => $jsonDataCities, 'temp' => json_decode($temp, true), 'wiki' => $wiki, 'status' => 'OK'], 200);
		} catch (Exception $error) {
			return response()->json(['body' => '', 'temp' => '', 'wiki' => '', 'status' => 'FAIL'], 200);
		}
        }
}
?>

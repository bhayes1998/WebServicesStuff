<?php
namespace App\Http\Controllers;
ob_start();
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

class TravelController extends Controller
{
        public function index(Request $request) {
                $CLIENT_ID = env('CLIENT_ID');
                if ($CLIENT_ID == "") {
                        die ("CLIENT ID NOT DEFINED");
                }
                $CLIENT_SECRET = env('CLIENT_SECRET');
                if ($CLIENT_SECRET == ""){
                        die ("CLIENT SECRET IS NOT DEFINED");
                }

		$code = $request->input("code","");
                if ($code == ""){
			
                         if (!isset($_SESSION['token'])){
                                  header('Location: https://todoist.com/oauth/authorize?client_id=' . $CLIENT_ID . '&scope=data:read_write,data:delete&state=fkjhffklshflks');
                                  exit();
                        }
                } else {
                         if (!isset($_SESSION['token'])){

                                $client = new Client([
                                        'base_uri' => 'https://todoist.com/oauth/'
                                ]);

                                $response = $client->request('POST','access_token',
                                ['query' => [
                                        'client_id' => $CLIENT_ID,
                                        'client_secret' => $CLIENT_SECRET,
                                        'code' => $code
                                ]]);
                                $body = $response->getBody();
                                $jsonData = json_decode($body,true);
                                if (!$jsonData['access_token'])
                                        die ('Access token not received');
                                $_SESSION['token'] = $jsonData['access_token'];
                                header('Location: https://hayesbm3.451.csi.miamioh.edu/cse451-hayesbm3-web/FinalProject/public/index.php/travel');
                                exit;
                        }
                }

		return view('travel');
	}

	public function getCities(){
		$token = $_SESSION['token'];
                $headers = [ 'Authorization' => 'Bearer ' . $token];
                $client = new Client([
                        'base_uri' => 'https://api.todoist.com/rest/v1/',
                        'headers' => $headers,
                ]);


                $response = $client->request('GET','projects',
                        ['header' => $headers]);

                $body = $response->getBody();
                $jsonData = json_decode($body,true);

                $project = '';
                $nameList = array();
		
                if (count($jsonData) < 1)
                        return response()->json(['status' => 'FAIL'], 201);

                for ($i=0;$i < count($jsonData); $i++){
                        if (strtolower($jsonData[$i]['name']) == 'cities') {
                                $project = $jsonData[$i]['id'];
				$_SESSION['project'] = $project;
                        }
		}
		
		if ($project == ''){
			$response = $client->request('POST','projects',
                        ['query' => [
                                'name' => 'cities'
                        ]],
                        ['header' => $headers]);
			
			$body = $response->getBody();
	                $jsonData = json_decode($body,true);
			
			$_SESSION['project'] = $jsonData['id'];		
		}

                if (count($jsonData) < 1)
                        return response()->json(['status' => $_SESSION['project']], 201);


                $response = $client->request('GET','tasks',
                        ['query' => [
                                'project_id' => $_SESSION['project']
                        ]],
                        ['header' => $headers]);
                $body = $response->getBody();
                $jsonData = json_decode($body,true);

                $cityNameList = array();

                for ($i=0;$i < count($jsonData); $i++){
                        array_push($cityNameList, $jsonData[$i]['content']);
                }

                return response()->json(['cityNames' => $cityNameList, 'status' => 'OK'], 200);

	}

	public function addCities(Request $request) {
		$validator = Validator::make($request->all(), [
			'cityName' => 'required'
		]);

		if ($validator->fails()){
			return redirect('/travel')->with(['message' => 'Please provide a city name'])->withInput($request->all());
		}
	
		$cityName = htmlspecialchars($request->cityName);

		$token = $_SESSION['token'];
                $headers = [ 'Authorization' => 'Bearer ' . $token];
                $client = new Client([
                        'base_uri' => 'https://api.todoist.com/rest/v1/',
                        'headers' => $headers,
                ]);

                $response = $client->request('POST','tasks',
                        ['json' => [
				'project_id' => $_SESSION['project'],
				'content' => $cityName
                        ]],
                        ['header' => $headers]);


		 return redirect('/travel')->with(['message' => 'City added!']);;

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

                $path = explode("/", $query['path']);
       		$city = $path[count($path)-1];
		error_log("Scree", 3, '/var/www/html/cse451-hayesbm3-web/FinalProject/app/Http/Controllers/error.txt');       
		$response = $client->request('GET', $city);
		error_log("Tree", 3, '/var/www/html/cse451-hayesbm3-web/FinalProject/app/Http/Controllers/error.txt');       
		$body = $response->getBody();
		$jsonData = json_decode($body,true);

		return response()->json(['body' => $jsonData, 'status' => 'OK'], 200);
	}

        public function logout(){
                session_unset();
                header('Location: https://hayesbm3.451.csi.miamioh.edu/cse451-hayesbm3-web/FinalProject/public/index.php');
                exit;
        }
}
?>

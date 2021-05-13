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

class TodoOAuthController extends Controller
{
	public function index() {
                $CLIENT_ID = env('CLIENT_ID');
                if ($CLIENT_ID == "") {
                        die ("CLIENT ID NOT DEFINED");
		}
		$CLIENT_SECRET = env('CLIENT_SECRET');
		if ($CLIENT_SECRET == ""){
			die ("CLIENT SECRET IS NOT DEFINED");
		}

		$temp = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$url = parse_url($temp);

		if (!parse_url($temp, PHP_URL_QUERY)){
			if (!isset($_SESSION['token'])){
				header('Location: https://todoist.com/oauth/authorize?client_id=' . $CLIENT_ID . '&scope=data:read&state=darthplagueisthewise');
				exit;
			}
		} else {	
			if (!isset($_SESSION['token'])){
				$query = $url['query'];
				parse_str($query, $queryArgs);

				$client = new Client([
					'base_uri' => 'https://todoist.com/oauth/'
                		]);
			
				$response = $client->request('POST','access_token',
                        	['query' => [
					'client_id' => $CLIENT_ID,
					'client_secret' => $CLIENT_SECRET,
					'code' => $queryArgs['code']
				]]);
        	        	$body = $response->getBody();
	                	$jsonData = json_decode($body,true);
				if (!$jsonData['access_token'])
					die ('Access token not received');

				$_SESSION['token'] = $jsonData['access_token'];
				header('Location: https://hayesbm3.451.csi.miamioh.edu/cse451-hayesbm3-web/laravel1-project/public/index.php/todoistoauth');
				exit;
			}	
		}

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

                $projectList = array();
                $nameList = array();

                if (count($jsonData) < 1)
                        return response()->json(['status' => 'FAIL'], 201);

                for ($i=0;$i < count($jsonData); $i++){
                        array_push($projectList, $jsonData[$i]['id']);
                        array_push($nameList, $jsonData[$i]['name']);
                }

                	return view('todoistoauth', compact('projectList', 'nameList', 'token'));
		
	}

	public function projects() {
		$query = parse_url('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		
		$path = explode("/", $query['path']);
		$token = $path[count($path)-2];
		$projectID = $path[count($path)-1];

		$headers = [ 'Authorization' => 'Bearer ' . $token];
		
                $client = new Client([
                        'base_uri' => 'https://api.todoist.com/rest/v1/',
                        'headers' => $headers,
                ]);

                $response = $client->request('GET','tasks',
                        ['query' => [
                                'project_id' => $projectID
                        ]],
                        ['header' => $headers]);
                $body = $response->getBody();
                $jsonData = json_decode($body,true);

                $contentList = array();

                if (count($jsonData) < 1)
                        return response()->json(['status' => 'FAIL'], 201);

                for ($i=0;$i < count($jsonData); $i++){
                        array_push($contentList, $jsonData[$i]['content']);
                }
                return response()->json(['status' => 'OK', 'content' => $contentList], 201);

	}

	public function logout(){
		session_unset();
		header('Location: https://hayesbm3.451.csi.miamioh.edu/cse451-hayesbm3-web/laravel1-project/public/index.php');
		exit;
	}
}
?>

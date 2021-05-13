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
                                  header('Location: https://todoist.com/oauth/authorize?client_id=' . $CLIENT_ID . '&scope=data:read&state=fkjhffklshflks');
                                  exit();
                        }
                } else {
                         error_log("else ", 3, "/var/www/html/cse451-hayesbm3-web/finalprojecttest/app/Http/Controllers/error.txt");
                         if (!isset($_SESSION['token'])){
                                  error_log("if 3 ", 3, "/var/www/html/cse451-hayesbm3-web/finalprojecttest/app/Http/Controllers/error.txt");
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
                                header('Location: https://hayesbm3.451.csi.miamioh.edu/cse451-hayesbm3-web/finalprojecttest/public/index.php/travel');
                                exit;
                        }
                }
                error_log("break ", 3, "/var/www/html/cse451-hayesbm3-web/finalprojecttest/app/Http/Controllers/error.txt");
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
                        }
                }

                if (count($jsonData) < 1)
                        return response()->json(['status' => $project], 201);


                $response = $client->request('GET','tasks',
                        ['query' => [
                                'project_id' => $project
                        ]],
                        ['header' => $headers]);
                $body = $response->getBody();
                $jsonData = json_decode($body,true);

                $contentList = array();

                if (count($jsonData) < 1)
                        return response()->json(['status' => $project], 201);

                for ($i=0;$i < count($jsonData); $i++){
                        array_push($contentList, $jsonData[$i]['content']);
                }
                //return response()->json(['status' => 'OK', 'content' => $contentList], 201);

		
                error_log("here is the evil: " . $contentList[3], 3, "/var/www/html/cse451-hayesbm3-web/finalprojecttest/app/Http/Controllers/error.txt");

                return response()->json(['data' => $contentList, 'status' => 'OK'], 200);

        }

        public function logout(){
                session_unset();
                header('Location: https://hayesbm3.451.csi.miamioh.edu/cse451-hayesbm3-web/finalprojecttest/public/index.php');
                exit;
        }
}
?>


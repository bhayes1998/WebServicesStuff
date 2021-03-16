<?php

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

class TodoController extends Controller
{
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
		
		$APIKEY = env('TODOIST_API_KEY');
		if ($APIKEY == "") {
                        die ("API KEY NOT DEFINED");
                }


		$headers = [ 'Authorization' => 'Bearer ' . $APIKEY];

                $client = new Client([
			'base_uri' => 'https://api.todoist.com/rest/v1/',
			'headers' => $headers,
                ]);

		
                $response = $client->request('GET','tasks',
                        ['query' => [
                                'project_id' => '2260869388'
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
}

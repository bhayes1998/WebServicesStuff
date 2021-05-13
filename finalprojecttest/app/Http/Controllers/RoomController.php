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

class RoomController extends Controller
{
    /**
     * Show a list of all of the Rooms
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roomCollection = DB::select('select * from room');

        return view('room', ['roomCollection' => $roomCollection]);
    }

    public function add()
    {
	    return view('add');
    }


    public function addRoom(Request $request)
    {
	    $validator = Validator::make($request->all(), [
		'buildingName' => 'required',
		'roomNum' => 'required|numeric',
		'capacity' => 'required|numeric',
		'description' => 'required',
		'dept' => 'required'
	]);

	if ($validator->fails()){
		return redirect('/room/add')->with(['message' => 'Please provide building, room number, numeric capacity, description, and department'])->withInput($request->all());
	}
	
	$buildingName = htmlspecialchars($request->buildingName);
	$roomNum = htmlspecialchars($request->roomNum);
	$capacity = htmlspecialchars($request->capacity);
	$description = htmlspecialchars($request->description);
	$dept = htmlspecialchars($request->dept);
	$image = $this->getImage($buildingName);

	DB::insert('insert into room (dept, capacity, description, roomNum, buildingName, image) values (?, ?, ?, ?, ?, ?)', [$dept, $capacity, $description, $roomNum, $buildingName, $image]);

        return redirect('/room')->with(['message' => 'Room added!']);
    }

    private function getImage($building) {
        $client = new Client([
            'base_uri'=> 'http://ws.miamioh.edu/api/building/v1/',
            'timeout'=>2.0
	]);
	try {    
        	$response = $client->request('GET',$building);
		$json = json_decode($response->getBody(),true);
		return $json['data']['imageURL'];
	}
	catch (ClientException $e) {
		return '';
	}
     	catch (RequestException $e) {
		return '';
	}	
	    
    }

   
}

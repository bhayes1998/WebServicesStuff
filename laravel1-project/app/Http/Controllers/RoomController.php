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
		'roomName' => 'required',
		'capacity' => 'required|numeric',
		'description' => 'required',
		'dept' => 'required'
	]);

	if ($validator->fails()){
		return redirect('/room/add')->with(['message' => 'Please provide name, numeric capacity, description, and department'])->withInput($request->all());
	}

	$roomName = htmlspecialchars($request->roomName);
	$capacity = htmlspecialchars($request->capacity);
	$description = htmlspecialchars($request->description);
	$dept = htmlspecialchars($request->dept);

	DB::insert('insert into room (dept, capacity, description, roomName) values (?, ?, ?, ?)', [$dept, $capacity, $description, $roomName]);

        return redirect('/room')->with(['message' => 'Room added!']);
    }   
}

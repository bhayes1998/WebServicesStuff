<?php
/*
 * Scott Campbell
 * RoomController -> handle room requests
 * */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
}

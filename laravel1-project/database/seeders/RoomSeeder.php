<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoomSeeder extends Seeder
{
	/**
	 * Run the database seeders.
	 *
	 * @return void
	 */
	public function run()
	{

		DB::table('room') -> insert([
			'roomName' => "Ben001" ,
			'capacity' => 4,
			'dept' => 'cse',
			'description' => "148 Computer Lab"
		]);
		DB::table('room') -> insert([
			'roomName' => "Ben024" ,
			'capacity' => 4 ,
			'dept' => 'cse',
			'description' => '148 Computer Lab'

		]);
		DB::table('room') -> insert([
			'roomName' => "Gar052" ,
			'capacity' => 4,
			'dept' => 'MME',
			'description' => 'High Bay Workshop'
		]);
		DB::table('room') -> insert([
			'roomName' => "Gar144" ,
			'capacity' => 4,
			'dept' => 'ECE',
			'description' => 'Circuits lab'	
		]);
		DB::table('room') -> insert([
			'roomName' => "Ben016" ,
			'capacity' => 4,
			'dept' => 'cec',
			'description' => 'General Computer Lab'	
		]);







	}
}

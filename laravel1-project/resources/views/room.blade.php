<x-main-layout>
<x-slot name="title">
  Room List
</x-slot>
<x-slot name="SCRIPT">temp.js</x-slot>
<div class='text-center' style='margin-bottom: 20px;'>
<div id='display'>
	<p style='display: inline'>The temperature in </p>
	<p id='city' style='display: inline'></p>
	<p style='display: inline'> right now is </p>
	<p id='temp' style='display: inline'></p>
	<p id='cache'></p>	
</div>
<div id='zipcodeinput'>
Zipcode: <input type='text' id='zipcode' value='45056'></input</div>
@if (session()->has('message'))
    	<div class="alert alert-success">
            {{ session('message') }}
	</div>
@endif
<table class='table'>
<tr><td>Building</td><td>Roon Number</td><td>Capacity</td><td>Description</td><td>Department</td><td>Image</td></tr>
@foreach ($roomCollection as $room)
<tr>
<td>{{$room->buildingName}}</td>
<td>{{$room->roomNum}}</td>
<td>{{$room->capacity}}</td>
<td>{{$room->description}}</td>
<td>{{$room->dept}}</td>
@if ($room->image == '')
	<td>&nbsp</td>
@else
	<td><a href='{{$room->image}}'>Image</a></td>
@endif
</tr>
@endforeach
</table>
</x-main-layout>

<x-main-layout>
<x-slot name="title">
  Room List
</x-slot>
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

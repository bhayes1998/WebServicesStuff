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
<tr><td>Name</td><td>Capacity</td><td>Description</td><td>Department</td></tr>
@foreach ($roomCollection as $room)
<tr><td>{{$room->roomName}}</td>
<td>{{$room->capacity}}</td>
<td>{{$room->description}}</td>
<td>{{$room->dept}}</td>
</tr>
@endforeach
</table>
</x-main-layout>

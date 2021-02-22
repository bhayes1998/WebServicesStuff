<x-main-layout>
<x-slot name="title">
  Room List
</x-slot>

<table class='table'>
<tr><td>Name</td><td>Capacity</td></tr>
@foreach ($roomCollection as $room)
<tr><td>{{$room->roomName}}</td>
<td>{{$room->capacity}}</td>
</tr>
@endforeach
</table>
</x-main-layout>

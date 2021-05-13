<x-main-layout>
<x-slot name="pageTitle">
Travel List
</x-slot>
<x-slot name="SCRIPT">travel.js</x-slot>
<div class="content" style="display: flex; flex-direction: column; align-items: center;">
	<div id="projects" class="list-group" style="text-align: center; width: 50%; position: relative">
	</div>

	@if (session()->has('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
@endif
<form method="post" action="{{url('/travel/add')}}" style="width: 75%; display: flex; flex-direction: column;">
  @csrf
  <div class="form-group">
    <label>Add new city:</label>
    <input type="text" class="form-control" name="cityName" value="" placeholder="City Name">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

	<a href="travel/logout">Logout</a> 


</x-main-layout>



<x-main-layout>
@if (session()->has('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
@endif
<form method="post" action="{{url('/room/add')}}">
  @csrf
  <div class="form-group">
    <label>Building</label>
    <input type="text" class="form-control" name="buildingName" value="{{ old('buildingName') }}" placeholder="Enter the building name">
  </div>
  <div class="form-group">
    <label>Room Number</label>
    <input type="text" class="form-control" name="roomNum" value="{{ old('roomNum') }}" placeholder="Enter number of the room">
  </div>
  <div class="form-group">
    <label>Capactiy</label>
    <input type="text" class="form-control" name="capacity" value="{{ old('capacity') }}" placeholder="Enter capacity of the room">
  </div>
  <div class="form-group">
    <label>Description</label>
    <input type="text" class="form-control" name="description" value="{{ old('description') }}" placeholder="Enter the description of the room">
  </div>
  <div class="form-group">
    <label>Department</label>
    <input type="text" class="form-control" name="dept" value="{{ old('dept') }}" placeholder="Enter the department">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

</x-main-layout>

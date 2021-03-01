<x-main-layout>
@if (session()->has('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
@endif
<form method="post" action="{{url('/room/add')}}">
  @csrf
  <div class="form-group">
    <label>Name</label>
    <input type="text" class="form-control" name="roomName" value="{{ old('roomName') }}" placeholder="Enter name of the room">
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

<x-main-layout>
<h2 class='text-center'>S3 Bucket</h2>

<x-slot name="SCRIPT">s3.js</x-slot>
<div id='msg'></div>
<form method="put">
  @csrf
  <div class="form-group">
    <label>Information</label>
    <input type="text" class="form-control" name="information" id="information">
  </div>
<button type="submit" id="send" class="btn btn-primary">Submit</button>
</form>

</x-main-layout>

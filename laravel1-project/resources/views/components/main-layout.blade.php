<!doctype html>
<!-- scott campbell-->
<!-- based off of https://getbootstrap.com/docs/4.0/examples/starter-template/-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{$title ?? 'Room Reservations'}}</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 

<style>
.starter-template {
  padding: 3rem 1.5rem;
  text-align: center;
}
</style>
  </head>

  <body>

    <main role="main" class="container">

      <div class="starter-template">
	<h1>{{$pageTitle ?? 'Room Reservations'}}</h1>
      </div>
      <div>
	@isset($SCRIPT)

		<script src="{{env('APP_URL')}}/{{$SCRIPT}}"></script>

	@endisset
      </div>
     <div class='content'>
{{$slot}}
</div>

    </main><!-- /.container -->
<footer class='text-center'>
<hr>
<a class='btn btn-info' href='./'>Home</a>
<a class='btn btn-info' href='{{ env('APP_URL')}}/index.php/about'>about</a>
<a class='btn btn-info' href='{{ env('APP_URL')}}/index.php/room'>Room Listing</a>
<a class='btn btn-info' href='{{ env('APP_URL')}}/index.php/room/add'>Add Room</a>
<a class='btn btn-info' href='{{ env('APP_URL')}}/index.php/todo'>Todoist</a>
<a class='btn btn-info' href='{{ env('APP_URL')}}/index.php/todoistoauth'>Todoist OAuth</a>
<a class='btn btn-info' href='{{ env('APP_URL')}}/index.php/s3'>S3 Edit</a>

</footer>

      </body>
</html>



<!doctype html>
<!-- scott campbell-->
<!-- based off of https://getbootstrap.com/docs/4.0/examples/starter-template/-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{$title ?? 'City & Travel'}}</title>

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
	<div class="container">
        <div class="row">
		<div class="col-xs-6" style="margin-left: auto">
                        <img src='{{ asset('/miami.jpg')}}' alt="Miami OH Logo" width="120" height="120">
                </div>
                <div class="col-xs-6 d-flex justify-content-center" style="margin-right: auto">
                      <h2 style="margin: auto">Final Project</h2>
                </div>
        </div>
      </div>	
<div class="container">
		<header class="text-center">
				<a class='btn btn-info' href='{{ env('APP_URL')}}/index.php'>Home</a>
				<a class='btn btn-info' href='{{ env('APP_URL')}}/index.php/travel'>Travel List</a>
				<a class='btn btn-info' href='http://cse451-finalproject-hayesbm3.s3-website-us-east-1.amazonaws.com/'>S3 Map</a>
  		</header>
	</div>

	<h1>{{$pageTitle ?? 'City & Travel'}}</h1>
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
<h2>Bryan Hayes</h2>
</footer>

      </body>
</html>



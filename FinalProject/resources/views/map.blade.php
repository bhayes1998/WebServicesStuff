	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<title>Hello, world!</title>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
				       integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
				       crossorigin=""/>
		<!-- Make sure you put this AFTER Leaflet's CSS -->
		<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
			integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
			crossorigin=""></script>
		<script
			src="https://code.jquery.com/jquery-3.6.0.min.js"
			integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			crossorigin="anonymous"></script>
		<style>
html,body {
	height: 100%;
}
#mapid {height: 40%;}
		</style>
	</head>
	<body>
	<x-main-layout>
	<x-slot name="pageTitle">
	Map
	</x-slot>
	<x-slot name="SCRIPT">map.js</x-slot>
		<script>
			city="{{$city}}";
		</script>	
		<div id="mapid" style="text-align: center; border: black; border-style: solid;">
			<h1 style="  	padding-top: 100px;
  					padding-right: 30px;
  					padding-bottom: 50px;
					padding-left: 80px;"></h1>
		</div>
		
		<h1 class="text-center">City Info</h1>

		<div class="text-center" id='info'></div>

		<div id='wiki' class="text-center"></div>

			
		<h1 class="text-center">Previous Visits</h1>
		<ul id="users" class="text-center">
		</ul>
		
		<h1 class="text-center">Add a new visit to a city</h1>
		<form class="needs-validation" novalidate>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom01">First name</label>
      <input type="text" class="form-control" id="firstname" placeholder="First name" value=""
        required>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationCustom02">Last name</label>
      <input type="text" class="form-control" id="lastname" placeholder="Last name" value=""
        required>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-6 mb-3">
      <label for="validationCustom03">City</label>
      <input type="text" class="form-control" id="city" placeholder="City" required>
      <div class="invalid-feedback">
        Please provide a valid city.
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationCustom04">State</label>
      <input type="text" class="form-control" id="state" placeholder="State" required>
      <div class="invalid-feedback">
        Please provide a valid state.
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationCustom05">Zip</label>
      <input type="text" class="form-control" id="zip" placeholder="Zip" required>
      <div class="invalid-feedback">
        Please provide a valid zip.
      </div>
    </div>
  </div>
  <div class="form-group">
	  <label for="validationCustom06">Country</label>
      <input type="text" class="form-control" id="country" placeholder="Country">

	  <label for="validationCustom07">Comments</label>
      <input type="text" class="form-control" id="comments" placeholder="Comments">

    <div class="form-check">

      <input class="form-check-input" type="checkbox" id="liked">
      <label class="form-check-label" for="invalidCheck">
        Liked
      </label>
      <div class="invalid-feedback">
        You must fill everything out before submitting.
      </div>
    </div>
  </div>
  <button class="btn btn-primary btn-sm" type="submit">Submit form</button>
</form>	
<script>
	APPID = "{{ env('APPID') }}";
</script>

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</x-main-layout>
	</body>

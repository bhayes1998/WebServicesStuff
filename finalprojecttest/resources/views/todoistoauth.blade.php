<x-main-layout>
<x-slot name="pageTitle">
Todoist OAuth
</x-slot>
<x-slot name="SCRIPT">oauth.js</x-slot>
<div class="content">
	<div class="d-flex flex-wrap justify-content-center">
		@if (count($projectList) == 0)
			No projects to show 
		@else 
			@for ($i = 0; $i < count($projectList); $i++)
                        	<div class="project-buttons p-2 w-20 btn btn-secondary" style="margin: 10px" href="{{$projectList[$i]}}">{{$nameList[$i]}}</div>
			@endfor
		@endif
	
	</div>
	<div id="projects" class="text-center"></div>
	<a href="todoistoauth/logout">Logout</a> 
	<script>
		token="{{$token}}";
	</script>
</div>

</x-main-layout>


<x-main-layout>
<x-slot name="pageTitle">
Todoist
</x-slot
<x-slot name="SCRIPT">todo.js</x-slot>
<div>
	<p id="status"></p>
</div>
<div>
	<ul id="projects" class="text-center">
	</ul>
<script>
	 $(document).ready(function () {
                $.ajax({
		    "url": "api/todo/"})
                .done(function (response) {
			for (i=0,l=response.content.length;i<l;i++) {
				$("#projects").append("<li>" + response.content[i] + "</li>");
			}
		})
		.fail(function(error) {
			console.log(error);
			$('#status').text('Error retrieving data');
                });

	});
</script>
</x-main-layout>


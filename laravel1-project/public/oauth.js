$(document).ready(()=>{
	console.log('ready');
	$(".project-buttons").click(showTasks);
});

function showTasks(event) {
	id=$(this).attr('href');
	console.log("tasks",id);
	$.ajax( {
		url: 'api/todo/'+token + "/" +id,
		success: (data) => {
			$("#projects").html("");
			console.log("projects",data);
			if (data["status"] == "FAIL")
				$("#projects").append("No tasks");
			else
			for (i=0,l=data.content.length;i<l;i++) {
				$("#projects").append("<li>" + data.content[i] + "</li>");
			}
		},
		error: (error) => {
			console.log("Fail",error);
			$("#msg").html("Error retrieving");
		}
	});


	}

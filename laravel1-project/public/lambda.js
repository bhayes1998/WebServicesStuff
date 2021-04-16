url = 'https://9go5uw0jm6.execute-api.us-east-1.amazonaws.com/default/chart';

$(document).ready(()=>{
	console.log('ready');
	$("#query").click(update);
	$(".like").click(thumbs);
});

function update(event) {
	console.log("update");
	date = $("#date").val();
	$.ajax( {
		url: url+"/"+date,
		method: 'GET',
		crossDomain: true,
		success: (data) => {
			console.log("load Content",data);
			$("#chart-data").html("");
			data.Items.forEach((i)=> {
				let s="<tr><td>"+i.date+"</td>";
				s += "<td>"+i.rank+"</td>";
				s += "<td>"+i.info.song+"</td>";
				let t = 0;
				if (i.info.thumbsUp != undefined)
					t=i.info.thumbsUp;
				s += "<td><span date='"+i.date + "' rank='" + i.rank + "' class='like btn btn-info'>"+t+"</span></td>";
				s += "</tr>";
				$("#chart-data").append(s);
			});

	$(".like").click(thumbs);
		},
		error: (error) => {
			console.log("Fail",error);
			$("#msg").html("Error retrieving");
		}
	});

}

function thumbs(event) {
	date = ($(this).attr('date'))
	rank=($(this).attr('rank'))
	console.log("thumbs",date,rank);
	$.ajax( {
		url: url,
		method:"POST",
		dataType:'json',
		contentType: "application/json",
		data: JSON.stringify({"date":date,"rank":Number(rank)}),
		success: (data) => {
			console.log("load Content",data);
			update();
		},
		error: (error) => {
			console.log("Fail",error);
			$("#msg").html("Error retrieving");
		}
	});


	}

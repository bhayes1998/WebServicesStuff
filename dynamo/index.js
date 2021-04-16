
/*
Scott Campbell
Example s3 get listing
*/

const AWS = require('aws-sdk');


AWS.config.update({
region: "us-east-1",
});


var docClient = new AWS.DynamoDB.DocumentClient();


exports.handler = async(event, context) => {
	//console.log('Received event:', JSON.stringify(event, null, 2));

	let body;
	let statusCode = '200';
	const headers = {
        "Content-Type" : "application/json",
     "Access-Control-Allow-Headers" : "Content-Type",
            "Access-Control-Allow-Origin": "*",
            "Access-Control-Allow-Methods": "OPTIONS,POST,GET"
    };
	try {
		let parts = event.path.split("/");
		switch (event.httpMethod) {
			case 'GET':
				if (parts.length > 2) {
				    var params = {
				        TableName : "Chart",
				        FilterExpression: "begins_with(#date,:d)",
				        // FilterExpression: "#date=:d",
				        ExpressionAttributeNames:{
				            "#date":"date"},
				            ExpressionAttributeValues: {
				                ":d": parts[2] 
				            }
				    
				    };
				    var results = await docClient.scan(params).promise();
				    //Do Pagination, iterate until we get all records
				    while(results.LastEvaluatedKey != undefined) {
				        //console.log("more",results.LastEvaluatedKey);
				        params.ExclusiveStartKey = results.LastEvaluatedKey;
				        results1 = await docClient.scan(params).promise();
				        results1.Items.forEach((i)=> {
				            results.Items.push(i);
				            
				        })
				        results.Count += results1.Count;
				        results.ScannedCount += results1.ScannedCount;
				        //see if there are more records to scan
				        if (results1.LastEvaluatedKey == "undefined")
				            results.LastEvaluatedKey=undefined
				        else
				            results.LastEvaluatedKey=results1.LastEvaluatedKey;
				            
				        //console.log("more",results.LastEvaluatedKey);
				    }
				        
				    //return results;
				    
				    var songs = new Array();
					results.Items.forEach((i) => {
							songs.push(i);
					});
					
					//params.Key = parts[2];
					//var lo = await s3.getObject(params).promise();
					if (songs)
						body = { "status": "ok", "Items": songs }
					else
						body = {"status":"Fail","msg":"failed :("}

				}
				else {
					body = {"status":"fail "}

				}
				break;
			case 'POST':
				var data = JSON.parse(event.body);
				var date = data.date;
				var rank = parseInt(data.rank);

				var params = {
				TableName:"Chart",
					  Key:{
						  "date": date,
						  "rank": rank
					  },
				          UpdateExpression: "add info.thumbsUp :p",
					  ExpressionAttributeValues:{
							  ":p":1
						  },
				          ReturnValues:"NONE"
				};
				console.log("Updating the item...");
				await docClient.update(params).promise();
				body = { "status" : "ok" };
				break;
			default:
				throw new Error(`A Unsupported method "${event.httpMethod}"`);
		}
	}
	catch (err) {
		console.log("Error");
		statusCode = '400';
		body = { "error": err.message };
	}
	finally {

		body = JSON.stringify(body);
		return {
			statusCode,
			body,
			headers,
		};

	}


};

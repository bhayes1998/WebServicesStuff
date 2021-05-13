async function getTodoist() {
	let myPromise = new Promise(function(resolve, reject) {
                var https = require('follow-redirects').https;
                var fs = require('fs');

                var options = {
                        'method': 'GET',
                        'hostname': 'api.todoist.com',
                        'path': '/rest/v1/tasks?project_id=2265255138',
                        'headers': {
                                'Authorization': 'Bearer 431b8fbf522bf696c44f329cc2a59109cce959ac'
                        },
                        'maxRedirects': 20
                };

                var req = https.request(options, function (res) {
                        var chunks = [];

                        res.on("data", function (chunk) {
                                chunks.push(chunk);
                        });

                        res.on("end", function (chunk) {
                                var body = Buffer.concat(chunks);
                                var t = JSON.parse(body.toString());
                                resolve(t);
                        });

                        res.on("error", function (error) {
                                reject(error);
                        });
                });

                req.end();
        });

        return myPromise.then(
          function(value) {console.log(value);
                return value;},
          function(error) {return error;}
        );

}

async function getCities() {
	let todoist = await getTodoist();

          let myCityPromise = new Promise(function(resolve, reject) {
                var https = require('follow-redirects').https;
                var fs = require('fs');

                var options = {
                        'method': 'GET',
                        'hostname': 'campbest.451.csi.miamioh.edu',
                        'path': '/globalCityList/public/api/v1/city',
                        'maxRedirects': 20
                };

                var req = https.request(options, function (res) {
                        var chunks = [];

                        res.on("data", function (chunk) {
                                chunks.push(chunk);
                        });

                        res.on("end", function (chunk) {
                                var body = Buffer.concat(chunks);
                                var t = JSON.parse(body.toString());
                                resolve(t);
                        });

                        res.on("error", function (error) {
                                reject(error);
                        });
                });

                req.end();
        });

        return myCityPromise.then(
          function(value) {console.log(value); return value['models'];},
          function(error) {return error;}
        );

}

exports.handler = async (event) => {
        
	let todoist = await getTodoist();	

	let cities = await getCities();
	let latlon = [];
			console.log(todoist.length + ", " + cities);
	for (i = 0; i < todoist.length; i++) {
		for (j = 0; j < cities.length; j++) {
			if (cities[j]['CityName'] == todoist[i]['content']) {
				latlon.push({'city' : cities[j]['CityName'], 'lat' : cities[j]['LAT'], 'lon' : cities[j]['LON']});
			}
		}
	}

	const response = {
                         statusCode: 200,
                        headers: {
                                "Access-Control-Allow-Headers" : "Content-Type",
                                "Access-Control-Allow-Origin": "*",
                                "Access-Control-Allow-Methods": "OPTIONS,POST,GET"
                        },
                        body: JSON.stringify(latlon),
        };
        return response;


};




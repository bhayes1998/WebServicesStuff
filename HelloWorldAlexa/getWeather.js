/*
 * Scott Campbell
 * cse451
 * Function/module to use openweathermap to get weather
 * Uses promises to allow caller to use async/await
 *
 * Requires follow-redirects module
 */

function getTemp() {
	return new Promise((resolv,reject)=> {
		var https = require('follow-redirects').https;
		var fs = require('fs');


		let API_KEY='b3ea9041c7b81868083b7016b2558f93';

		var options = {
			'method': 'GET',
			'hostname': 'api.openweathermap.org',
			'path': '/data/2.5/onecall?lat=39.507&lon=-84.7452&exclude=hourly,daily&appid=' + API_KEY + '&units=imperial',
			'headers': {
				'Content-Type': 'application/json'
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
				resolv(t.current.temp);
			});

			res.on("error", function (error) {
				reject("error");
			});
		});

		req.end();
	});
}

function getHomeTemp() {
        return new Promise((resolv,reject)=> {
                var https = require('follow-redirects').https;
                var fs = require('fs');


                let API_KEY='b3ea9041c7b81868083b7016b2558f93';

                var options = {
                        'method': 'GET',
                        'hostname': 'api.openweathermap.org',
                        'path': '/data/2.5/onecall?lat=39.3995&lon=-84.5613&exclude=hourly,daily&appid=' + API_KEY + '&units=imperial',
                        'headers': {
                                'Content-Type': 'application/json'
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
                                resolv(t.current.temp);
                        });

                        res.on("error", function (error) {
                                reject("error");
                        });
                });

                req.end();
        });
}


exports.getTemp= getTemp;
exports.getHomeTemp = getHomeTemp;

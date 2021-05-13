/*
 * Scott Campbell
 * cse451
 * Function/module to use openweathermap to get weather
 * Uses promises to allow caller to use async/await
 *
 * Requires follow-redirects module
 */

function getCoords(city) {
        return new Promise((resolv,reject)=> {
                var https = require('follow-redirects').https;
                var fs = require('fs');


                let API_KEY='b3ea9041c7b81868083b7016b2558f93';

                var options = {
                        'method': 'GET',
                        'hostname': 'campbest.451.csi.miamioh.edu',
			'path': '/globalCityList/public/api/v1/city/' + city,
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
				if (t['cities'].length == 0)
					resolv('city not found');
				else 
                                	resolv(getTemp(t));
                        });

                        res.on("error", function (error) {
				reject("city not found");
                        });
                });

                req.end();


        });
}

function getTemp(t) {
        return new Promise((resolv,reject)=> {
                var https = require('follow-redirects').https;
                var fs = require('fs');


                let API_KEY='b3ea9041c7b81868083b7016b2558f93';
                var options = {
                        'method': 'GET',
                        'hostname': 'api.openweathermap.org',
                        'path': '/data/2.5/onecall?lat=' + t['cities'][0]['LAT'] + '&lon=' + t['cities'][0]['LON'] + '&exclude=hourly,daily&appid=' + API_KEY + '&units=imperial',
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
                                reject("temp not founc");
                        });
                });

                req.end();
        });
}


exports.getTemp= getTemp;
exports.getCoords = getCoords;

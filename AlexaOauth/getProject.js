function getProjects(accessToken) {

 return new Promise((resolv,reject)=> {
                var https = require('follow-redirects').https;
                var fs = require('fs');

                var options = {
                        'method': 'GET',
                        'hostname': 'api.todoist.com',
                        'path': '/rest/v1/projects',
                        'headers': {
                                'Content-Type': 'application/json',
                                'Authorization': 'Bearer ' + accessToken
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
				try {
                                var t = JSON.parse(body.toString());
				var id = '';
				for (let i = 0; i < t.length; i++) {

					if (t[i].name.toLowerCase() == 'class') {
						id = t[i].id;
					}
				}
				
                                resolv(getTasks(id, accessToken));
				} catch (err) {
					resolv('');
				}
                        });

                        res.on("error", function (error) {
                                reject("error");
                        });
                });

                req.end();
        });	
}

function getTasks(id, accessToken) {
	return new Promise((resolv,reject)=> {
                var https = require('follow-redirects').https;
                var fs = require('fs');

		if (id == '') {
			resolv('');
		} else {
		
                var options = {
                        'method': 'GET',
                        'hostname': 'api.todoist.com',
                        'path': '/rest/v1/tasks?project_id=' + id,
                        'headers': {
                                'Content-Type': 'application/json',
                                'Authorization': 'Bearer ' + accessToken
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
				try {
                                var t = JSON.parse(body.toString());

                                resolv(t);
				} catch (err) {
					resolv('');
				}
                        });

                        res.on("error", function (error) {
                                reject("error");
                        });
                });

                req.end();
		}
        });
}

exports.getTasks = getTasks;
exports.getProjects = getProjects;

var http = require('http');
var url = require('url');
var querystring = require('querystring');
var sys = require('sys')
var exec = require('child_process').exec;

var server = http.createServer(function(req, res) {
	var params = querystring.parse(url.parse(req.url).query);
	var page = url.parse(req.url).pathname;
	if(req.method === 'GET' && page === '/simulate'){
		res.writeHead(200, {"Content-Type": "application/json"});
		exec("echo test", function(err, stdout, stderr){
			res.end(stdout);
		});
		// exec simulation
		// listen to modification in a directory
		// send result
		
	}else{
		res.writeHead(404);
		res.end('404');
	}
});

server.listen(9090, function(){
	console.log('HTTP Server listen on 9090');
});
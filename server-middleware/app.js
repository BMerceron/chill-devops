var io = require('socket.io');
var http = require('http');

var httpclient = http.Server();
var ioclient = io(httpclient);

var httpvm = http.Server();
var iovm = io(httpvm);

ioclient.on('connection', function(socket){
	console.log("New client")
 	socket.on('simulate', function(){
 		// Envoyer un socket vers les VMs pour lancer les simulations
 	});
});

iovm.on('connection', function(socket){
	console.log("New VM");
 	socket.on('simulation_responses', function(){
 		// Envoyer un socket vers le client contenant les réponses des simulations
 	});
});

httpclient.listen(9080, function(){
	console.log('IO Client is listening to port 9080');
});

httpvm.listen(9090, function(){
	console.log('IO VM is listening to port 9090');
});
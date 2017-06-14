var io = require('socket.io-client')('http://127.0.0.1:9090');

io.on('connect', function(){
	console.log('Connected to middleware')
	// Ecouter le socket simulate
	// Faire la simulation
	// Envoyer le socket simulation_response
});
var vms = [];
var queue = [];
var results = [];
var isSimulating = false;
var simulatingSince = new Date();
var forWhoSimulating;

var httpclient = require('http').Server();
var httpvm = require('http').Server();
var ioclient = require('socket.io')(httpclient);
var iovm = require('socket.io')(httpvm);

ioclient.on('connection', function(socket){

	console.log("New client: "+socket.id);

 	socket.on('simulate', function(){

 		console.log('Client '+socket.id+' want to simulate');

 		queue.push(socket);
 	});

 	socket.on('waiting', function(){
 		console.log("Client "+socket.id+" want to get waiting time");
 		var timeTaken = 0;
 		vms.forEach(function(vm){
 			console.log("VM "+vm.id+" has waiting : "+vm.waiting);
 			if(vm.waiting > timeTaken)
 				timeTaken = vm.waiting;
		});

 		var elapsed = ((new Date().getTime() - simulatingSince.getTime()) / 1000);
 		if(elapsed < 0)
 			elapsed = 0;
 		var waiting = (timeTaken - elapsed) + (queue.length * timeTaken);

		console.log('Emmiting waiting time ('+waiting+') to client '+socket.id);
 		socket.emit('waiting', waiting);
	});

});

iovm.on('connection', function(socket){

	console.log("New VM: "+socket.id);

	vms.push(socket);

	socket.on('response', function(data){
		console.log("get response from VM "+socket.id);
		results.push(data);
	});

	socket.on('waiting', function(data){
		socket.waiting = data;
	});

	socket.on('disconnect', function(){
		vms = vms.filter(function(vm){
			return vm.id !== socket.id; 
		});
	});

	if(isSimulating){
		socket.emit('simulate');
	}

});

httpclient.listen(9090, function(){
	console.log('IO client listening to port 9090');
});

httpvm.listen(9080, function(){
	console.log('IO VM listening to port 9080');
});

setInterval(function(){

	// Waiting management

	vms.forEach(function(vm){
		vm.emit('waiting');
	});

	// Event management

	console.log(queue.length, 'Events in queue');

	if(vms.length === results.length && isSimulating){
		console.log("All results received for "+forWhoSimulating.id+", sending response to client");
		forWhoSimulating.emit('response', results);
		results = [];
		forWhoSimulating = null;
		isSimulating = false;
	}else if(isSimulating){
		return
	}

	if(queue.length === 0){
		return;
	}

	var elem = queue.shift();
	vms.forEach(function(vm){
 		vm.emit('simulate', elem.id);
 	});

	simulatingSince = new Date();
	forWhoSimulating = elem;
 	isSimulating = true;

}, 1000);




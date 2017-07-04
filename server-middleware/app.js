var vms = [];
var queue = [];
var results = [];
var isSimulating = false;
var forWhoSimulating;
var waiting = [];

var httpclient = require('http').Server();
var httpvm = require('http').Server();
var ioclient = require('socket.io')(httpclient);
var iovm = require('socket.io')(httpvm);

ioclient.on('connection', function(socket){

	console.log("New client: "+socket.id);

	setInterval(function(){
		if(waiting[socket.id]) {
            if (vms.length === waiting[socket.id].length) {
                socket.emit('waiting', waiting[socket.id]);
                waiting[socket.id] = [];
            }

            if (waiting[socket.id].length !== 0) {
                return;
            }

            vms.forEach(function (vm) {
                vm.emit('waiting', socket.id);
            });
        }

	}, 300);

 	socket.on('simulate', function(){

 		console.log('Client '+socket.id+' want to simulate');

 		queue.push(socket);
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
		if(!waiting[data.client])
			waiting[data.client] = [];
		waiting[data.client].push(data.waiting);
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

	forWhoSimulating = elem;
 	isSimulating = true;

}, 1000);




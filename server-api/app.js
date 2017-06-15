var socket = require('socket.io-client')('http://127.0.0.1:9080');
//var sys = require('sys');
//var exec = require('child_process').exec;

socket.on('simulate', function(id){

	var time = (Math.floor(Math.random() * 10) + 1) * 1000;
	console.log(time);

	setTimeout(function(){
		socket.emit('response', {
			config: {
				ram: "3 GO"
			},
			maxClient: 12954
		});
	}, time);

});




//exec('echo "'+id+'" | /chill_project/scripts/launch_project.sh', function puts(error, stdout, stderr) {
	
//});

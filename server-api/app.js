var socket = require('socket.io-client')('http://192.170.1.14:9080');
var fs = require('fs');
var parser = require('xml2json');
var sys = require('sys');
var exec = require('child_process').exec;

socket.on('simulate', function(id){

	var name = 'Test server';

	exec('echo "'+id+'" | /chill_project/scripts/launch_project.sh', function puts(error, stdout, stderr) {
		console.log("stdout", stdout)
		/*fs.readFile('/var/lib/phoronix-test-suite/test-results/'+id+'/composite.xml', 'utf-8', function(err, data){
			var json = JSON.parse(parser.toJson(data));
			var hardware = json.PhoronixTestSuite.System.Hardware;
			var re = /Hz \((.+)\), Motherboard/g;
			var core = re.exec(hardware)[1];
			re = /Memory: ([\d]) x (.+) MB DRAM/g;
			var ram = re.exec(hardware)[1] * re.exec(hardware)[2];
			re = /Disk: ([\d]+)GB/g;
			var disk = re.exec(hardware)[1];

			var result = {
				capacity: json.PhoronixTestSuite.Result.Data.Entry.Value,
				config: {
					name: name,
					core: core,
					ram: ram,
					disk: disk 
				}
				
			}
			
			socket.emit('response', result);

		});*/
	});

});



/*{
	capacity: int,
	config: {
		name: string,
		core: int(nb,
		ram: int(Go),
		disk: int(go)
	}
}*/
var socket = require('socket.io-client')('http://192.170.1.14:9080');
var fs = require('fs');
var parser = require('xml2json');
var sys = require('sys');
var exec = require('child_process').exec;

socket.on('simulate', function(id){

	var name = 'Test server';
	var id = 'j1ge4gjvnmjqticeaaao';
	var idpath = id.replace('_', '').replace('-', '').toLowerCase();

	//exec('echo "'+id+'" | /chill_project/scripts/launch_test.sh', function(error, stdout, stderr) {
		fs.readFile('/var/lib/phoronix-test-suite/test-results/'+idpath+'/composite.xml', 'utf-8', function(err, data){
			if(err)
				console.log(err);

			var json = JSON.parse(parser.toJson(data));
			var hardware = json.PhoronixTestSuite.System.Hardware;
			console.log(hardware)
			var re = /Hz \((\d+) Core[s]?\), Motherboard/g;
			console.log(re.exec(hardware));
			var core = re.exec(hardware)[1];
			re = /Memory: ([\d]) x (.+) MB DRAM/g;
			var ramtemp = re.exec(hardware);
			var ram = ramtemp[1] * ramtemp[2];
			re = /Disk: ([\d]+)GB/g;
			var disk = re.exec(hardware)[1];

			var result = {
				capacity: parseInt(json.PhoronixTestSuite.Result.Data.Entry.Value),
				config: {
					name: name,
					core: core,
					ram: ram,
					disk: disk 
				}
				
			}
			
			socket.emit('response', result);

		});
	//});

});
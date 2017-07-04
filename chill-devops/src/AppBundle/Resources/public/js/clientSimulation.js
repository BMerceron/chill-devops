/**
 * Created by devmercerie on 15/06/17.
 */

var socket = io.connect('http://192.170.1.14:9090');

function onSimulate() {
    socket.emit('simulate', 'simulate');
    XMLHttpRequest.open("GET", "{{ path('app_dashboard_check_available') }}");
}

socket.on('response', function(results) {
    console.log(results);
})
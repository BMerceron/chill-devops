/**
 * Created by devmercerie on 14/06/17.
 */
$(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
});

$('.modal-delete').click(function() {
    var targetUrl = $('.modal-delete').attr("data-target-url");
    $('#removeLink').attr('href', targetUrl);
});

$('.modal-multi-delete').click(function() {
    alert("TEST");
    var targetUrl = $('.modal-multi-delete').attr("data-target-url");
    $('#removeLink').attr('href', targetUrl);
});

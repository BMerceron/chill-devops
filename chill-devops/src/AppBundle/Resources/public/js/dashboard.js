$( document ).ready(function() {
    $('.modal').modal();

    $(".js-submit_scenario").click(function(event){
        event.preventDefault();
        $('.modal').modal('open');

    });

});
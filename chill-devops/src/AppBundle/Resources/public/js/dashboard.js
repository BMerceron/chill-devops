$( document ).ready(function() {
    $('.modal').modal();

    $(".js-submit_scenario").click(function(event){
        event.preventDefault();
        $('.js-confirm_scenario_modal').modal('open');

    });

    $(".js-delete_scenario").click(function(event){
        event.preventDefault();
        $('.js-confirm_delete_scenario').modal('open');

    });

});
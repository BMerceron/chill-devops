$( document ).ready(function() {
    $('.modal').modal();

    $(".js-submit_scenario").click(function(event){
        event.preventDefault();
        $('.js-confirm_scenario_modal').modal('open');

    });
});
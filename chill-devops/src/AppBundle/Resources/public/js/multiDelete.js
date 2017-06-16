$(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
});

var scenarioIdArray = [];

function checkArray(arr, val) {
    if (arr.indexOf(val) === -1){
        arr.push(val);
    }
    else {
        arr.splice(arr.indexOf(val), 1);
    }
}
// $('#68').css('display','none');
$(".psb-js-delete-select").on("click", function() {
    var scenarioId = $(this).attr("data-id");
    checkArray(scenarioIdArray, scenarioId);

})

// click on delete multiple button

$("#multiDeleteButton").on("click", function () {
    $.ajax({
        url: "/scenario/delete/selection",
        data: {tab:scenarioIdArray},
        success: function () {
            location.reload();
        }
    })
});

$('.modal-multi-delete').click(function() {
    var targetUrl = $('.modal-multi-delete').attr("data-target-url");
    $('#removeLink').attr('href', targetUrl);
});
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
    console.log(scenarioIdArray)
    $.ajax({
        url: "/scenario/delete/selection",
        data: {tab:scenarioIdArray},
        success: function () {
            location.reload();
        }
    })
});
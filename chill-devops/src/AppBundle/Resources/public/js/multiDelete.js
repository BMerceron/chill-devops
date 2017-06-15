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

$(".spb-js-edit").on("click", function () {
    var id =$(this).attr('data-id');

    if (document.getElementById('spb-js-input-edit') == null){
        var input = document.createElement("input");
        input.type = 'text';
        input.value = $(this).attr('data-name');
        input.id = 'spb-js-input-edit';

        $(this).after(input);
    } else {
        $('#spb-js-input-edit').remove()
    }

    $('#spb-js-input-edit').keypress(function() {
        if (event.keyCode == 13 ) {
            var data = {
                id: id,
                name: $('#spb-js-input-edit').val()
            };
            $.ajax({
                url: "/scenario/editInput/",
                data: data,
                success: function () {
                    location.reload();
                }
            })
        }
    })
});
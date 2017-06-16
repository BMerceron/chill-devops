/**
 * Created by devmercerie on 16/06/17.
 */

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
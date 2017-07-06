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
                    if($('.spb-js-edit').attr('data-route') == 'show'){
                        console.log($('.spb-js-edit-show').text())
                        $('.spb-js-edit-show').html($('#spb-js-input-edit').val());
                        $('.spb-js-edit').attr('data-name', $('.spb-js-edit-show').text());
                        $('#spb-js-input-edit').remove()
                    }else {
                        location.reload();
                    }

                }
            })
        }
    })
});
/**
 * Created by jonathan on 03/07/17.
 */
$('.k-js-input-search').keyup(function () {
    if ($( this ).val().length < 2) {
        $('.k-js-result-search-scenario li').remove()
    }
    search($( this ))
});
$('.k-js-input-search').on('click', function () {
    search($( this ))
});

function search(element) {
    if (element.val().length > 2) {
        $.ajax({
            url: "/scenario/search",
            data: {'data': element.val()},
            success: function (data) {
                for (var counter = 0; counter < data.length; counter ++){
                    var id = 'li-result-'+data[counter].id;
                    var href = '/scenario/show/'+data[counter].id;
                    if (!document.getElementById(id)) {
                        $('.k-js-result-search-scenario').append('<li id="'+id+'" class="collection-item"><a class="text-white" href='+href+'>'+data[counter].name+'</a></li>');
                    }
                    $( ".collection-item" ).hover(
                        function() {
                            $(this).addClass( "active" );
                            $(this).find('a').css( "color" , "#FFF");

                        }, function() {
                            $(this).removeClass( "active" );
                            $(this).find('a').css( "color" , "#039be5");

                        }
                    );
                }
            }
        })
    }
}
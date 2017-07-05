$("#show-favorites").on('click', function () {
    $('.spb-js-show-favorites').toggle();
    $('.spb-js-show-all').toggle();
    if($(this).text() == 'Favoris'){
        $(this).text('Historique');
    } else {
        $(this).text('Favoris');
    }
})
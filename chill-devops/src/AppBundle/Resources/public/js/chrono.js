/**
 * Created by jonathan on 14/06/17.
 */
var chrono  = {
    initChronoDate: function (){
        var dataDate = $('.psb-js-date');
        var start  = new Date(dataDate.attr('data-start'));
        var end = new Date(dataDate.attr('data-end'));

        return this.dateDiff(end, start);
    },

    dateDiff: function (date1, date2){
        var diff = {};
        var tmp = date2 - date1;

        tmp = Math.floor(tmp/1000);
        diff.sec = tmp % 60;

        tmp = Math.floor((tmp-diff.sec)/60);
        diff.min = tmp % 60;

        tmp = Math.floor((tmp-diff.min)/60);
        diff.hour = tmp % 24;

        tmp = Math.floor((tmp-diff.hour)/24);
        diff.day = tmp;

        return this.displayChrono(diff.hour, diff.min, diff.sec);
    },

    start : function (hour, minutes, secondes) {
        if (secondes == 0) {
            minutes = minutes - 1;
            secondes = 60;
        }
        if (minutes < 0) {
            hour = hour - 1;
        }

        secondes = secondes - 1;

        this.displayChrono (hour, minutes, secondes);
    },

    displayChrono: function (hour, minutes, secondes) {
        if (secondes < 10) {
            secondes = "0" + parseInt(secondes);
        }
        if (minutes < 10) {
            minutes = "0" + parseInt(minutes);
        }

        $('.chrono .psb-js-chrono-hours').html(hour);
        $('.chrono .psb-js-chrono-minutes').html(minutes);
        $('.chrono .psb-js-chrono-secondes').html(secondes);


        var setIntervalChrono = setTimeout(function(){
            chrono.start(hour, minutes, secondes);
        }, 1000);
        if (hour == 0 & minutes == 0 & secondes == 0) {
            clearInterval(setIntervalChrono);
        }

    }
}
chrono.initChronoDate();
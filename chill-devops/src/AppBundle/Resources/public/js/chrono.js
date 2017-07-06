/**
 * Created by jonathan on 14/06/17.
 */
var chrono  = {
    initChronoDate: function (startSecondes){

        if(typeof this.setIntervalChrono !== 'undefined'){
            clearInterval(this.setIntervalChrono);
        }

        var calMinutes = startSecondes/60;
        var minutes = Math.floor(calMinutes);
        var seconds = startSecondes - minutes*60;
        if(minutes >= 60 ) {
            var calHours = minutes/60;
            var hours = Math.floor(calHours);
            minutes = minutes - (60*hours);
        } else {
            hours = 0;
        }
        chrono.displayChrono(hours, minutes, seconds);
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

    displayChrono: function (hour, minutes, seconds) {
        if (seconds < 10) {
            seconds = "0" + parseInt(seconds);
        }
        if (seconds < 2) {
            $('.chrono .psb-js-inner-secondes').text(' seconde ');
        }
        if (minutes < 10) {
            minutes = "0" + parseInt(minutes);
        }
        if (minutes < 2) {
            $('.chrono .psb-js-inner-minutes').html(' minute ');
        }
        if (seconds > 10) {
            $('.chrono .psb-js-inner-secondes').html(' secondes ');
        }
        if (minutes > 10) {
            $('.chrono .psb-js-inner-minutes').html(' minutes ');
        }

        $('.chrono .psb-js-chrono-hours').html(hour);
        $('.chrono .psb-js-chrono-minutes').html(minutes);
        $('.chrono .psb-js-chrono-secondes').html(seconds);


        this.setIntervalChrono = setTimeout(function(){
            chrono.start(hour, minutes, seconds);
        }, 1000);
        if (hour == 0 & minutes == 0 & seconds == 0) {
            clearInterval(this.setIntervalChrono);
        }

    }
};
    //chrono.initChronoDate();

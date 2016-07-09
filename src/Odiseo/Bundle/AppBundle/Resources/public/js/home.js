$(document).ready(function()
{
    var finalDate = $('.contehome').data('finalDate');

    $('.contehome').countdown(finalDate)
        .on('update.countdown', function (event) {
            var offset = event.offset;

            $('.contehome .days').html(offset.totalDays);
            $('.contehome .hours').html(offset.hours < 10?'0'+offset.hours:offset.hours);
            $('.contehome .minutes').html(offset.minutes < 10?'0'+offset.minutes:offset.minutes);
            $('.contehome .seconds').html(offset.seconds < 10?'0'+offset.seconds:offset.seconds);
        })
        .on('finish.countdown', function (event) {
            console.log(event);
        });

  /*  var newYear = new Date(); 
    newYear = new Date(newYear.getFullYear() + 1, 1 - 1, 1); 
    $('#defaultCountdown').countdown({until: newYear}); 
    */
});
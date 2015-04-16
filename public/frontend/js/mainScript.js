

$(document).ready(function () {


    $('.img-wrapper').mouseenter(function () {
        $('.title').fadeIn(500);
    });

    $('.img-wrapper').mouseleave(function () {
        $('.title').fadeOut(500);
    });


    $('.img-wrapper').mouseover(function () {
        $('#grey-smog-box').removeClass('grey-smog');
        $('#grey-smog-box').addClass('not-smog');
    });

    $('.img-wrapper').mouseleave(function () {
        $('#grey-smog-box').removeClass('not-smog');
        $('#grey-smog-box').addClass('grey-smog');
    });

    

});



function sendPostAjax(data, url)
{
    var result;

    $.ajax({
        url: url,
        type: "post",
        data: data,
        success: function (res) {
            result = res;
        },
        error: function (res) {
            result = res;
        }
    });

    return result;
}


function blink(color1, color2, interval, targetid)
{
    var color = [color1, color2];
    var counter = 0;
    window.setInterval(function () {
        if (counter > color.length) {
            counter = 0;
        }
        $(targetid).css('color', color[counter]);
        counter++;
    }, interval);
}





$(document).ready(function () {

    function ModalWindow(settings)
    {
        var css = {
            position: 'absolute',
            width: settings.width,
            'min-height': settings.height,
            top: settings.top,
            left: settings.left,
            background: '#ffffff',
            'z-index': '9999',
            'border-radius': '5px',
            overflow: 'hidden',
            padding: '10px',
            'box-shadow': '0px 0px 0px 8px rgba(0,0,0,0.3)'
        };
        var overlay = '<div class="row" id="overlay"></div>';
        var append = '<div id="modal-window"></div>';
        var row = '<div id="row" class="row" id="content"></div>';
        var col = '<div id="col" class="col-sm-12"></div>';
        var close = '<div class="row"><div class="col-sm-1 col-sm-offset-11" style="text-align:right;">' +
                '<a id="close" class="btn btn-default">X</a>' +
                '</div></div>';

        this.show = function ()
        {
            $('body').prepend(overlay);
            $('body').prepend(append);
            $('#modal-window').css(css);
            $('#modal-window').append(row);
            $('#row').append(col);
            $('#col').append(close);

        };

        this.close = function ()
        {
            $('#modal-window').css('display', 'none');
            $('#overlay').css('display', 'none');
        };

        this.insert = function (html) {
            $('#col').append(html);
        };

    }

    var modal;
    var html = '<div class="row"><div class="col-sm-12" style="text-align:center;"> </div></div>';

    $('#modal-trigger').click(function (e) {
        modal = new ModalWindow({width: '33%', top: '33%', left: '33%', 'min-height': '33%'});
        modal.show();
        modal.insert(html);
        e.preventDefault();
    });

    

});

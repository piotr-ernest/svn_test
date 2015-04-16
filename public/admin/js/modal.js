
// skrypt modalnego okienka uploadera

var modal = (function () {
    var
            method = {},
            $overlay,
            $modal,
            $content,
            $close;


    // Center the modal in the viewport
    method.center = function () {
        var top, left;

        top = Math.max($(window).height() - $modal.outerHeight(), 0) / 2;
        left = Math.max($(window).width() - $modal.outerWidth(), 0) / 2;

        $modal.css({
            top: top + $(window).scrollTop(),
            left: left + $(window).scrollLeft()
        });
    };


    // Open the modal
    method.open = function (settings) {


        $.ajax({
            url: settings.url,
            type: "post",
            //data: data,
            success: function (res) {
            $content.empty().append(res);
//                var parsed = JSON.parse(res);
//                for (var prop in parsed) {
//                    $('#related_output')
//                            .append('<option value="' + parsed[prop]['id'] + '">' + parsed[prop]['title'] + '</option>');
//                };
            },
            error: function (res) {
                alert("Błąd!");
            }
        });

        //$content.empty().append(res);

        $modal.css({
            width: settings.width || 'auto',
            height: settings.height || 'auto'
        });

        method.center();

        $(window).bind('resize.modal', method.center);

        $modal.show();
        $overlay.show();
    };

    // Close the modal
    method.close = function () {
        $modal.hide();
        $overlay.hide();
        $content.empty();
        $(window).unbind('resize.modal');
    };



    // Append the HTML
    $overlay = $('<div id="modal-overlay"></div>');
    $modal = $('<div id="modal-modal"></div>');
    $content = $('<div id="modal-content"></div>');
    $close = $('<a id="modal-close" href="#">close</a>');

    $modal.hide();
    $overlay.hide();
    $modal.append($content, $close);



    $(document).ready(function () {
        $('body').append($overlay, $modal);
    });

    $close.click(function (e) {
        e.preventDefault();
        method.close();
    });





    return method;
}());











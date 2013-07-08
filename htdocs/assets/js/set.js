$(function() {
    var COLORBAR_FADE = 1000;

    function hidePanels() {
        /*$('.properties').each(function() {
            $(this).hide();
        });*/
        $('.properties').hide();
    }

    function setColorBar(arr) {
        var perc = 100 / (arr.length - 1);
        var style = "";

        if (arr.length == 1) {
            style = "rgb(" + arr[0]['red'] + "," + arr[0]['green'] + "," + arr[0]['blue'] + ")";

            $('#colorbar').fadeOut(COLORBAR_FADE, function() {
                $('#colorbar').css('background-image', '')
                              .css('background-color', style)
                              .fadeIn(COLORBAR_FADE);
            });
        } else {
            for (var i = 0; i < arr.length; i++) {
                var tmpperc = Math.floor(i*perc);
                style += "rgb(" + arr[i]['red'] + "," + arr[i]['green'] + "," + arr[i]['blue'] + ") " + tmpperc + "% ";

                if (i != (arr.length - 1)) {
                    style += ", ";
                }
            }

            $('#colorbar').fadeOut(COLORBAR_FADE, function() {
                $('#colorbar').css("background-color", "")
                              .css("background-image", "linear-gradient(0deg, " + style + ")")
                              .css("background-image", "-webkit-linear-gradient(0deg, " + style + ")")
                              .css("background-image", "-moz-linear-gradient(0deg, " + style + ")")
                              .fadeIn(COLORBAR_FADE);
            });
        }
    }

    function setSwatch(swatch) {
        var id = swatch.id;
        var red = 0;
        var green = 0;
        var blue = 0;
        if (id == 'solid-swatch') {
            red_s= $('#solid-red').val();
            green_s = $('#solid-green').val();
            blue_s = $('#solid-blue').val();
        } else if (id == 'pulse-swatch') {
            red_s= $('#pulse-red').val();
            green_s = $('#pulse-green').val();
            blue_s = $('#pulse-blue').val();
        }

        if (red_s != '') {
            red = parseInt(red_s);
        }
        if (green_s != '') {
            green = parseInt(green_s);
        }
        if (blue_s != '') {
            blue = parseInt(blue_s);
        }

        $(swatch).css('background', 'rgb(' + red + ',' + green + ',' + blue + ')');
    }

    $('#config-containers').selectable({
        selected: function(event, ui) {
            hidePanels();
            if (ui.selected.id == 'tab-off') {
                $.post("/set", { function: 'off' });
            } else if (ui.selected.id == 'tab-solid') {
                $('#properties-solid').fadeIn(400);
            } else if (ui.selected.id == 'tab-pulse') {
                $('#properties-pulse').fadeIn(400);
            } else if (ui.selected.id == 'tab-dual') {
                $('#properties-dual').fadeIn(400);
            } else if (ui.selected.id == 'tab-multi') {
                $('#properties-multi').fadeIn(400);
            }
        }
    });

    $('#solid-submit').click(function() {
        $.post("/set", $("#solid-form").serialize());

        setColorBar([
            {red: $("#solid-red").val(), green: $("#solid-green").val(), blue: $("#solid-blue").val()}
        ]);

        return false;
    });

    $('#pulse-submit').click(function() {
        $.post("/set",
               $("#pulse-form").serialize()
        );

        setColorBar([
            {red: $('#pulse-red').val(), green: $('#pulse-green').val(), blue: $('#pulse-blue').val()},
            {red: 0, green: 0, blue: 0}
        ]);

        return false;
    });

    $('#dual-submit').click(function() {
        $.post("/set",
               $("#dual-form").serialize()
        );

        setColorBar([
            {red: $('#dual1-red').val(), green: $('#dual1-green').val(), blue: $('#dual1-blue').val()},
            {red: $('#dual2-red').val(), green: $('#dual2-green').val(), blue: $('#dual2-blue').val()}
        ]);

        return false;
    });

    $('#multi-submit').click(function() {
        $.post("/set",
               $("#multi-form").serialize()
        );
        return false;
    });

    $('.color-slider').slider({
        min: 0,
        max: 255,
        step: 1,
        range: "min",
        animate: true,
        change: function(event, ui) {
            $($(this).data('match')).attr('value', ui.value);
            setSwatch($(this).closest('form').find('.swatch')[0]);
        },
        create: function(event, ui) {
            $(this).slider('value', $(this).data('default'));
            $($(this).data('match')).attr('value', $(this).data('default'));
            setSwatch($(this).closest('form').find('.swatch')[0]);
        }
    });

    $('.wait-slider').slider({
        min: 1,
        max: 100,
        step: 1,
        range: "min",
        animate: true,
        orientation: "horizontal",
        change: function(event, ui) {
            $(this).closest('form').find('.form-wait').attr('value', ui.value);
        },
        create: function(event, ui) {
            $(this).slider('value', $(this).data('time'));
        }
    });
    $('.hold-slider').slider({
        min: 1,
        max: 100,
        step: 1,
        range: "min",
        animate: true,
        orientation: "horizontal",
        change: function(event, ui) {
            $(this).closest('form').find('.form-hold').attr('value', ui.value);
        },
        create: function(event, ui) {
            $(this).slider('value', $(this).data('time'));
        }
    });
});

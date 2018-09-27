(function ($, document) {
    var isMobile = false;
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
        isMobile = true;
    }

    $(document).on('ready', function () {
        var listView = $('.list-view');
        var body = $('body');
        var navMenu = $('.nav-menu');
        var navBar = $('.navbar');

        var settings = {
            speed     : 300,
            bulge     : 5,
            sizeImages: {
                square: {
                    width : 100,
                    height: 100
                },

                rectangle: {
                    width : 200,
                    height: 111
                }
            }
        };

        if (isMobile) {
            var documentMinHeight = document.documentElement.clientHeight +
                (document.documentElement.clientHeight *
                (document.documentElement.clientWidth / document.documentElement.offsetWidth));
            $('.wrap').css({minHeight: documentMinHeight});
        }

        var scrollToBottom = function () {
            $('html, body').stop().animate({scrollTop: $(document).height()}, settings.speed);
        };

        function toggleCheckboxCustom(checkbox) {
            checkbox.siblings('.checkbox-toggle').removeClass('active');

            if (checkbox.prop('checked')) {
                checkbox.siblings('.checkbox-custom-on').addClass('active');
            } else {
                checkbox.siblings('.checkbox-custom-off').addClass('active');
            }
        }

        $(document).find('.checkbox-custom').each(function () {
            toggleCheckboxCustom($(this));
        });

        $(document).find('.datepicker').datepicker({
            autoclose     : true,
            format        : 'yyyy-mm-dd',
            startDate     : new Date(),
            todayHighlight: true
        });

        if (!isMobile) {
            listView.sortable({
                axis: 'y',
                stop: function (event, ui) {
                    var target = $(ui.item[0]);
                    var url = '';

                    var request = {
                        current: target.data('key'),
                        prev   : target.prev().get(0) ? target.prev().data('key') : '',
                        next   : target.next().get(0) ? target.next().data('key') : ''
                    };

                    url += listView.data('sort-url');
                    url += '?current=' + request.current;
                    url += '&prev=' + request.prev;
                    url += '&next=' + request.next;

                    $.get(url);
                }
            });

            listView.disableSelection();
        } else {
            listView.find('.icon-drag').hide();
        }

        // Nav menu
        function setHeightMenu() {
            var height = $(window).height() - navBar.height();
            navMenu.css({maxHeight: height});
        }

        $(window).on('load resize', setHeightMenu);

        // Image Upload
        $('.image-upload').imageUpload({
            resizeWidth : settings.sizeImages.rectangle.width,
            resizeHeight: settings.sizeImages.rectangle.height
        });

        $('.image-upload-submit').imageUpload({
            resizeWidth       : settings.sizeImages.square.width,
            resizeHeight      : settings.sizeImages.square.height,
            submitFormOnChange: true
        });

        $('.single-image').each(function () {
            $(this).resizeAndCrop(settings.sizeImages.square);
        });

        function toggleDisabledSelect() {
            $(document).find('select.toggle-disabled').each(function () {
                $(this).attr('disabled', $(this).find('option').length < 2);
            })
        }

        toggleDisabledSelect();

        $(document)

            .on('click', 'a.header-menu', function (event) {
                event.preventDefault();
            })

            .on('click', '.btn-add-new', function (event) {
                event.preventDefault();
                var formTemplate = $(document).find('form.template');
                formTemplate.toggleClass('hide');
                if (!formTemplate.hasClass('hide')) {
                    formTemplate.find('[text]').trigger('focus');
                }
                scrollToBottom();
            })

            // Toggle menu

            .on('click', '.navbar-toggle', function () {
                navMenu.toggleClass('open hide');
            })

            // Alert

            .on('click', '.confirm-delete', function () {
                if ($(this).prev('.alert').get(0)) {
                    $(this).prev('.alert').removeClass('hide');
                    scrollToBottom();
                } else {
                    $(this).closest('.well').find('.alert').removeClass('hide');
                }
            })

            .on('click', '.close-alert', function () {
                $(this).closest('.alert').addClass('hide');
            })

            // Checkbox

            .on('change', '.checkbox-custom', function () {
                toggleCheckboxCustom($(this));
            })

            .on('click', '.checkbox-custom-on', function () {
                var checkbox = $(this).siblings('.checkbox-custom');
                checkbox.prop('checked', true);
                toggleCheckboxCustom(checkbox);
            })

            .on('click', '.checkbox-custom-off', function () {
                var checkbox = $(this).siblings('.checkbox-custom');
                checkbox.prop('checked', false);
                toggleCheckboxCustom(checkbox);
            })

            .on('change', '.get-data', function () {
                var target = $($(this).data('target'));
                var url = $(this).data('url');
                url += '?arg=' + $(this).val();

                $.get(url).done(function (response) {
                    target.find('option:not(option:first)').remove();
                    if ($(target.data('target')).get(0)) {
                        $(target.data('target')).find('option:not(option:first)').remove();
                    }
                    var data = JSON.parse(response);

                    for (var item in data) {
                        if (data.hasOwnProperty(item)) {
                            var option = document.createElement('option');
                            option.value = data[item].value;
                            option.innerHTML = data[item].name;
                            target.append(option);
                        }
                    }

                    toggleDisabledSelect();
                });
            })
        ;

        function handlerMoveStart(event) {
            if (!body.hasClass('swipe')) {
                event.preventDefault();
                return;
            }

            if ((event.distX > event.distY && event.distX < -event.distY) ||
                (event.distX < event.distY && event.distX > -event.distY)) {
                event.preventDefault();
            } else {
                if ((event.distX > 0 && navMenu.hasClass('open')) ||
                    (event.distX < 0 && navMenu.hasClass('hide'))) {
                    event.preventDefault();
                }
                body.addClass('notransition');
            }
        }

        function handlerMove(event) {
            if (!body.hasClass('swipe')) {
                event.preventDefault();
                return;
            }

            var left = parseInt(navMenu.css('left'), 10);
            var width = navMenu.width();
            var activate = width / 5;
            var step = 100 * event.distX / navMenu.width();

            if (step > 0) {
                left = -width + step;

                if (step > activate) {
                    navMenu.removeClass('hide').addClass('open');
                }
            }

            if (step < 0) {
                left = step;

                if (step < -activate) {
                    navMenu.removeClass('open').addClass('hide');
                }
            }

            if (left > 0) {
                left = 0;
            }

            if (left < -width) {
                left = -width;
            }

            navMenu.css({left: left});
        }

        function handlerMoveEnd(event) {
            if (!body.hasClass('swipe')) {
                event.preventDefault();
                return;
            }
            body.removeClass('notransition');
            navMenu.removeAttr('style');
        }

        // Swipe menu
        function setSWipe() {
            if ($(window).width() < 767 && isMobile) {
                body.addClass('swipe');
                body.on('movestart', handlerMoveStart)
                    .on('move', handlerMove)
                    .on('moveend', handlerMoveEnd);
            } else {
                body.removeClass('swipe');
                body.off('movestart move moveend');
            }
        }

        setSWipe();

        $(window).on('resize', setSWipe);

        // document.documentElement.clientWidth
        // window.innerWidth;

        //alert(document.documentElement.offsetWidth + ' ' + document.documentElement.clientWidth + ' ' + document.documentElement.clientHeight);
    });
}(jQuery, window.document));
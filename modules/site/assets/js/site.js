(function ($) {
    $(document).ready(function () {
        var body = $('body');
        var rows = Math.ceil($('.photoset-grid-lightbox img').length / 14);
        var layout = '';

        function toggleComments(thumbnail) {
            thumbnail.find('.toggle-thumbnail').toggleClass('invisible');
            thumbnail.find('.toggle-comment').toggleClass('invisible');
        }

        $(document)
            .on('click', '.grid-toggle', function () {

            })

            .on('click', '.btn-comment, .btn-camera', function (event) {
                event.preventDefault();
                var thumbnail = $(this).closest('.thumbnail');
                toggleComments(thumbnail);
            })

            .on('submit', '.form-comment', function (event) {
                event.preventDefault();
                var form = $(this);
                var commentsWrap = form.siblings('.comments');
                var template = commentsWrap.find('.comment.template').clone();
                var count = form.closest('.thumbnail').find('.btn-comment').find('.count');

                $.ajax({
                    method : 'post',
                    url    : form.attr('action'),
                    data   : form.serialize(),
                    success: function (response) {
                        response = JSON.parse(response);
                        template.find('.created_at').text(response.created_at);
                        template.find('.comment-text').text(response.body);

                        form.find('textarea').wrap('<form>').parent().trigger('reset').find('textarea').unwrap();

                        commentsWrap.append(template);
                        template.removeClass('template hide');

                        count.text(+count.text() + 1);
                    },
                    error  : function (error) {
                        console.log('error');
                        console.log(error);
                    }
                });
            })

            .on('click', '.btn-like', function () {
                var self = $(this);
                $.ajax({
                    method : 'get',
                    url    : self.data('url'),
                    success: function (count) {
                        self.find('.count').text(count);
                    }
                });
            })
        ;

        for (var i = 0; i != rows; i++) {
            layout += '8';
        }

        $('.photoset-grid-lightbox').photosetGrid({
            gutter      : '10px',
            highresLinks: true,
            rel         : 'gallery',
            layout      : layout,
            onComplete  : function (grid) {
                $(grid).removeClass('invisible');

                $(grid).find('a[rel="gallery"]').colorbox({
                    photo         : true,
                    scalePhotos   : true,
                    slideshow     : true,
                    slideshowSpeed: 5000,
                    width         : '100%',
                    height        : '100%',
                    maxHeight     : '100%',
                    maxWidth      : '100%',
                    onOpen        : function () {

                        if (!$('#cboxFullscreen').length > 0) {
                            $('#cboxClose').before('<div id="cboxFullscreen"></div>');
                        }
                    }
                });

                $(document).bind("fullscreenchange", function () {

                    if ($(document).fullScreen()) {

                        $(grid).find('a[rel="gallery"]').colorbox({
                            width    : '100%',
                            height   : '100%',
                            maxWidth : '100%',
                            maxHeight: '100%'
                        });

                        $('#cboxFullscreen').addClass('fullScreen');

                    } else {

                        $(grid).find('a[rel="gallery"]').colorbox({
                            width    : 'auto',
                            height   : 'auto',
                            maxWidth : '90%',
                            maxHeight: '90%'
                        });

                        $('#cboxFullscreen').removeClass('fullScreen');

                    }

                    $('.cboxSlideshow_off #cboxSlideshow').click();
                    $.colorbox.next();

                });

                if ($('.start-slide-show').length > 0) {

                    $(grid).find('a[rel="gallery"]').first().trigger('click');
                }

                body.on('click', '#cboxFullscreen', function () {
                    $('.cboxSlideshow_on #cboxSlideshow').click();
                    $('#colorbox').toggleFullScreen();
                });

                body.on('click', '#cboxClose', function () {

                    if ($(document).fullScreen()) {
                        $(document).fullScreen(false);
                    }

                });
            }
        });

        Dropzone.options.weddingPhotos = {
            acceptedFiles: 'image/*'
        };

        var dropzoneBlock = $('#weddingPhotos');

        if (dropzoneBlock.length > 0) {
            var filename = dropzoneBlock.find(':file').attr('name');

            Dropzone.options.autoDiscover = false;

            var DropArea = new Dropzone('#weddingPhotos');

            DropArea.options.paramName = filename;

            DropArea.on('complete', function (file) {
                var removeBtn = $('<span class="remove" title="Remove"></span>');
                removeBtn.data('filename', file.xhr.response);
                $(file.previewElement).append(removeBtn);
                $(file.previewElement).find('.remove').on('click', function () {
                    var btn = $(this);

                    $.ajax({
                        url   : dropzoneBlock.data('remove'),
                        method: 'post',
                        data  : {
                            filename: btn.data('filename')
                        },

                        success: function () {
                            $(file.previewElement).fadeOut(400, function () {
                                DropArea.removeFile(file);
                            });
                        }
                    });
                });
            });
        }

        //Select photos to download
        var arrSelected = [];
        var downloadText = '.download-link span';

        $('.icon-select').on('click', function () {
            $(this).toggleClass('selected');
            if ($(this).hasClass('selected')) {
                arrSelected.push($(this).data('id'));
            } else {
                arrSelected.splice($.inArray($(this).data('id'), arrSelected), 1);
            }
            if (arrSelected.length != 0) {
                $(downloadText).text('Download selected (' + arrSelected.length + ')');
            } else {
                $(downloadText).text('Download all pictures');
            }
        });

        $('.download-link').on('click', function () {
            if (arrSelected.length != 0) {
                window.location.assign($(this).attr('href') + '?id=' + arrSelected);
                return false;
            }
        });

        body.append('<div class="thumbnail-photo-overlay"><span class="thumbnail-photo-overlay-close">x</span><img src=""' +
            ' /></div>');
        var productImage = $('.thumbnail-photo');
        var productOverlay = $('.thumbnail-photo-overlay');
        var productOverlayImage = $('.thumbnail-photo-overlay img');
        var windowH = $(window).height();
        var windowW = $(window).width();
        var imageH = productOverlayImage.height();
        var imageW = productOverlayImage.width();

        productImage.click(function () {
            var productImageSource = $(this).attr('data-highres');

            productOverlayImage.attr('src', productImageSource);
            productOverlay.fadeIn(100);
            if (windowH < imageH) {
                productOverlayImage.css({'height': ($(window).height()) + 'px'});
            }
            if (windowW < imageW) {
                productOverlayImage.css({'width': ($(window).width()) + 'px'});
            }

            $('.thumbnail-photo-overlay-close').click(function () {
                productOverlay.fadeOut(100);
            });
        });
    });
}(jQuery));

(function ($) {
    'use strict';

    $(document).ready(function ($) {

        // Calculate clients viewport

        function viewport() {
            var e = window, a = 'inner';
            if (!('innerWidth' in window)) {
                a = 'client';
                e = document.documentElement || document.body;
            }
            return { width: e[a + 'Width'], height: e[a + 'Height'] };
        }

        var w = window, d = document,
            e = d.documentElement,
            g = d.getElementsByTagName('body')[0],
            x = w.innerWidth || e.clientWidth || g.clientWidth, // Viewport Width
            y = w.innerHeight || e.clientHeight || g.clientHeight; // Viewport Height

        // Retina Detection

        if (document.cookie.indexOf('device_pixel_ratio') == -1
            && 'devicePixelRatio' in window
            && window.devicePixelRatio == 2) {

            var date = new Date();
            date.setTime(date.getTime() + 3600000);

            document.cookie = 'device_pixel_ratio=' + window.devicePixelRatio + ';' + ' expires=' + date.toUTCString() + '; path=/';
            //if cookies are not blocked, reload the page
            if (document.cookie.indexOf('device_pixel_ratio') != -1) {
                window.location.reload();
            }
        }

        // Album slider

        var templateAlbums = $('.template-front-albums');
        var albumSlider = $('.album-slider-wrapper');
        var albumSliderWrap = albumSlider.parent();
        var albumSliderWidth = albumSlider.width();
        var albumSlide = $('.album-slider-wrapper').find('article');


        if (x < 1200 && x > 782 && !templateAlbums.hasClass('one-album')) {
            albumSlide.css('margin', '0 30px').width(albumSliderWidth - 60);
        }
        else {
            albumSlide.width(albumSliderWidth);
        }

        var sectionAlbumImg = albumSlide.find('.featured-image');

        albumSlide.each(function () {
            var $this = $(this);
            if ($this.find('.featured-image').length) {
                $this.find('.entry-content').css('width', '');
            }
            else {
                $this.find('.entry-content').css('width', '100%');
            }
        });

        // Styling for iOS8 devices

        var body = $('body');
        var isIOS8 = /(iPhone|iPad|iPod)\sOS\s8/.test(navigator.userAgent);

        if (isIOS8) {
            var siteWrap = $('.site');
            var mobilePreloader = $('.mobile-preloader');
            body.addClass('loaded');
            siteWrap.css('opacity', 1);
            mobilePreloader.hide();

            var albumSlider = $('.album-slider-wrapper');
            var albumSliderWrap = albumSlider.parent();

            if (x <= 1024) {
                albumSlider.sly({
                    horizontal: 1,
                    itemNav: 'forceCentered',
                    smart: 1,
                    activateMiddle: 1,
                    activateOn: 'click',
                    touchDragging: 1,
                    releaseSwing: 1,
                    startAt: 0,
                    speed: 800,
                    elasticBounds: 1,
                    easing: 'easeOutExpo',
                    dragHandle: 1,
                    dynamicHandle: 1,
                    clickBar: 1,
                    prev: albumSliderWrap.find('.prev > a:first-child'),
                    next: albumSliderWrap.find('.next > a:first-child')
                },
                    {
                        // On animation start
                        moveStart: function () {
                            var active_albumHeight = albumSlider.find('.active').outerHeight();

                            albumSlider.height(active_albumHeight);
                            albumSlider.parent().height(active_albumHeight);
                        }
                    });
            }
        }

        // Focus links only on keydown event

        $(function () {
            var lastKey = new Date(),
                lastClick = new Date();

            $(document).on('focusin', function (e) {
                $('.non-keyboard-outline').removeClass('non-keyboard-outline');
                var wasByKeyboard = lastClick < lastKey;
                if (wasByKeyboard) {
                    $(e.target).addClass('non-keyboard-outline');
                }

            });

            $(document).on('click', function () {
                lastClick = new Date();
            });
            $(document).on('keydown', function () {
                lastKey = new Date();
            });

        });

        // Main Navigation for small screens

        $(document).on('click', function () {
            body.removeClass('menu-opened');
        });

        var slideMenu = $('.menu-container');
        var closeSlideMenu = $('.close-menu');
        var menuTrigger = $('.menu-toggle');

        menuTrigger.on('click', function (e) {
            e.stopPropagation();
            body.toggleClass('menu-opened');
        });

        closeSlideMenu.on('click touchstart', function (e) {
            e.preventDefault();
            body.removeClass('menu-opened');
        });

        slideMenu.on('click touchstart', function (e) {
            e.stopPropagation();
        });

        // Social Icons

        var mainHeader = $('.site-header');
        var iconsOpen = $('.social-open');
        var iconsClose = $('.social-close');

        iconsOpen.on('click touchstart', function (e) {
            e.preventDefault();
            $(this).hide();
            mainHeader.addClass('icons-open');
            iconsClose.show();
        });

        iconsClose.on('click touchstart', function (e) {
            e.preventDefault();
            $(this).hide();
            mainHeader.removeClass('icons-open');
            iconsOpen.show();
        });

        // Nicescroll for main menu

        var slideMenuNav = $('.menu-container > div');
        var slideMenuNavUl = $('.menu-container > div > ul');

        if (x > 1024 && x < 1200) {
            slideMenuNav.niceScroll(slideMenuNavUl, {
                cursorcolor: '#b1b1b1',
                cursorborder: 0,
                cursorwidth: 3,
                scrollspeed: 80,
                mousescrollstep: 20,
                cursoropacitymin: 1,
                horizrailenabled: false,
                bouncescroll: false
            });
        }

        // Get direction button

        var getDirectionsBtn = $('.get-directions');

        getDirectionsBtn.click(function (e) {
            e.preventDefault();

            var eventId = $(this).data('event-id');
            $('.directions-form').not('#directions-form-' + eventId).fadeOut('slow');
            $('#directions-form-' + eventId).fadeToggle('slow', function () {
                $(this).find('.location-input').focus().css('border-color', '#eee');
            });
        });

        // Masonry call

        var $container = $('.grid-wrapper').masonry({
            itemSelector: '.grid-wrapper article'
        });

        $container.imagesLoaded(function () {
            $container.masonry('layout');
        });

        // Show gallery on gallery single if user inserted it

        var gallery_single = $('.single-gallery');

        // If is gallery single page

        if (gallery_single.length) {
            var post_content = $('.entry-content');
            var gallery_tiled = post_content.find('.tiled-gallery');
            var gallery_row = $('.gallery-item');
            var featured_container = $('.featured-image');
            var gallery_wrapper;

            if (gallery_tiled.length) {
                gallery_wrapper = gallery_tiled;
            }
            else if (gallery_row.length) {
                gallery_wrapper = gallery_row.parent();
            }
            else {
                gallery_wrapper = 'no-gallery';
            }

            if (gallery_wrapper != 'no-gallery') {
                featured_container.empty();
                gallery_wrapper.clone().appendTo(featured_container);
                gallery_wrapper.empty();
            }

        }

        // Masonry for section gallery on front page

        var galleryMasonry = $('.gallery-list .row').masonry({
            itemSelector: '.gallery-list article'
        });

        galleryMasonry.imagesLoaded(function () {
            galleryMasonry.masonry('layout');
        });

        // Back to top

        if (x > 1024) {
            var toTopArrow = $('.back-to-top');

            toTopArrow.on('click touchstart', function (e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 800, 'easeOutQuart');
                return false;
            });

            $(window).scroll(function () {
                var $this = $(this);
                if ($this.scrollTop() > 1000) {
                    toTopArrow.fadeIn();
                }
                else {
                    toTopArrow.fadeOut();
                }
            });
        }

        // Custom header
        // get image and set it as background

        var customHeader = $('.custom-header');

        var customHeaderImg = customHeader.find('img');
        var customHeaderImgSrc = customHeaderImg.attr('src');
        var customHeaderVideo = customHeader.find('iframe');

        if (customHeaderVideo.length < 1) {
            customHeader.css('background-image', 'url(' + customHeaderImgSrc + ')');
        }

        // fade out info on scroll

        var customHeaderInfo = $('#header-content-box');

        $(window).scroll(function () {
            if ($(this).scrollTop() > (y / 5)) {
                customHeaderInfo.addClass('fade-out').removeClass('fade-in');
            }
            else {
                customHeaderInfo.removeClass('fade-out').addClass('fade-in');
            }
        });

        // Get featured-image for background on section Event on front page template

        var eventContent = $('.template-front-events article');

        eventContent.each(function () {
            var featuredImg = $(this).find('.featured-image img');
            if (featuredImg.length) {
                var featuredImgSrc = featuredImg.attr('src');
                $(this).find('.featured-image').css('background-image', 'url(' + featuredImgSrc + ')');
            }
        });

        // Front page template event slider

        var eventSlider = $('.event-slider');
        var eventSliderWrap = eventSlider.parent();
        var containerWidth = $('.container').width();
        var eventListWidth = eventSlider.parent().parent().width();
        var eventSlide = eventSlider.find('article');


        if (x < 500) {
            eventSliderWrap.css('margin-right', 0);
            eventSlide.outerWidth(eventListWidth);
        }
        else {
            eventSliderWrap.css('margin-right', - (x - containerWidth) / 2 + 8);
        }

        eventSlider.sly({
            horizontal: 1,
            itemNav: 'basic',
            itemSelector: $(this).find('article'),
            smart: 1,
            activateOn: 'click',
            activateMiddle: 1,
            mouseDragging: 1,
            touchDragging: 1,
            releaseSwing: 1,
            startAt: 0,
            speed: 300,
            scrollBy: false,
            elasticBounds: 1,
            easing: 'easeOutExpo',
            dragHandle: 1,
            scrollBar: eventSliderWrap.find('.scrollbar'),
            keyboardNavBy: 'items'
        });


        if (eventSlide.length < 3) {
            eventSliderWrap.find('.scrollbar').hide();
        }

        var templateAlbumsNav = $('.template-front-albums nav');
        var templateAlbumsNavParentHeight = templateAlbumsNav.parent().height();

        if (x <= 1024) {
            templateAlbumsNav.height('').removeClass('verticalize-container');
            templateAlbumsNav.find('a').removeClass('verticalize');
        }


        var templateAlbumsNav = $('.template-front-albums nav');
        var templateAlbumsNavParentHeight = templateAlbumsNav.parent().height();

        if (x <= 1024) {
            templateAlbumsNav.height('').removeClass('verticalize-container');
            templateAlbumsNav.find('a').removeClass('verticalize');
        }

        $('.quote-slider').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: false,
            dots: true
        });

        // Fancybox

        $('.fancybox').fancybox();

        // Push sidebar after main content in pages and album single bellow 992px

        var sidebar = $('#sidebar');
        var primaryContent = $('#primary');

        if (body.is('.single-album, .page-template-default')) {
            if (x < 992) {
                sidebar.insertAfter(primaryContent);
            }
            else {
                sidebar.insertBefore(primaryContent);
            }
        }

        // If page has sidebar, put page navigation below content on resolutions smaller than 1200px

        var pageNav = $('.post-navigation');
        var singleMainWrap = $('.single .site-main > article');
        var singleMainContent = $('.single .site-main > article .entry-content');
        var eventContentWrap = $('.event-content-wrapper');
        var pageTitle = $('.row > header .entry-title, .row > header .page-title');

        if (body.hasClass('single-album')) {
            if (sidebar.length) {
                singleMainContent.append(pageNav);
            }
            else {
                if (x < 1200 && pageNav.length) {
                    singleMainContent.append(pageNav);
                }
                else {
                    pageNav.insertAfter(pageTitle);
                }
            }
        }
        else if (body.hasClass('single-event')) {
            eventContentWrap.append(pageNav);
        }
        else {
            if (x < 1200 && pageNav.length) {
                pageNav.insertAfter(singleMainWrap);
            }
            else {
                pageNav.insertAfter(pageTitle);
            }
        }

        // Send email AJAX function

        $('#send_contact').click(function () {
            // Get data values from submited form
            var sender_name = document.getElementById('contactname');
            var sender_email = document.getElementById('contactemail');
            var sender_message = document.getElementById('contactmessage');
            var message_info = js_vars.message_info;

            var sender_captcha_value;

            if (js_vars.captcha != 1) {
                var sender_captcha = document.getElementById('captcha-form');
                sender_captcha_value = sender_captcha.value;
            }

            // Pass our data and actons to AJAX function
            $.ajax({
                type: "post",
                url: js_vars.admin_url,
                data: {
                    action: 'send_contact_email',
                    nonce: js_vars.nonce,
                    sender_name: sender_name.value,
                    sender_email: sender_email.value,
                    sender_message: sender_message.value,
                    sender_captcha: sender_captcha_value,
                    message_info: js_vars.message_info
                },
                beforeSend: function () {
                    $("#contact-error").empty();
                    $("#contact-error").append('Sending...');
                },
                success: function (data) {
                    $("#contact-error").empty();
                    $("#contact-error").append(data);

                    // Empty all form fields
                    if (message_info == data) {
                        setTimeout(function () {
                            $('#contactform').each(function () {
                                this.reset();
                            });
                            $("#contact-error").empty();
                        }, 3000);
                    }

                }
            });
            return false;
        });

        // Grid Filtering

        $('.filter-nav a').click(function () {
            // fetch the class of the clicked item
            var ourClass = $(this).attr('class');
            var gridWrap = $('.grid-wrapper');

            // reset the active class on all the buttons
            $('.filter-nav li').removeClass('selected');
            // update the selected state on our clicked button
            $(this).parent().addClass('selected');

            if (ourClass == 'all') {
                // show all our items
                gridWrap.children('article').removeClass('dim').find('a').unbind('click');
            }
            else {
                // hide all elements that don't share ourClass
                gridWrap.children('article:not(.' + ourClass + ')').addClass('dim').find('a').click(function (e) {
                    e.preventDefault();
                });
                // show all elements that do share ourClass
                gridWrap.children('article.' + ourClass).removeClass('dim').find('a').unbind('click');
            }
            return false;
        });

        // Hide footer widget area if there are no widgets

        var widgetArea = $('.site-footer .row');
        var footerWidgets = $('.site-footer .widget');

        if (!footerWidgets.length) {
            widgetArea.hide();
        }

    }); // End Document Ready

    $(window).load(function () {

        var mobilePreloader = $('.mobile-preloader');

        mobilePreloader.fadeOut(500);

        // Calculate clients viewport

        function viewport() {
            var e = window, a = 'inner';
            if (!('innerWidth' in window)) {
                a = 'client';
                e = document.documentElement || document.body;
            }
            return { width: e[a + 'Width'], height: e[a + 'Height'] };
        }

        var w = window, d = document,
            e = d.documentElement,
            g = d.getElementsByTagName('body')[0],
            x = w.innerWidth || e.clientWidth || g.clientWidth, // Viewport Width
            y = w.innerHeight || e.clientHeight || g.clientHeight; // Viewport Height

        // Hide preloader

        var preloader = $('.pace');

        if (x > 1024) {
            setTimeout(function () {
                preloader.hide();
            }, 1500);
        }

        // Add class loaded to body on page load

        var body = $('body');

        body.addClass('loaded');

        // Custom header and main header fit to viewport

        var mainHeader = $('.site-header');
        var customHeader = $('.custom-header');
        var mainHeaderHeight = mainHeader.outerHeight();
        var adminBarHeight = $('#wpadminbar').height();

        if (x > 1024) {
            mainHeader.ready(function () {
                if (body.hasClass('admin-bar')) {
                    customHeader.height(y - mainHeaderHeight - adminBarHeight);
                }
                else {
                    customHeader.height(y - mainHeaderHeight);
                }
            });
        }
        else {
            if (body.hasClass('admin-bar')) {
                customHeader.height(y - mainHeaderHeight - adminBarHeight - 100);
            }
            else {
                customHeader.height(y - mainHeaderHeight - 100);
            }
        }

        // Nicescroll for tracks

        var trackList = $('.template-front-albums .wp-playlist-tracks');

        trackList.wrap('<div class="playlist-wrap"></div>');

        if (x > 1024) {
            trackList.each(function () {
                var $this = $(this);
                var thisWrap = $(this).parent();
                thisWrap.niceScroll($this, {
                    cursorcolor: '#fb4f00',
                    cursorborder: 0,
                    cursorwidth: 5,
                    cursorfixedheight: 70,
                    scrollspeed: 80,
                    mousescrollstep: 20,
                    cursorborderradius: 0,
                    cursoropacitymin: 1,
                    horizrailenabled: false,
                    bouncescroll: false
                });
            });
        }
        else {
            trackList.each(function () {
                var $this = $(this);
                if ($this.height() > 216) {
                    $this.closest('article').addClass('scroll-down');
                }
            });
            var playlistWrap = trackList.parent();
            playlistWrap.scroll(function () {
                var $this = $(this);
                var childHeight = $this.find('.wp-playlist-tracks').height();
                if ($this.scrollTop() >= (childHeight - 216)) {
                    $this.closest('article').removeClass('scroll-down');
                }
                else {
                    $this.closest('article').addClass('scroll-down');
                }
            });
        }

        // Album slider

        var albumSlider = $('.album-slider-wrapper');
        var albumSliderWrap = albumSlider.parent();
        var albumSliderWidth = $('.album-slider-wrapper').width();

        var options = {
            horizontal: 1,
            itemNav: 'forceCentered',
            smart: 1,
            activateMiddle: 1,
            activateOn: 'click',
            touchDragging: 1,
            releaseSwing: 1,
            startAt: 0,
            speed: 600,
            elasticBounds: 1,
            easing: 'easeOutExpo',
            dragHandle: 1,
            dynamicHandle: 1,
            clickBar: 1,
            prev: albumSliderWrap.find('.prev > a:first-child'),
            next: albumSliderWrap.find('.next > a:first-child')
        };

        if (x > 1024) {
            // Add event triggers
            albumSlider.sly(options, {
                // When active slide
                load: function () {
                    var active_album = albumSlider.find('.active');
                    var active_albumHeight = active_album.height();
                    var prev_album = active_album.prev('article');
                    var next_album = active_album.next('article');
                    var nextAlbum_title = next_album.find('.entry-title').html();
                    var prevAlbum_title = prev_album.find('.entry-title').html();

                    albumSlider.height(active_albumHeight);
                    albumSlider.parent().height(active_albumHeight);

                    if (prev_album.length) {
                        $('nav.prev > a:first-child > h3').html(prevAlbum_title);
                    }

                    if (next_album.length) {
                        $('nav.next > a:first-child > h3').html(nextAlbum_title);
                    }

                },

                // On animation start
                moveStart: function () {
                    var active_albumHeight = albumSlider.find('.active').height();
                    var album_info = $('.template-front-albums nav a:first-child h3');

                    album_info.animate({ opacity: 0 }, 100);
                    albumSlider.height(active_albumHeight);
                    albumSlider.parent().height(active_albumHeight);
                },

                // On animation end
                moveEnd: function () {

                    var active_album = albumSlider.find('.active');
                    var prev_album = active_album.prev('article');
                    var next_album = active_album.next('article');
                    var nextAlbum_title = next_album.find('.entry-title').html();
                    var prevAlbum_title = prev_album.find('.entry-title').html();


                    if (prev_album.length) {
                        var prevAlbumNav = $('nav.prev > a:first-child');
                        $('nav.prev > a:first-child > h3').animate({ opacity: 1 }, 200).html(prevAlbum_title);
                        prevAlbumNav.find('span').animate({ opacity: 1 }, 200).text('Prev Album');
                    }

                    if (next_album.length) {
                        var nextAlbumNav = $('nav.next > a:first-child');
                        nextAlbumNav.find('h3').animate({ opacity: 1 }, 200).html(nextAlbum_title);
                        nextAlbumNav.find('span').animate({ opacity: 1 }, 200).text('Next Album');
                    }

                }
            });
        }
        else {
            albumSlider.sly(options, {
                // When active slide
                load: function () {
                    var active_album = albumSlider.find('.active');
                    var active_albumHeight = active_album.height();

                    albumSlider.height(active_albumHeight);
                    albumSlider.parent().height(active_albumHeight);
                },

                // On animation start
                moveStart: function () {
                    var active_albumHeight = albumSlider.find('.active').outerHeight();
                    albumSlider.height(active_albumHeight);
                    albumSlider.parent().height(active_albumHeight);
                }
            });
        }

        var templateAlbumsNav = $('.template-front-albums nav');
        var templateAlbumsNavParentHeight = templateAlbumsNav.parent().height();

        if (x >= 1200) {
            templateAlbumsNav.height(templateAlbumsNavParentHeight).addClass('verticalize-container');
            templateAlbumsNav.find('a').addClass('verticalize');
        }
        else if (x > 1024 && x < 1200) {
            templateAlbumsNav.height('').removeClass('verticalize-container');
            templateAlbumsNav.find('a').removeClass('verticalize');
        }

        // Vertical and Horizontal middle

        var verticalMiddle = $('.vertical-middle');

        verticalMiddle.css('margin-top', function () {
            return -($(this).height() / 2);
        });

        var horizontalMiddle = $('.horizontal-middle');

        horizontalMiddle.css('margin-left', function () {
            return -($(this).width() / 2);
        });

        // Stick footer to bottom of the page if site content doesn't fill viewports height

        var siteWrapHeight = $('.site').height();
        var siteHeight = siteWrapHeight + adminBarHeight;
        var footer = $('.site-footer');

/*         if (siteHeight < y) {
            footer.addClass('sticky');
        } */

    }); // End Window Load

    $(window).resize(function () {

        // Calculate clients viewport

        function viewport() {
            var e = window, a = 'inner';
            if (!('innerWidth' in window)) {
                a = 'client';
                e = document.documentElement || document.body;
            }
            return { width: e[a + 'Width'], height: e[a + 'Height'] };
        }

        var w = window, d = document,
            e = d.documentElement,
            g = d.getElementsByTagName('body')[0],
            x = w.innerWidth || e.clientWidth || g.clientWidth, // Viewport Width
            y = w.innerHeight || e.clientHeight || g.clientHeight; // Viewport Height

        // Hide mobile preloader on resize

        var mobilePreloader = $('.mobile-preloader');

        if (x < 1025) {
            mobilePreloader.hide();
        }

        // Push sidebar after main content in pages and album single bellow 992px

        var body = $('body');
        var sidebar = $('#sidebar');
        var primaryContent = $('#primary');

        if (body.is('.single-album, .page-template-default')) {
            if (x < 992) {
                sidebar.insertAfter(primaryContent);
            }
            else {
                sidebar.insertBefore(primaryContent);
            }
        }

        // Stick footer to bottom of the page if site content doesn't fill viewports height

        var siteWrapHeight = $('.site').height();
        var adminBarHeight = $('html').css('margin-top');
        var siteHeight = siteWrapHeight + adminBarHeight;
        var footer = $('.site-footer');

        if (siteHeight < y) {
            footer.addClass('sticky');
        }

        // If page has sidebar, put page navigation below content on resolutions smaller than 1200px

        var pageNav = $('.post-navigation');
        var singleMainWrap = $('.single .site-main > article');
        var singleMainContent = $('.single .site-main > article .entry-content');
        var eventContentWrap = $('.event-content-wrapper');
        var pageTitle = $('.row > header .entry-title, .row > header .page-title');

        if (body.hasClass('single-album')) {
            if (sidebar.length) {
                singleMainContent.append(pageNav);
            }
            else {
                if (x < 1200 && pageNav.length) {
                    singleMainContent.append(pageNav);
                }
                else {
                    pageNav.insertAfter(pageTitle);
                }
            }
        }
        else if (body.hasClass('single-event')) {
            eventContentWrap.append(pageNav);
        }
        else {
            if (x < 1200 && pageNav.length) {
                pageNav.insertAfter(singleMainWrap);
            }
            else {
                pageNav.insertAfter(pageTitle);
            }
        }

        // Nicescroll for main menu

        var slideMenuNav = $('.menu-container > div');
        var slideMenuNavUl = $('.menu-container > div > ul');

        if (x > 1024 && x < 1200) {
            slideMenuNav.niceScroll(slideMenuNavUl, {
                cursorcolor: '#b1b1b1',
                cursorborder: 0,
                cursorwidth: 3,
                scrollspeed: 80,
                mousescrollstep: 20,
                cursoropacitymin: 1,
                horizrailenabled: false,
                bouncescroll: false
            });
        }

        var trackList = $('.template-front-albums .wp-playlist-tracks');

        trackList.getNiceScroll().resize();

        // Album slider

        var templateAlbums = $('.template-front-albums');
        var albumSlider = $('.album-slider-wrapper');
        var albumSliderWidth = albumSlider.width();
        var albumSlide = $('.album-slider-wrapper').find('article');


        if (x < 1200 && x > 782 && !templateAlbums.hasClass('one-album')) {
            albumSlide.css('margin', '0 30px').width(albumSliderWidth - 60);
        }
        else {
            albumSlide.width(albumSliderWidth);
        }

        albumSlider.sly('reload');

        var templateAlbumsNav = $('.template-front-albums nav');
        var templateAlbumsNavParentHeight = templateAlbumsNav.parent().height();

        if (x >= 1200) {
            templateAlbumsNav.height(templateAlbumsNavParentHeight).addClass('verticalize-container');
            templateAlbumsNav.find('a').addClass('verticalize');
        }
        else {
            templateAlbumsNav.height('').removeClass('verticalize-container');
            templateAlbumsNav.find('a').removeClass('verticalize');
        }

        // Front page template event slider

        var eventSlider = $('.event-slider');
        var eventSliderWrap = eventSlider.parent();
        var containerWidth = $('.container').width();
        var eventListWidth = eventSlider.parent().parent().width();
        var eventSlide = eventSlider.find('article');

        eventSliderWrap.css('margin-right', - (x - containerWidth) / 2 + 8);


        if (x < 500) {
            eventSliderWrap.css('margin-right', 0);
            eventSlide.outerWidth(eventListWidth);
        }
        else {
            eventSliderWrap.css('margin-right', - (x - containerWidth) / 2 + 8);
            eventSlide.outerWidth('');
        }

        eventSlider.sly('reload');

    }); // End Window Resize

    // ****
    // Cookie Consent Bar
    // ****
    function handleCookieBar() {
        $('.cookie-info').hide();
        if (sessionStorage.getItem('cookieNotifyState') != 'dismissed') {
            $('.cookie-info').delay(2000).fadeIn();

        }
        $('.cookie-info').on('click', '.dismiss-cookie-notification', function (event) {
            event.preventDefault();
            $('.cookie-info').fadeOut();
            sessionStorage.setItem('cookieNotifyState', 'dismissed');
        });
    }
    handleCookieBar();

})(jQuery);
var breakpoint = new function(){
    var value;
    this.set = function(bp) {
        if (value === bp) return;
        else {
            value = bp;
        }
        jQuery(window).trigger("break", value);
    };
    this.get = function() {
        return value;
    }
};

function showModalImage(e) {
    var target = this;

    if (target.nodeName != "IMG") target = jQuery(this).find("img").get(0);
    var title = target.getAttribute('alt');
    var productName = jQuery('[itemprop="name"]');

    jQuery('.modal-body').html("<div style='text-align:center;'><img src='" + jQuery(target).attr('src') + "'/></div>"); // here asign the image to the modal when the user click the enlarge link
    if (title) {
        jQuery('.modal-title').html(title);
    } else if (productName.length) {
        jQuery('.modal-title').html(productName.text());
    } else {
        jQuery('.modal-title').html('');
    }
    jQuery('.modal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
}

jQuery(window).on("resize", (function(){
    var getBP = function getBP() {
        var w = jQuery(window).width();

        if (w >= 1200) breakpoint.set("lg");
        else if (w >= 992) breakpoint.set("md");
        else if (w >= 768) breakpoint.set("sm");
        else if (w >= 567) breakpoint.set("xs");
        else breakpoint.set("xxs");

        return getBP;
    }();

    return getBP;
})());

var Carousel = new function () {

    var carousels = [];

    var currentBreakpoint = breakpoint.get();

    console.log(currentBreakpoint);

    var defaults = {
        breakpoints: {
            lg: 3,
            md: 3,
            sm: 3,
            xs: 2,
            xxs: 1
        },
        centerPadding: '30px',
        initialSlide: 0
    };

    function factory(el) {
        var $elem = jQuery(el);
        var opts = (function () {
            var o = $elem.attr('data-opts');

            if (o) {
                try {
                    var oJson = JSON.parse(o);
                    return oJson;
                } catch(e) {
                    console.error(e);
                }
            }

            return {};
        })();

        var cards = $elem.find('[data-carousel="card"]');
        return {
            elem: el,
            $elem: $elem,
            opts: jQuery.extend({}, defaults, opts),
            cards: cards,
            active: false
        };
    }

    var constructor = function () {

        jQuery(window).on('break', this.build.bind(this));

        jQuery(document).ready(function() {
            var widgets = jQuery('[data-widget="carousel"]');

            jQuery.each(widgets, function(idx, elem) {
                carousels.push(factory(elem));
            });

            this.build();

            jQuery('.home-page').on('click', '.slick-list', function(e) {
                e.preventDefault();

                var target = jQuery(this);

                var slides = target.find('.slick-slide');
                var slickSize = target.width();
                var clickX = e.offsetX;
                var activeSlides = [];

                var activeSlides = target.find('.slick-active');
                var width = jQuery(activeSlides[0]).width();

                // the minus 1 is to adjust for half sizes;
                var numVisibleSlides = parseInt(slickSize / (width - 1), 10);
                var visibleSlides = activeSlides.splice(0, numVisibleSlides);

                if (visibleSlides.length && visibleSlides.length === 1) {
                    var anchors = target.find('.slick-current').find('a');
                    if (anchors.length) window.location.href = anchors[0].href;
                } else if (visibleSlides.length > 1) {
                    var size = slickSize/visibleSlides.length;
                    var quadrant = 1;

                    do {
                        if (e.offsetX <= size * quadrant) break;
                        quadrant++;
                    } while (quadrant <= visibleSlides.length);

                    var anchors = jQuery(visibleSlides[quadrant - 1]).find('a');
                    if (anchors.length) window.location.href = anchors[0].href;
                }
            });

            jQuery(".single").on("click", '.slick-list', function(e) {
                e.preventDefault();
                var target = jQuery(this);

                var slides = target.find('.slick-slide');
                var slickSize = target.width();
                var clickX = e.offsetX;

                var activeSlides = target.find('.slick-active');
                var width = jQuery(activeSlides[0]).width();

                // the minus 1 is to adjust for half sizes;
                var numVisibleSlides = parseInt(slickSize / (width - 1), 10);
                var visibleSlides = activeSlides.splice(0, numVisibleSlides);

                if (visibleSlides.length === 1) {
                    var variant = target.find('.slick-current').find('.modal-image');
                    if (variant.length) showModalImage.apply(variant[0], arguments);
                } else if (visibleSlides.length > 1) {
                    var size = slickSize/visibleSlides.length;
                    var quadrant = 1;

                    do {
                        if (e.offsetX <= size * quadrant) break;
                        quadrant++;
                    } while (quadrant <= visibleSlides.length);

                    var variant = jQuery(visibleSlides[quadrant - 1]).find('.modal-image');
                    if (variant.length) showModalImage.apply(variant[0], arguments);
                }
            });
        }.bind(this));

        return this;
    }

    this.find = function(elem) {
        if (!elem) return null;
        for (var i = 0, l = carousels.length; i < l; i++) {
            if (carousels[i].elem === elem) return carousels[i];
        }
    }

    this.make = function(elem, opts, obj) {
        var carousel = obj;
        if (!carousel) {
            carousel = this.find(elem);

            if (!carousel) { // non existant carousel;

            }
        }

        if (carousel.active) return;

        var $elem = carousel.$elem;

        // Mark mommy as slicked;
        $elem.parent().addClass('slicked');

        // Disable bootstrap columns on the cards;
        carousel.cards.attr('class', function(i, c) {
            return c.replace(/(^|\s)(col-(xs|sm|md|lg)-\S+)/g, '$1disable-$2');
        });

        $elem.slick({
            centerMode: true,
            centerPadding: carousel.opts.centerPadding,
            focusOnSelect: false,
            initialSlide: 0,
            lazyLoad: 'ondemand',
            nextArrow: "<button class='btn btn-info products-carousel-right'><i class='fa fa-chevron-right'></i>",
            prevArrow: "<button class='btn btn-info products-carousel-left'><i class='fa fa-chevron-left'></i>",
            slidesToShow:3,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: (function() {
                        if (carousel.cards.length <= 3 ||
                            carousel.opts.breakpoints.lg === null) return 'unslick';
                        else return {
                            slidesToShow: carousel.opts.breakpoints.lg
                        }
                    })()
                },
                {
                    breakpoint: 992,
                    settings: (function() {
                        if (carousel.cards.length <= 3 ||
                            carousel.opts.breakpoints.md === null) return 'unslick';
                        else return {
                            slidesToShow: carousel.opts.breakpoints.md
                        }
                    })()
                },
                {
                    breakpoint: 768,
                    settings: (function() {
                        if (carousel.cards.length <= 3 ||
                            carousel.opts.breakpoints.sm === null) return 'unslick';
                        else return {
                            slidesToShow: carousel.opts.breakpoints.sm
                        }
                    })()
                },
                {
                    breakpoint: 767,
                    settings: (function() {
                        if (carousel.cards.length <= 2 ||
                            carousel.opts.breakpoints.xs === null) return 'unslick';
                        else return {
                            slidesToShow: carousel.opts.breakpoints.xs
                        }
                    })()
                },
                {
                    breakpoint: 480,
                    settings: (function() {
                        if (carousel.cards.length <= 1 ||
                            carousel.opts.breakpoints.xxs === null) return 'unslick';
                        else return {
                            slidesToShow: carousel.opts.breakpoints.xxs
                        }
                    })()
                }
            ]
        });
        carousel.active = true;
    }

    this.unmake = function(elem, obj) {
        var carousel = obj;
        if (!carousel) {
            carousel = this.find(elem);

            if (!carousel) return null;
        }

        if (!carousel.active) return;

        var $elem = carousel.$elem;

        $elem.parent().removeClass('slicked');

        carousel.cards.attr('class', function(i, c) {
            return c.replace(/(^|\s)disable-(col-(xs|sm|md|lg)-\S+)/g, '$1$2');
        });

        $elem.slick("unslick");
        carousel.active = false;
    }

    this.build = function () {
        currentBreakpoint = breakpoint.get();

        for (var i = 0, l = carousels.length; i < l; i++) {
            var carousel = carousels[i];
            var threshold = carousel.opts.breakpoints[currentBreakpoint];

            if (threshold === null) {
                this.unmake(carousel.elem, carousel);
                continue;
            }

            if (carousel.cards.length > threshold && !carousel.active) { // make a slick;
                this.make(carousel.elem, carousel.opts, carousel);
                continue;
            }

            if (carousel.cards.length <= threshold && carousel.active) { // unmake a slick;
                this.unmake(carousel.elem, carousel);
            }

        }
    };

    return constructor.call(this);
}

jQuery(document).ready(function() {
    // Stuff to do when document is ready;

    // If any read more components are on the page;
    jQuery('.read-more-details').on('click', function(e){
        e.preventDefault();

        var trigger = jQuery(this),
            expander = jQuery("#" + jQuery(this).data('expand')),
            expanded = expander.data('collapsed'),
            collapsedText = jQuery(this).data('collapsed-content') || 'see more details <i class="fa fa-chevron-down"></i>',
            expandedText = jQuery(this).data('expanded-content') || 'hide details <i class="fa fa-chevron-up"></i>',
            interContainer = jQuery(this).data('inter-container') || '.more-details-list',
            height = jQuery(this).data('closed-height') || '10em';

        if (expanded) {
            var height = expander.find(interContainer).height();
            expander.animate({
                height: height,
            }, 500, function() {
                expander.data('collapsed', false);
                trigger.html(expandedText);
            })
        } else {
            expander.animate({
                height: height,
            }, 500, function() {
                expander.data('collapsed', true);
                trigger.html(collapsedText);
            })
        }
    });

    var navTop = jQuery(".navbar-fixed-top").offset().top;

    var stickyNav = function(){
        if (jQuery(window).scrollTop() > navTop){
            jQuery(".navbar-fixed-top").addClass("sticky");
        } else {
            jQuery(".navbar-fixed-top").removeClass("sticky");
        }
    };

    stickyNav();

    jQuery(window).scroll(function(){
        stickyNav();
    });


    // Setting it so the bigger image pops up in a modal;
    jQuery(".modal-image").on("click", showModalImage);

    jQuery('[data-target="modal"]').on('click', function(e) {
        e.preventDefault();
        $.when($.ajax({
            url: jQuery(this).attr('href')
        })).done(
            $.proxy(function(data){
                jQuery('.modal-title').html(jQuery(this).attr('title'));
                jQuery('.modal-body').html(data);
                jQuery('.modal').modal('show');
            }, this)
        )
    });

    jQuery('[data-type="modal"]').on('click', function(e) {
        e.preventDefault();
        var target = this.getAttribute('data-modal-target');
        var modalContent = document.getElementById(target);

        if (modalContent) {
            jQuery('.modal-body').html(jQuery(modalContent).clone()); // here asign the image to the modal when the user click the enlarge link
            jQuery('.modal-title').html(jQuery(this).attr('title'));
            jQuery('.modal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        }
    });

    var offCanvasWidget = function(container) {
        var defaultHeight,
            container           = jQuery(container),
            offCanvasContainer  = container.find('.sidebar-offcanvas'),
            backButton          = container.find('.product-option-close'),
            menu                = container.find(".list-group");
            isBuilt             = false;
            state               = false;

        jQuery(window).on("break", function() {
            init();
        });

        function toggleState() {
            if (state) state = false;
            else state = true;
            return state;
        }

        function init() {
            var activeIndex = parseInt(container.attr('data-active'), 10);

            if (!isBuilt) {
                jQuery.each(offCanvasContainer.find('section'), function(index) {
                    var title = this.getAttribute('data-title');
                    var guid = this.getAttribute("id");
                    var link = jQuery('<a href="#" class="list-group-item" data-toggle="offcanvas" data-target="' + guid + '">' + title + '</a>');

                    if (index === activeIndex) link.addClass('active');

                    menu.append(link);
                    isBuilt = true;
                });
            }

            var bp = breakpoint.get();
            if (bp === "lg" || bp === "md") {
                if (jQuery(container).find(".list-group-item.active").length == 0) handlePanel(jQuery(container).find(".list-group-item").get(0));
                else handlePanel(jQuery(container).find(".list-group-item.active").get(0));
            }
        }

        function swapActiveMenu(el) {
            container.find('.list-group-item').removeClass('active');
            if (el) jQuery(el).addClass('active');
        }

        function swapActivePanels(panel) {
            container.find('.product-options-panels .product-option').removeClass('active');
            if (panel) panel.addClass('active');
            if (container.id == 'jumbotron-more-details') {
                canvasHeight = offCanvasContainer.height();
                (canvasHeight >= defaultHeight)? container.parent().css('height',canvasHeight):container.parent().css('height',defaultHeight);
            }
        }

        function handlePanel(e) {
            var el              = e.target || e,
                id              = jQuery(el).data("target"),
                panel           = jQuery('#'+id),
                currentState    = toggleState(),
                isMobile        = ((/lg|md/.test(breakpoint.get()))? false: true),
                canvasHeight;

            if (e.preventDefault) e.preventDefault();

            backButton.data('target',id);
            swapActiveMenu(el);
            // if (!panel) swapActivePanels();

            if (!isMobile) {
                swapActivePanels(panel);
            } else {
                panel.toggleClass('active');

                canvasHeight = offCanvasContainer.height();

                (canvasHeight > defaultHeight)? container.css('height',canvasHeight):container.css('height',defaultHeight);

                jQuery('.row-offcanvas').toggleClass('active');

            }

        }

        jQuery(container).on('click', '[data-toggle="offcanvas"]', handlePanel);

        init();

        defaultHeight = container.height();

    };

    // Handle Off Canvas Elements
    jQuery.each(jQuery('.row-offcanvas'), function(index, element) {
        new offCanvasWidget(element);
    });
});

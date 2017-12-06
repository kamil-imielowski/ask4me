/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 * 
 * classie.has(elem, 'my-class') -> true/false
 * classie.add(elem, 'my-new-class')
 * classie.remove(elem, 'my-unwanted-class')
 * classie.toggle(elem, 'my-class')
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

(function (window) {

    'use strict';

    // class helper functions from bonzo https://github.com/ded/bonzo

    function classReg(className) {
        return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
    }

    // classList support for class management
    // altho to be fair, the api sucks because it won't accept multiple classes at once
    var hasClass, addClass, removeClass;

    if ('classList' in document.documentElement) {
        hasClass = function (elem, c) {
            return elem.classList.contains(c);
      };
      addClass = function (elem, c) {
        elem.classList.add(c);
      };
      removeClass = function (elem, c) {
        elem.classList.remove(c);
      };
    } else {
        hasClass = function (elem, c) {
            return classReg(c).test(elem.className);
        };
      
        addClass = function (elem, c) {
            if (!hasClass(elem, c)) {
                elem.className = elem.className + ' ' + c;
            }
        };
        
        removeClass = function (elem, c) {
            elem.className = elem.className.replace(classReg(c), ' ');
        };
    }

    function toggleClass(elem, c) {
      var fn = hasClass(elem, c) ? removeClass : addClass;
      fn(elem, c);
    }

    var classie = {
        // full names
        hasClass: hasClass,
        addClass: addClass,
        removeClass: removeClass,
        toggleClass: toggleClass,
        // short names
        has: hasClass,
        add: addClass,
        remove: removeClass,
        toggle: toggleClass
    };

    // transport
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(classie);
    } else {
        // browser global
        window.classie = classie;
    }   
})(window);

//preheader mobile
var 	menuRight = document.getElementById( 'cbp-spmenu-s2' ),
		showRightPush = document.getElementById( 'showRightPush' ),
		body = document.body;

showRightPush.onclick = function() {
	classie.toggle( this, 'active' );
	classie.toggle( body, 'cbp-spmenu-push-toleft' );
	classie.toggle( menuRight, 'cbp-spmenu-open' );
};

//page loader
$(document).ready(function () {
	// Animate loader off screen
	$(".se-pre-con").fadeOut("fast");
});

//scroll top
$(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
        $('.totop').fadeIn();
    } else {
        $('.totop').fadeOut();
    }
});

//smooth scrolling
$('a.smoothscroll').click(function (event) {
    if (
        location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '')
        && location.hostname === this.hostname
   ) {
    var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
            event.preventDefault();
            $('html, body').animate({
            scrollTop: target.offset().top
        }, 1000, function () {
            var $target = $(target);
                $target.focus();
                if ($target.is(":focus")) { // Checking if the target was focused
                    return false;
                } else {
                    $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                    $target.focus(); // Set focus again
                }
            });
        }
    }
});

(function() {
    [].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {	
        new SelectFx(el);
    } );
})();

//slick slider 
$(document).ready(function(){
    $('.profiles').slick({
      dots: true,
      infinite: true,
      speed: 1400,
      slidesToShow: 7,
      slidesToScroll: 7,
      responsive: [
        {
          breakpoint: 1600,
          settings: {
            slidesToShow: 6,
            slidesToScroll: 6,
            speed: 1200,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 1440,
          settings: {
            slidesToShow: 5,
            slidesToScroll: 5,
            speed: 1000,
          }
        },
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
            speed: 800,
          }
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            speed: 600,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            speed: 400,
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1, 
            speed: 200,
            dots: false
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
});

//follow unfollow
$('.follow').on('click', function() {
      $(this).toggleClass("unfollow heartbeat");
    });

//add/remove wishlist
$('.wishlist').on('click', function() {
      $(this).toggleClass("remove star-pulse");
    });


$(document).ready(function () {
    $('.box').addClass('animated fadeIn');
    $('.item').addClass('animated fadeIn');
    $('.cs-options').addClass('mCustomScrollbar');
});

/*//same height chat and video - model room
$(window).resize(function(){
    if($(window).width() > 990) {
        var height = $('#video-player').height() - $("#chat-input").height() - 20
       $('#chat-content').height(height);
    }
});
    
$(window).resize();

//same height chat and video - user-list 
$(window).resize(function(){
    if($(window).width() > 990) {
        var height = $('#video-player2').height() - $(".chat-nav").height() - 15
       $('.user-list').height(height);
    }
});

$(window).resize();

//same height chat and video - broadcast 
$(window).resize(function(){
    if($(window).width() > 990) {
        var height = $('#video-player2').height() - $(".chat-nav").height() - $(".type-message").height() - 15
       $('.messages').height(height);
    }
});

$(window).resize();

//same height chat and video - broadcast private
$(window).resize(function(){
    if($(window).width() > 990) {
        var height = $('#video-player2').height() - $(".chat-nav").height() - $(".type-message").height() - $("#user-nav").height() - 55
       $('.messages2').height(height);
    }
});

$(window).resize();
*/

//expand chat window
$(document.body).on("click", '.expand', function () {
   $(this).closest(".item").toggleClass("expanded"); 
   $(this).closest(".item").removeClass("unread");
});

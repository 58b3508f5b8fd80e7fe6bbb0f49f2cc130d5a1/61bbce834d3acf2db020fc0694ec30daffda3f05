/*
|--------------------------------------------------------------------------
| Page loader
|--------------------------------------------------------------------------
*/
$(window).load(function() {
	$('#loader').delay(400).fadeOut(800);
});

/*
|--------------------------------------------------------------------------
| Countdown
|--------------------------------------------------------------------------
*/
$('#counter').countdown($('#counter').text()).on('update.countdown', function(event) {
	var $this = $(this).html(event.strftime(
	'<span id="days"><strong>%D</strong> Days</span>'
	+ '<span class="sep"></span>'
	+ '<span id="hours"><strong>%H</strong> Hours</span>'
	+ '<span class="sep"></span>'
	+ '<span id="minutes"><strong>%M</strong> Minutes</span>'
	+ '<span class="sep"></span>'
	+ '<span id="seconds"><strong>%S</strong> Seconds</span>'
	));
});

/*
|--------------------------------------------------------------------------
| Subscribe Form
|--------------------------------------------------------------------------
*/
$('#subscribe-btn > a,#close-popup > a').click(function(e) {
	e.preventDefault();
	$('.page-content').toggleClass('hidden');
	$('#subscribe').toggleClass('visible');	
});
var subscribeForm = $('#subscribe-form'),
    subscribeMessage = $('#subscribe-message');
subscribeForm.on('submit', function(e) {
		e.preventDefault();
		var email = $('#subscribe-email'),
		    sformAction = $(this).attr('action');
		post_data = {'userEmail':email.val()};
            $.post(sformAction, post_data, function(data){
                if(data.type == 'error')
                {
                    output = '<div class="fa-times-circle error"> '+data.text+'</div>';
                }else{
                
                    output = '<div class="fa-check-circle success"> '+data.text+'</div>';
                    $('input,textarea',subscribeForm).val(''); 
                }
                
                subscribeMessage.html(output).addClass('visible');
        }, 'json');
});

$('#subscribe-email').keyup(function() {
			subscribeMessage.removeClass('visible');
});
/*
|--------------------------------------------------------------------------
| Carousel
|--------------------------------------------------------------------------
*/
var sync1 = $("#sync1");
var sync2 = $("#sync2");

sync1.owlCarousel({
 singleItem : true,
 slideSpeed : 1000,
 navigation: false,
 pagination:false,
 afterAction : syncPosition,
 responsiveRefreshRate : 200
});

sync2.owlCarousel({
 itemsDesktop			: [1199,10],
 itemsDesktopSmall		: [979,10],
 itemsTablet			: [768,8],
 itemsMobile			: [479,4],
 pagination				: false,
 responsiveRefreshRate	: 100,
 afterInit : function(el){
  el.find(".owl-item").eq(0).addClass("synced");
 }
});

function syncPosition(el){
 var current = this.currentItem;
 $("#sync2")
 .find(".owl-item")
 .removeClass("synced")
 .eq(current)
 .addClass("synced")
 if($("#sync2").data("owlCarousel") !== undefined){
  center(current)
 }
}

$("#sync2").on("click", ".owl-item", function(e){
 e.preventDefault();
 var number = $(this).data("owlItem");
 sync1.trigger("owl.goTo",number);
});

function center(number){
 var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
 var num = number;
 var found = false;
 for(var i in sync2visible){
  if(num === sync2visible[i]){
   var found = true;
  }
 }

 if(found===false){
  if(num>sync2visible[sync2visible.length-1]){
   sync2.trigger("owl.goTo", num - sync2visible.length+2)
  }else{
   if(num - 1 === -1){
    num = 0;
   }
   sync2.trigger("owl.goTo", num);
  }
 } else if(num === sync2visible[sync2visible.length-1]){
  sync2.trigger("owl.goTo", sync2visible[1])
 } else if(num === sync2visible[0]){
  sync2.trigger("owl.goTo", num-1)
 }
}

/*
|--------------------------------------------------------------------------
| Contact Form
|--------------------------------------------------------------------------
*/
var contactForm = $('#contact-form'),
    contactMessage = $('#contact-message');
contactForm.on('submit', function(e) {
		e.preventDefault();
		var requiredFields      = $(this).find('.required'),
		    user_name           = $('#user-name'),
		    user_email          = $('#user-email'),
		    user_message        = $('#user-message'),
		    formAction          = $(this).attr('action');
		requiredFields.each(function() {
					if($(this).val() == "" ) {
						$(this).addClass('input-error');
					} else {
						$(this).removeClass('input-error');
					}
		});
		function validateEmail(email) { 
					var exp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					return exp.test(email);
		}
		
		if( !validateEmail(user_email.val()) ) {
			user_email.addClass('input-error');
		}
		
		
        if ($(':input',contactForm).hasClass('input-error')) {
					return false;
		} else {
            post_data = {'userName':user_name.val(), 'userEmail':user_email.val(), 'userMessage':user_message.val()};
            $.post(formAction, post_data, function(data){
                if(data.type == 'error')
                {
                    output = '<div class="fa-times-circle error"> '+data.text+'</div>';
                }else{
                
                    output = '<div class="fa-check-circle success"> '+data.text+'</div>';
                    $('input,textarea',contactForm).val(''); 
                }
                
                contactMessage.html(output).addClass('visible');
            }, 'json');
            
        }
});

$('input,textarea',contactForm).keyup(function() { 
        $(this).removeClass('input-error');
		if (!$(':input',contactForm).hasClass('input-error')) {
			contactMessage.removeClass('visible');
		}
});
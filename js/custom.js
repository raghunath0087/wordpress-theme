/*
 * MOBILE DEVICE TOUCH MENU 
 */
$ = jQuery; 
$(document).ready(function(jQuery) { 
	jQuery(function($) {
		jQuery(document).bind('touchstart', function(e) {                
			if (jQuery(e.target).is('a')) {
					//code goes here
				//$(".parent > a").removeClass('hover');
				} else {
					jQuery(".parent > a").removeClass('hover');
				}	
		});
		jQuery('.parent > a').on("touchstart", function (e) {
			'use strict'; //satisfy code inspectors
			var link = $(this); //preselect the link
			if (link.hasClass('hover')) {
				return true;
			} else {
				link.addClass('hover');
				jQuery('.parent > a').not(this).removeClass('hover');
				e.preventDefault();
				return false; //extra, and to make sure the function has consistent return points
			}
		});
	});
});
/*
 * MAGNIFY POP CODE
 */
$(document).ready(function(){
			$('body').magnificPopup({
			  delegate: 'a.video',
			  type: 'iframe',
			  closeOnContentClick: false,
			  closeBtnInside: true,
			  removalDelay: 300,
			  mainClass: 'mfp-with-zoom mfp-img-mobile my-mfp-slide-bottom',
			  iframe: {
				 markup: '<div class="mfp-iframe-scaler">'+
							'<div class="mfp-close"></div>'+
							'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
							'<div class="mfp-title"></div>'+
						  '</div>'
				}
	});
	/*
	$('.video').magnificPopup({
		type: 'ajax',	
		disableOn:319,
		iframe: {
		 markup: '<div class="mfp-iframe-scaler">'+
					'<div class="mfp-close"></div>'+
					'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
					'<div class="mfp-title"></div>'+
				  '</div>'
		},
		callbacks: {
			markupParse: function(template, values, item) {
				values.title = item.el.attr('title');
			}
		}
	});*/
	$('.image-link').magnificPopup({
		type: 'image',
		iframe: {
		 markup: '<div class="mfp-iframe-scaler">'+
					'<div class="mfp-close"></div>'+
					'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
					'<div class="mfp-title"></div>'+
				  '</div>'
		},
		callbacks: {
		markupParse: function(template, values, item) {
		 values.title = item.el.attr('title');
		}
		}
	});
});
/*
 * STICKY HEADER 
 */
$(document).ready(function(e) {
    var s = (e(window), e("body")),
        a = e("header"),
        l = (a.outerHeight(!0), e("nav"));
    e(window).scroll(function() { 
        e(this).scrollTop() > 38 ? e(".header").addClass("sticky") : e(".header").removeClass("sticky")
    });
	e(this).scrollTop() > 38 ? e(".header").addClass("sticky") : e(".header").removeClass("sticky")
    var i = e("#menu-toggle"),
        n = l.children("ul"),
        r = n.children("li:has(ul.sub-menu)"),
        d = e("ul.sub-menu"),
        t = d.children("li:has(ul.sub-menu)").children("a");
    r.addClass("parent").children("a").append(), t.addClass("parent"), i.click(function() {
        return n.slideToggle(200), e(this).children("i").toggleClass("active"), !1
    }), e(window).resize(function() {
        s.hasClass("mobile") || (n.removeAttr("style"), i.children("i").removeClass("active"))
    }), l.find(".menu-item").last("li").addClass("last")
});
/*
 * SCROLL TOP 
 */ 	
$(document).ready(function(){
	//Check to see if the window is top if not then display button
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollToTop').fadeIn();
		} else {
			$('.scrollToTop').fadeOut();
		}
	});
	//Click event to scroll to top
	$('.scrollToTop').click(function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	});
});

/*
 * Modal Window on Leave Page  
 */
 /*
var span = document.createElement("div");
span.innerHTML = "Check our Free trial page before leaving the website";
document.body.insertBefore(span, document.body.firstChild);
var shownLeaveMsg = false;
document.addEventListener("mousemove", function(e) { 
    if(e.clientY < 5 && !shownLeaveMsg) {
		shownLeaveMsg = true;
		span.style.display = 'block';
	}
});*/

/*
 * ANIMATION EFFECTS
 */
new WOW().init(); 

/* contact for mvalidation 3May2016*/

function e_validate(email) 
{
 var emailRegex = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
 //var emailRegex = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
 var emailAddress = email;
var valid = emailRegex.test(emailAddress);
if (!valid) {
return false;
} else
return true;
}
function e_validateName(name) 
{
 var nameRegex = new RegExp(/^[A-Za-z! @#%^&*"(')_+<>?:{}|()\/-]+$/);
 var NameReg = name;
var valid = nameRegex.test(NameReg);
if (!valid) {
return false;
} else{
return true;}
}

$(document).ready(function(){
$('#ve_blog_form').on('submit', function(e)
		{
                 var $fname=$('#fname').val();
                 var $lname=$('#lname').val();
				 var $email=$('#email').val();
                 var $placeholderfname=$('#fname').attr('placeholder');
                 var $placeholderlname=$('#lname').attr('placeholder');
				 var $newsletter=$('#blog_newsletter').val();
				 var $formtype=$('#form_type').val();
    			 var $name=$fname +' '+ $lname;
    			$('.msgstatus').html('');
				
			if($email==''){
					  $('#email').val("");
					  $('#email-msg').html('<div id="error-msg">Please enter Email</div>');
					  $('#email').focus();$('#email').css("border","1px solid red");
					 return false;
			}
	        else if(!e_validate($email)) 
	          {
					$('#email').val("");
					$('#email-msg').html('<div id="error-msg">Please enter valid Email</div>');
					$('#email').focus();$('#email').css("border","1px solid red");
					return false;
				}else
				{
					$('#email').css("border","none");
				}
			
				if($fname=='' || $fname==$placeholderfname)
				{
					$('#fname').val("");
					$('#fname-msg').html('<span role="alert" class="wpcf7-not-valid-tip">The field is required.</span>');
					$('#fname').focus();$('#fname').css("border","1px solid red");
				return false;
				}else{
				  if(!e_validateName($fname)){
					$('#fname').val("");
					$('#fname-msg').html('<span role="alert" class="wpcf7-not-valid-tip">Please enter valid first name</span>');
					$('#fname').focus();$('#fname').css("border","1px solid red");
				return false;
				   }else{
					   $('#fname').focus();$('#fname').css("border","none");
				   }
				}
				
				/*if($lname=='' || $lname==$placeholderlname)
				{
					$('#lname').val("");
					$('#lname-msg').html('<span role="alert" class="wpcf7-not-valid-tip">The field is required.</span>');
					$('#lname').focus();$('#lname').css("border","1px solid red");
				return false;
				}else{
				  if(!e_validateName($fname)){
					$('#lname').val("");
					$('#lname-msg').html('<span role="alert" class="wpcf7-not-valid-tip">Please enter valid  last name</span>');
					$('#lname').focus();$('#lname').css("border","1px solid red");
				return false;
				   }else{
					   $('#lname').focus();$('#lname').css("border","none");
				   }
				}*/
				$.ajax({    
						'type':'POST',
						'url':'http://www.virtualemployee.com/ajax_new_contactus.php',
						'data':'name='+$name+'&email='+$email+'&form_type='+$formtype+'&message='+$newsletter,
						success:function(msg)
							{
								if(msg == '1' || msg == 1) 
								{
									window.location.href ="/thanks";
								} else {
									$('#blogformresposnse').html('<div id="error-msg">Mail delivery failed!. <a href="skype:narinderve?call">Click here</a> to skype call.</div>');
									$('#ve_blog_form').css('opacity','1');
									console.log("There was some error while submitting your query, please try again. ");
								}		
										
							}
					});
				
				
		e.preventDefault();		

});
});

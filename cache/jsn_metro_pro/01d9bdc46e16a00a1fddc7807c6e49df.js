/* FILE: /components/com_k2/js/k2.js */
/**
 * @version		$Id: k2.js 1987 2013-06-27 11:51:59Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

var $K2 = jQuery.noConflict();

$K2(document).ready(function(){

  // Generic function to get URL params passed in .js script include
	function getUrlParams(targetScript, varName) {
		var scripts = document.getElementsByTagName('script');
		var scriptCount = scripts.length;
		for (var a = 0; a < scriptCount; a++) {
			var scriptSrc = scripts[a].src;
			if (scriptSrc.indexOf(targetScript) >= 0) {
				varName = varName.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
				var re = new RegExp("[\\?&]" + varName + "=([^&#]*)");
				var parsedVariables = re.exec(scriptSrc);
				if (parsedVariables !== null) {
					return parsedVariables[1];
				}
			}
		}
	}

	// Set the site root path
	var K2SitePath = getUrlParams('k2.js', 'sitepath');

	// Comments
	$K2('#comment-form').submit(function(event){
		event.preventDefault();
		$K2('#formLog').empty().addClass('formLogLoading');
		$K2.ajax({
			url: $K2('#comment-form').attr('action'),
			type: 'post',
			dataType: 'json',
			data: $K2('#comment-form').serialize(),
			success: function(response){
				$K2('#formLog').removeClass('formLogLoading').html(response.message);
				if(typeof(Recaptcha) != "undefined"){
					Recaptcha.reload();
				}
				if (response.refresh) {
					window.location.reload();
				}
			}
		});
	});

	$K2('.commentRemoveLink').click(function(event){
		event.preventDefault();
		var element = $K2(this);
		$K2(element).parent().addClass('commentToolbarLoading');
		$K2.ajax({
			url: $K2(element).attr('href'),
			type: 'post',
			data: $K2('#comment-form input:last').serialize(),
			success: function(response){
				$K2(element).parent().removeClass('commentToolbarLoading');
				if(response=='true'){
					$K2(element).parent().parent().remove();
				}
			}
		});
	});

	$K2('.commentApproveLink').click(function(event){
		event.preventDefault();
		var element = $K2(this);
		$K2(element).parent().addClass('commentToolbarLoading');
		$K2.ajax({
			url: $K2(element).attr('href'),
			type: 'post',
			data: $K2('#comment-form input:last').serialize(),
			success: function(response){
				$K2(element).parent().removeClass('commentToolbarLoading');
				if(response=='true'){
					$K2(element).parent().parent().removeClass('unpublishedComment');
				}
			}
		});
	});

	$K2('.k2ReportUserButton').click(function(event){
		event.preventDefault();
		if (confirm(K2Language[0])) {
			var element = $K2(this);
			$K2(element).parent().addClass('commentToolbarLoading');
			$K2.ajax({
				url: $K2(element).attr('href'),
				type: 'GET',
				success: function(response){
					$K2(element).parent().removeClass('commentToolbarLoading');
					alert(response);
				}
			});
		}

	});

	$K2('#k2ReportCommentForm').submit(function(event){
		event.preventDefault();
		$K2('#formLog').empty().addClass('formLogLoading');
		$K2.ajax({
			url: $K2('#k2ReportCommentForm').attr('action'),
			type: 'post',
			data: $K2('#k2ReportCommentForm').serialize(),
			success: function(response){
				$K2('#formLog').removeClass('formLogLoading').html(response);
				if(typeof(Recaptcha) != "undefined"){
					Recaptcha.reload();
				}
			}
		});
	});

	// Text Resizer
	$K2('#fontDecrease').click(function(event){
		event.preventDefault();
		$K2('.itemFullText').removeClass('largerFontSize');
		$K2('.itemFullText').addClass('smallerFontSize');
	});
	$K2('#fontIncrease').click(function(event){
		event.preventDefault();
		$K2('.itemFullText').removeClass('smallerFontSize');
		$K2('.itemFullText').addClass('largerFontSize');
	});

	// Smooth Scroll
	$K2('.k2Anchor').click(function(event){
		event.preventDefault();
		var target = this.hash;
		$K2('html, body').stop().animate({
			scrollTop: $K2(target).offset().top
		}, 500);
	});

	// Rating
	$K2('.itemRatingForm a').click(function(event){
		event.preventDefault();
		var itemID = $K2(this).attr('rel');
		var log = $K2('#itemRatingLog' + itemID).empty().addClass('formLogLoading');
		var rating = $K2(this).html();
		$K2.ajax({
			url: K2SitePath+"index.php?option=com_k2&view=item&task=vote&format=raw&user_rating=" + rating + "&itemID=" + itemID,
			type: 'get',
			success: function(response){
				log.removeClass('formLogLoading');
				log.html(response);
				$K2.ajax({
					url: K2SitePath+"index.php?option=com_k2&view=item&task=getVotesPercentage&format=raw&itemID=" + itemID,
					type: 'get',
					success: function(percentage){
						$K2('#itemCurrentRating' + itemID).css('width', percentage + "%");
						setTimeout(function(){
							$K2.ajax({
								url: K2SitePath+"index.php?option=com_k2&view=item&task=getVotesNum&format=raw&itemID=" + itemID,
								type: 'get',
								success: function(response){
									log.html(response);
								}
							});
						}, 2000);
					}
				});
			}
		});
	});

	// Classic popup
	$K2('.classicPopup').click(function(event){
		event.preventDefault();
		if($K2(this).attr('rel')){
			var json = $K2(this).attr('rel');
			json = json.replace(/'/g, '"');
			var options = $K2.parseJSON(json);
		} else {
			var options = {x:900,y:600}; /* use some default values if not defined */
		}
		window.open($K2(this).attr('href'),'K2PopUpWindow','width='+options.x+',height='+options.y+',menubar=yes,resizable=yes');
	});

	// Live search
	$K2('div.k2LiveSearchBlock form input[name=searchword]').keyup(function(event){
		var parentElement = $K2(this).parent().parent();
		if($K2(this).val().length>3 && event.key!='enter'){
			$K2(this).addClass('k2SearchLoading');
			parentElement.find('.k2LiveSearchResults').css('display','none').empty();
			parentElement.find('input[name=t]').val($K2.now());
			parentElement.find('input[name=format]').val('raw');
			var url = 'index.php?option=com_k2&view=itemlist&task=search&' + parentElement.find('form').serialize();
			parentElement.find('input[name=format]').val('html');
			$K2.ajax({
				url: url,
				type: 'get',
				success: function(response){
					parentElement.find('.k2LiveSearchResults').html(response);
					parentElement.find('input[name=searchword]').removeClass('k2SearchLoading');
					parentElement.find('.k2LiveSearchResults').css('display', 'block');
				}
			});
		} else {
			parentElement.find('.k2LiveSearchResults').css('display','none').empty();
		}
	});

	// Calendar
	if (typeof($K2().live) == "undefined") {
		$K2('.k2CalendarBlock').on('click', '.calendarNavLink', function(event){
			event.preventDefault();
			var parentElement = $K2(this).parent().parent().parent().parent();
			var url = $K2(this).attr('href');
			parentElement.empty().addClass('k2CalendarLoader');
			$K2.ajax({
				url: url,
				type: 'post',
				success: function(response){
					parentElement.html(response);
					parentElement.removeClass('k2CalendarLoader');
				}
			});
		});
	}
	else {
		$K2('a.calendarNavLink').live('click',  function(event){
			event.preventDefault();
			var parentElement = $K2(this).parent().parent().parent().parent();
			var url = $K2(this).attr('href');
			parentElement.empty().addClass('k2CalendarLoader');
			$K2.ajax({
				url: url,
				type: 'post',
				success: function(response){
					parentElement.html(response);
					parentElement.removeClass('k2CalendarLoader');
				}
			});
		});
	}

	// Generic Element Scroller (use .k2Scroller in the container and .k2ScrollerElement for each contained element)
	$K2('.k2Scroller').css('width',($K2('.k2Scroller').find('.k2ScrollerElement:first').outerWidth(true))*$K2('.k2Scroller').children('.k2ScrollerElement').length);

});

// Equal block heights for the "default" view
$K2(window).load(function () {
	var blocks = $K2('.subCategory, .k2EqualHeights');
	var maxHeight = 0;
	blocks.each(function(){
		maxHeight = Math.max(maxHeight, parseInt($K2(this).css('height')));
	});
	blocks.css('height', maxHeight);
});
;


/* FILE: /media/system/js/validate.js */
/*
		GNU General Public License version 2 or later; see LICENSE.txt
*/
Object.append(Browser.Features,{inputemail:function(){var a=document.createElement("input");a.setAttribute("type","email");return a.type!=="text"}()});
var JFormValidator=new Class({initialize:function(){this.handlers={};this.custom={};this.setHandler("username",function(a){regex=/[<|>|"|'|%|;|(|)|&]/i;return!regex.test(a)});this.setHandler("password",function(a){regex=/^\S[\S ]{2,98}\S$/;return regex.test(a)});this.setHandler("numeric",function(a){regex=/^(\d|-)?(\d|,)*\.?\d*$/;return regex.test(a)});this.setHandler("email",function(a){regex=/^[a-zA-Z0-9._-]+(\+[a-zA-Z0-9._-]+)*@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;return regex.test(a)});$$("form.form-validate").each(function(a){this.attachToForm(a)},
this)},setHandler:function(a,b,c){this.handlers[a]={enabled:c==""?!0:c,exec:b}},attachToForm:function(a){a.getElements("input,textarea,select,button").each(function(a){a.hasClass("required")&&(a.set("aria-required","true"),a.set("required","required"));if((document.id(a).get("tag")=="input"||document.id(a).get("tag")=="button")&&document.id(a).get("type")=="submit"){if(a.hasClass("validate"))a.onclick=function(){return document.formvalidator.isValid(this.form)}}else if(a.addEvent("blur",function(){return document.formvalidator.validate(this)}),
a.hasClass("validate-email")&&Browser.Features.inputemail)a.type="email"})},validate:function(a){a=document.id(a);if(a.get("disabled"))return this.handleResponse(!0,a),!0;if(a.hasClass("required"))if(a.get("tag")=="fieldset"&&(a.hasClass("radio")||a.hasClass("checkboxes")))for(var b=0;;b++)if(document.id(a.get("id")+b)){if(document.id(a.get("id")+b).checked)break}else return this.handleResponse(!1,a),!1;else if(!a.get("value"))return this.handleResponse(!1,a),!1;b=a.className&&a.className.search(/validate-([a-zA-Z0-9\_\-]+)/)!=
-1?a.className.match(/validate-([a-zA-Z0-9\_\-]+)/)[1]:"";if(b=="")return this.handleResponse(!0,a),!0;if(b&&b!="none"&&this.handlers[b]&&a.get("value")&&this.handlers[b].exec(a.get("value"))!=!0)return this.handleResponse(!1,a),!1;this.handleResponse(!0,a);return!0},isValid:function(a){for(var b=!0,a=a.getElements("fieldset").concat(Array.from(a.elements)),c=0;c<a.length;c++)this.validate(a[c])==!1&&(b=!1);(new Hash(this.custom)).each(function(a){a.exec()!=!0&&(b=!1)});return b},handleResponse:function(a,
b){b.labelref||$$("label").each(function(a){if(a.get("for")==b.get("id"))b.labelref=a});a==!1?(b.addClass("invalid"),b.set("aria-invalid","true"),b.labelref&&(document.id(b.labelref).addClass("invalid"),document.id(b.labelref).set("aria-invalid","true"))):(b.removeClass("invalid"),b.set("aria-invalid","false"),b.labelref&&(document.id(b.labelref).removeClass("invalid"),document.id(b.labelref).set("aria-invalid","false")))}});document.formvalidator=null;
window.addEvent("domready",function(){document.formvalidator=new JFormValidator});;

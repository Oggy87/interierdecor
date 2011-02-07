/**
 * AJAX Nette Framework plugin for jQuery
 *
 * @copyright   Copyright (c) 2009 Jan Marek
 * @license     MIT
 * @link        http://addons.nettephp.com/cs/jquery-ajax
 * @version     0.2
 */

jQuery.extend({
    nette: {
        updateSnippet: function (id, html) {
            $("#" + id).html(html);
        },

        success: function (payload) {
            // redirect
            if (payload.redirect) {
                window.location.href = payload.redirect;
                return;
            }

            // snippets
            if (payload.snippets) {
                for (var i in payload.snippets) {
                    jQuery.nette.updateSnippet(i, payload.snippets[i]);
                }
            }
        },
	// create animated spinner
	createSpinner: function(id)
	{
		return this.spinner = $('<div></div>').attr('id', id ? id : 'ajax-spinner').ajaxStart(function() {
			$(this).show();
		}).ajaxStop(function() {
			$(this).hide().css({
				position: 'fixed',
				left: '50%',
				top: '50%'
			});
		}).appendTo('body').hide();
	},

        // spinner element
        spinner: null
    }
});

jQuery(function($) {
	
	$.ajaxSetup({
		success: $.nette.success,
		dataType: 'json'
	});

        $.nette.createSpinner();
	
	/* Volání AJAXu u všech odkazů s třídou ajax */
	// apply AJAX unobtrusive way
	$("a.ajax, .ajaxPaginator a").live("click", function (event) {
	    event.preventDefault();
	    $.get(this.href);

	    $.nette.spinner.css({
			position: 'absolute',
			left: event.pageX, 
			top: event.pageY
            });
	});

	/* AJAXové odeslání formulářů */
	$("form.ajax").live("submit", function () {
	    $(this).ajaxSubmit();
	    return false;

            $.nette.spinner.css({
			position: 'absolute',
			left: event.pageX,
			top: event.pageY
            });

	});

	$("form.ajax :submit").live("click", function () {
	    $(this).ajaxSubmit();
	    return false;

            $.nette.spinner.css({
			position: 'absolute',
			left: event.pageX,
			top: event.pageY
            });
	});

        // skrývání flash zpráviček
        $("div.flash").livequery(function () {
                var el = $(this);
                setTimeout(function () {
                        el.animate({"opacity": 0}, 2000);
                        el.slideUp();
                }, 7000);
        });

        //ochrana formularu
        $(".nospam").livequery(function () {
            $(this).hide();
            $("input.nospam").val("no" + "spam");
        });


});

/**
 * AJAX form plugin for jQuery
 *
 * @copyright  Copyright (c) 2009 Jan Marek
 * @license    MIT
 * @link       http://nettephp.com/cs/extras/ajax-form
 * @version    0.1
 */

jQuery.fn.extend({
	ajaxSubmit: function (callback) {
		var form;
		var sendValues = {};

		// submit button
		if (this.is(":submit")) {
			form = this.parents("form");
			sendValues[this.attr("name")] = this.val() || "";

		// form
		} else if (this.is("form")) {
			form = this;

		// invalid element, do nothing
		} else {
			return null;
		}

		// validation
		if (form.get(0).onsubmit && !form.get(0).onsubmit()) return null;

		// get values
		var values = form.serializeArray();

		for (var i = 0; i < values.length; i++) {
			var name = values[i].name;

			// multi
			if (name in sendValues) {
				var val = sendValues[name];

				if (!(val instanceof Array)) {
					val = [val];
				}

				val.push(values[i].value);
				sendValues[name] = val;
			} else {
				sendValues[name] = values[i].value;
			}
		}

		// send ajax request
		var ajaxOptions = {
			url: form.attr("action"),
			data: sendValues,
			type: form.attr("method") || "get"
		};

		if (callback) {
			ajaxOptions.success = callback;
		}

		return jQuery.ajax(ajaxOptions);
	}
});

<?php //netteCache[01]000374a:2:{s:4:"time";s:21:"0.10136300 1337170065";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:88:"/var/www/webtoad/interierdecor/app/components/MultiUpload/MultiUploadVisualisation.phtml";i:2;i:1323529215;}i:1;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:10:"checkConst";}i:1;s:19:"Framework::REVISION";i:2;s:30:"9f535f9 released on 2011-01-10";}}}?><?php

// source file: /var/www/webtoad/interierdecor/app/components/MultiUpload/MultiUploadVisualisation.phtml

?><?php
$_l = LatteMacros::initRuntime($template, NULL, '3jpk47gd09'); unset($_extends);

if (isset($presenter, $control) && $presenter->isAjax() && $control->isControlInvalid()) {
	return LatteMacros::renderSnippets($control, $_l, get_defined_vars());
}
?>

<div id="visualisation-image-upload">
    <div id="messag" class="alert-message error">Váš prohlížeč nepodporuje html5, nebude možné nahrát obrázek.</div>
    <a id="pickfile" class="btn" href="javascript:;">nahrát foto</a>

    <div id="filelis"><table class="condensed-table"></table></div>    
</div>

<script type="text/javascript">
head.ready(function() {

$(function(){
	// Setup flash version        
	var uploader = new plupload.Uploader({
		// General settings
		runtimes : 'html5',
                browse_button : 'pickfile',
	        container : 'visualisation-image-upload',
		url : <?php echo TemplateHelpers::escapeJs($control->link("upload")) ?>,
		max_file_size : '100mb',
		chunk_size : '2mb',
		unique_names : true,
                rename: true,
                multi_selection:false,

		filters : [
			{ title : "Image files", extensions : "jpg,JPG,gif,GIF,png,PNG"},
		],

		// Resize images on clientside if we can
		resize : { width : 1200, height : 900, quality : 100},

		// Flash settings
		flash_swf_url : '<?php echo $baseUri ?>/static/js/plupload.flash.swf'
	});

        uploader.bind('Init', function(up, params) {
		$('#messag').remove();
	});

        uploader.init();

        uploader.bind('FilesAdded', function(up, files) {
            $.each(files, function(i, file) {

                if(file.size > uploader.settings.max_file_size) {
                    alert('Soubor je příliš veliký.');
                    uploader.removeFile(file);
                }
                else {
                    $('#filelis > table').append(
                        '<tr id="' + file.id + '">' +
                            '<td class="name">'
                                + file.name +
                            '</td>' +
                            '<td class="size">' +
                                plupload.formatSize(file.size) +
                            '</td>' +
                            '<td class="percent">' +
                                file.percent + "%" +
                            '</td>' +
                            '<td class="stats"><span class="ui-icon"></span> </td>' +
                        '</tr>'
                    );

                    uploader.start();
                }

            });
        });

        uploader.bind('QueueChanged', function(up) {
            if(uploader.files.length>1) {
                $.each(uploader.splice(0,1), function(i, file) {
                    $('#' + file.id).remove();
                });
            }
        });

	uploader.bind('UploadProgress', function(up, file) {
            $('#' + file.id + ' > .percent').html(file.percent + "%");

            if(file.status==plupload.DONE) {
                $('#' + file.id + ' > .percent').html("100%")
            }
	});

        uploader.bind("FileUploaded",function(up, file) {
            if(file.status==plupload.DONE) {
                if(file.target_name) {

                    $("[name='tmpname']").val(plupload.xmlEncode(file.target_name));
                    //$('#container').append('<input type="hidden" name="video[tmpname]" value="'+plupload.xmlEncode(file.target_name)+'" />')

                    $.get(<?php echo TemplateHelpers::escapeJs($presenter->link("visualThumb!")) ?>, {'tmpname': plupload.xmlEncode(file.target_name)}, function(payload) {
                            // refresh all snippets
                            for(var id in payload.snippets) {
                                jQuery.nette.updateSnippet(id, payload.snippets[id]);
                            }
                    });
                }
                $("[name='name']").val(plupload.xmlEncode(file.name));

                actionClass = 'done ui-icon-circle-check';
            }
            if (file.status == plupload.FAILED) {
                actionClass = 'failed ui-icon-alert';
            }
            if (file.status == plupload.QUEUED) {
                actionClass = 'delete ui-icon-circle-close';
            }
            if (file.status == plupload.UPLOADING) {
                actionClass = 'uploading ui-icon-grip-dotted-horizontal';
            }

            $('#' + file.id + ' > .stats > span').attr('class', 'ui-icon ' + actionClass);
        });

        uploader.bind('UploadProgress', function() {
            $('input[type=submit]', this).attr('disabled', 'disabled');
        });

    });
});
</script>
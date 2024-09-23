jQuery(document).ready(function($) {

    FormList = $('#ecftinymce_select_form');
    var ecf_H = 390;
    var ecf_W = 550;


    // END LOAD MEDIA

    $("body").delegate("#ecf_gut_shorcode-button, #ecficons_gut_shorcode", "click", function() {

        FormList.find('option').remove();
        $("<option/>").val(0).text('Loading...').appendTo(FormList);

        setTimeout(function() {
            tb_show('<img class="ecf_sc_ttl_ico" src="' + ecf_tinymce_vars.sc_icon + '" alt="Easy Contact Form">Shortcode Generator<span class="ecf_cp_version">v' + ecf_tinymce_vars.sc_version + '</span>', '#TB_inline?height=' + ecf_H + '&width=' + ecf_W + '&inlineId=ecfmodal');
            $("#TB_window").addClass("TB_ecf_window").css('z-index', '999999');
            $("#TB_ajaxContent").addClass("TB_ecf_ajaxContent");
            $(".TB_ecf_ajaxContent").css('height', 'auto');
            $("select#ecftinymce_select_form").val("select");
            ecf_H = 390;

            $("#TB_closeWindowButton").replaceWith($("<div class='closetb' id='TB_closeWindowButton'><span class='screen-reader-text'>Close</span><span class='tb-close-icon'></span></div>"));

            grabforms();
            ecftbReposition();


        }, 300);

    });

    // Close Thickbox
    $("body").delegate(".closetb", "click", function() {
        tb_remove();
    });

    // add the shortcode to the post editor
    $('#ecf_insert_scrt').on("click", function() {

        if ($("#ecftinymce_select_form").val() != 'select') {

            var sccode;
            sccode = "[easy-contactform id=" + $("#ecftinymce_select_form option:selected").val() + "]";

            if ($('#wp-content-editor-container > textarea').is(':visible')) {
                var val = $('#wp-content-editor-container > textarea').val() + sccode;
                $('#wp-content-editor-container > textarea').val(val);
            } else {
                tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sccode);
            }

            tb_remove();
        } else {
            alert('Please select form first!');
            //tb_remove();
        }
    });

    function grabforms() {

        FormList.find('option').remove();
        $("<option/>").val('select').text('- Select Form -').appendTo(FormList);

        $.each(ecf_tinymce_vars.forms, function(i, option) {
            $("<option/>").val(option.id).text(option.name).appendTo(FormList);
        });

    }

    // Reposition Thickbox
    function ecftbReposition() {

        $('.TB_ecf_window').css({
            'top': (($(window).height() - ecf_H) / 6) + 'px',
            'left': (($(window).width() - ecf_W) / 4) + 'px',
            'margin-top': (($(window).height() - ecf_H) / 6) + 'px',
            'margin-left': (($(window).width() - ecf_W) / 4) + 'px',
            'max-height': parseInt(ecf_H) + 'px',
            'min-height': parseInt(ecf_H) + 'px',
        });

    }

    $(window).resize(function() {

        ecftbReposition();

    });

});
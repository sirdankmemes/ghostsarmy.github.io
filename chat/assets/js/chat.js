window.first = 0;
window.last = 0;
window.skipped_once = false;
window.loading = false;

function isEven(n) {
    return n % 2 == 0;
}

function wrapText(elementID, openTag, closeTag) {
    var textArea = $('#' + elementID);
    var len = textArea.val().length;
    var start = textArea[0].selectionStart;
    var end = textArea[0].selectionEnd;
    var selectedText = textArea.val().substring(start, end);
    var replacement = openTag + selectedText + closeTag;
    textArea.val(textArea.val().substring(0, start) + replacement + textArea.val().substring(end, len));
}


var skrol = document.getElementById("chatdiv");

//JSON MESSAGE LOADER START


function jsonloader() {
    var ajax_url = "load-messages.php?newest=" + window.last;
    if (window.loading == false) {
        window.loading = true;
        $.get(ajax_url, function(data) {
            $.each(data, function(i, single) {
                length = data.length;
                if (single.candel == 1) {
                    var del_ete = "<a href='#' id='" + single.msg_id + "' class='trash label label-danger'>Delete</a> ";
                } else {
                    var del_ete = "";
                }

                if (isEven(single.msg_id)) {
                    var klasa = "even ";
                } else {
                    var klasa = ""
                }
				
				if (single.user_id!=0) {
					var linkic ="profile.php?id=" + single.user_id;
				} else {
					var linkic = "#";
				}

                var poruke = "<div id='" + single.msg_id + "'" + "class='" + klasa + "message'" + ">" + del_ete + " <span class='date-time'>" + single.time + "" + "</span> <a href='" + linkic + "' class='nickname'>" + single.name + "</a>: " + single.message + "</div>"

                if ($("#" + single.msg_id).length == 0) {
                    $("#chatdiv").append(poruke);
                }
                skrol.scrollTop = skrol.scrollHeight - skrol.clientHeight;

                if (window.skipped_once == true) {
                    if (single.name != single.requestername) {
                        document.getElementById('bgAudio').play();
                    }
                }
                //
                window.last = single.msg_id;
                if (window.first == 0) {
                    window.first = window.last
                }
                //
            });
            window.skipped_once = true;
        }).always(function() {
            window.loading = false;
        });
    }
};

jsonloader();

var auto_refresh = setInterval(function() {
    jsonloader();
}, 500);
//JSON MESSAGE LOADER END


//HISTORY LOADER START
function historyloader() {
    var ajax_url = "load-messages.php?first=" + window.first;

    $.get(ajax_url, function(data) {
        window.priprema = "";
        $.each(data, function(i, hsingle) {

            length = data.length;
            if (hsingle.candel == 1) {
                var del_ete = "<a href='#' id='" + hsingle.msg_id + "' class='trash label label-danger'>Delete</a> ";
            } else {
                var del_ete = "";
            }

            if (isEven(hsingle.msg_id)) {
                var klasa = "even ";
            } else {
                var klasa = ""
            }
			
			if (hsingle.user_id!=0) {
					var linkic ="profile.php?id=" + hsingle.user_id;
				} else {
					var linkic = "#";
				}

            var poruke = "<div id='" + hsingle.msg_id + "'" + "class='" + klasa + "message'" + ">" + del_ete + " <span class='date-time'>" + hsingle.time + "" + "</span> <a href='" + linkic + "' class='nickname'>" + hsingle.name + "</a> " + hsingle.message + "</div>"

            if ($("#" + hsingle.msg_id).length == 0) {
                window.priprema = window.priprema + poruke;
            }

            if (parseInt(hsingle.msg_id, 10) < parseInt(window.first, 10)) {
                window.first = hsingle.msg_id
            }
        });

        $("#chatdiv").prepend(window.priprema);
    });
};

//HISTORY LOADER STOP
$('#chatdiv').scroll(function(vazanklik) {
    vazanklik.stopPropagation();
    vazanklik.preventDefault();
    if ($('#chatdiv').scrollTop() == 0) {
        $('#loader').show();
        setTimeout(function() {
            historyloader();
            $('#loader').hide();
            $('#chatdiv').scrollTop(30);
        }, 780);
    }
});


//admin CONTROL CUZ' THEY HAVE POWER :D
//$('.trash').click(function(){ - this part is only for outside div
$(document).on('click', '.trash', function() {
    var del_id = $(this).attr('id');
    var $ele = $(this).parent().parent();
    $.ajax({
        type: 'POST',
        url: 'control.php',
        data: {
            del_id: del_id
        },
        success: function(data) {
            if (data == "YES") {
                $("#" + del_id).remove();
                alert("Message successfully deleted")
            } else {
                alert("Message can't be deleted probably because already deleted. Please refresh page!")
            }
        }
    })
});

function lonline() {
    $("#lonline").load("lonline.php"); //Load the content into the div
}
lonline();
var auto_refresh = setInterval(
    (function() {
        lonline(); //Load the content into the div
    }), 30000);

//inbox hunter
function inboxhunter() {
    $("#inboxhunter").load("inboxhunter.php"); //Load the content into the div
}
inboxhunter();
var auto_refresh = setInterval(
    (function() {
        inboxhunter(); //Load the content into the div
    }), 15000);


//BB Code

$("#bbold").on('click', function() {

    wrapText("message", "[b]", "[/b]");
});

$("#bitalic").on('click', function() {

    wrapText("message", "[i]", "[/i]");
});

var frm = $('#form1');
frm.submit(function(ev) {
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function(data) {
            //onsuccess
        }
    });
    document.getElementById("message").value = "";
    ev.preventDefault();
});

var frm2 = $('#form2');
frm2.submit(function(ev) {

    $.ajax({
        type: frm2.attr('method'),
        url: frm2.attr('action'),
        data: frm2.serialize(),
        success: function(data) {}
    });
    ev.preventDefault();
    $("#chatdiv").empty();
});

jQuery(document).ready(function() {
    jQuery('#emoticons').hide();
    jQuery('#hideshow').on('click', function(event) {
        jQuery('#emoticons').toggle();
    });
});

$('#emoticons a').click(function() {
    var smiley = $(this).attr('title');
    ins2pos(smiley, 'message');
});

function ins2pos(str, id) {
    var TextArea = document.getElementById(id);
    var val = TextArea.value;
    var before = val.substring(0, TextArea.selectionStart);
    var after = val.substring(TextArea.selectionEnd, val.length);

    TextArea.value = before + str + after;
    setCursor(TextArea, before.length + str.length);
}

function setCursor(elem, pos) {
    if (elem.setSelectionRange) {
        elem.focus();
        elem.setSelectionRange(pos, pos);
    } else if (elem.createTextRange) {
        var range = elem.createTextRange();
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
    }
}

//mute unmute
var audio = document.getElementById('bgAudio');

$(document).ready(function() {
    $('#mutez').click(function() {
        if ($('audio').attr('muted') == undefined) {
            $('audio').attr('muted', '');
            audio.muted = true;
            $('#mutez').val('Unmute')
        } else {
            $('audio').removeAttr('muted');
            audio.muted = false;
            $('#mutez').val('Mute')
        }
    });
});

//image modal

$(function() {
    $(document).on('click', '.pop', function() {
        $('.imagepreview').attr('src', $(this).find('img').attr('src'));
        $('.fullpreview').attr('href', $(this).find('img').attr('src'));
        $('#imagemodal').modal('show');
    });
});

//youtube modal

$(function() {
    $(document).on('click', '.videopop', function() {
        $('.videopreview').attr('src', '//www.youtube.com/embed/' + $(this).find('img').attr('alt'));
        $('#youtubemodal').modal('show');
    });
});

//closing youtube modal

$(function() {
    $(document).on('click', '.close', function() {
		$(".iframe-yt").html("<iframe width='416' height='311' src='' frameborder='0' class='videopreview' style='width: 100%;' allowfullscreen></iframe>");
    });
});

$(function() {
    $(document).on('click', '#youtubemodal', function() {
		$(".iframe-yt").html("<iframe width='416' height='311' src='' frameborder='0' class='videopreview' style='width: 100%;' allowfullscreen></iframe>");
    });
});


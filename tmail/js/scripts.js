var address = (hasher.getURL()).replace((hasher.getBaseURL()), '');
address = address.replace('#/', '');
if( address ) {
    createUser(address);
} else {
    $("#generateID").fadeIn(500);
}
var refreshRate;
$.get("actions.php", {
    action: 'refreshRate'
}).done(function( data ) {
    refreshRate = parseInt(data);
});
/*
 * Set a New ID
 */
function setNewID() {
    $("#generateID").fadeOut(500);
    var email = document.getElementsByName("email")[0].value;
    var domain = document.getElementsByName("domain")[0].value;
    var fullEmail = email + domain;
    createUser(fullEmail);
}
/*
 * Generate a Random ID
 */
function generateRandomID() {
    $("#generateID").fadeOut(500);
    var address = (hasher.getURL()).replace((hasher.getBaseURL()), '');
    address = address.replace('#/', '');
    createUser(address);
}
/*
 * Create a new address for user. If address is already specified it checks if that is valid 
 */
function createUser(address) {
    $.get("user.php", {
        user: address
    }).done(function(data) {
        address = data;
        document.getElementById("address").innerHTML = address;
        hasher.setHash(address);
        $("title").append(" - ");
        $("title").append(address);
        $("#createdline").delay(500).fadeIn(500);
        $.get("mail.php", function(data) {
            $("#data").html(data);
            $("#data").delay(600).fadeIn(500);
            $(".message").delay(600).fadeIn(500);
            retriveNewMails();
        });
    });
}
/*
 * Function to check if element is empty with possible only blank spaces
 */
function isEmpty( el ){
    return !$.trim(el.html())
}
/*
 * Checks for new emails at regular interval. setTimeout calls function every 1000 ms (1 Second)
 */
function retriveNewMails() {
    $.get("mail.php?unseen=1", function(data) {
        if(data) {
            if (!isEmpty($('.cssload-container'))) {
                $("#data").html(data);
            } else {
                $("#data").prepend(data);
            }   
            document.getElementById('notifyUserSound').play();
        }
    });
    $("#timer").html(refreshRate);
    var counter = refreshRate;
    var id = setInterval(function() {
        counter--;
        $("#timer").html(counter);
        if(counter < 0) {
            clearInterval(id);
        }
        var acc = document.getElementsByClassName("accordion");
        var i;
        for (i = 0; i < acc.length; i++) {
          acc[i].onclick = function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight){
              panel.style.maxHeight = null;
            } else {
              panel.style.maxHeight = panel.scrollHeight + "px";
            } 
          }
        }
    },1000);
    setTimeout(retriveNewMails, refreshRate*1000);
}
/*
 * Function to delete email
 * @param mailid - Identify the mail to delete
 */
function deleteMail(mailid) {
    $.get("actions.php", {
        action: 'delete',
        id: mailid
    });
    var mailLocator = "#mail".concat(mailid);
    $(mailLocator).hide( "slow", function() {
        $( this ).remove();
        if (isEmpty($('#data'))) {
            $("#data").html('<div class="cssload-container"><ul class="cssload-flex-container"><li><span class="cssload-loading"></span></li></div></div>');
        }
    });
    return false;
}
/*
 * Function which enables user to download any email
 * @param mailid - Identify the mail to download
 */
function downloadMail(mailid) {
    $.get("actions.php", {
        action: 'download',
        id: mailid
    }).done(function( data ) {
        window.location.href = data;
    });
    return false;
}
/*
 * Simple click to copy to clipboard function
 */
function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
}

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
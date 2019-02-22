function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function alertBox(message,type,errorHolder,showIcon,close,timeout){
    var icons = {}; 
    icons['success'] = 'check-circle';
    icons['info'] = 'info-circle';
    icons['warning'] = 'exclamation-circle';
    icons['danger'] = 'exclamation-circle';
    icons['primary'] = 'info-circle';
                
    var html = "<div class='alert alert-"+type+"' role='alert'>";
    if(close) html += "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
    if(showIcon) html += "<span class='fa fa-"+icons[type]+"-sign' aria-hidden='true'></span>&nbsp;";
            html += message+"</div>";

    $( document ).ready(function() {
        if(errorHolder){
            $(errorHolder).hide();
            $(errorHolder).html(html);
            $(errorHolder).fadeIn(300);
        }else{
            $(".alerts").hide();
            $(".alerts").html(html);
            $(".alerts").fadeIn(300);
            if(timeout){
                setTimeout(function(){$(".alerts").fadeOut();}, 5000);
            }
        }
    });
}

function kp_preloader(status,placeHolder){
    preloader = new $.materialPreloader({placeHolder: placeHolder});
    
    if(status == "on"){
        preloader.on(placeHolder);
    }else{
        preloader.off(placeHolder);
    }
}

function kp_cloader(target,status){
    $(target).show();
    if(status == 'off'){
        $(target+' .circle-loader').addClass('load-complete');
        $(target+' .circle-loader .checkmark').show();
    }else{
        $(target+' .circle-loader').removeClass('load-complete');
        $(target+' .circle-loader .checkmark').hide();
    }
}

$(document).ready(function () {
    $("#checkbox-all").click(function () {
    $('.logsList input[type="checkbox"],.table tbody input[type="checkbox"]').prop('checked', this.checked);
    });    
});

var exportToCSV = function(content, fileName, mimeType) {
  var a = document.createElement('a');
  mimeType = mimeType || 'application/octet-stream';

  if (navigator.msSaveBlob) { // IE10
    navigator.msSaveBlob(new Blob([content], {
      type: mimeType
    }), fileName);
  } else if (URL && 'download' in a) {
    a.href = URL.createObjectURL(new Blob([content], {
      type: mimeType
    }));
    a.setAttribute('download', fileName);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  } else {
    location.href = 'data:application/octet-stream,' + encodeURIComponent(content);
  }
}

var tagsToReplace = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;'
};

function kpEscape(tag) {
    return tagsToReplace[tag] || tag;
}

function safe_tags_replace(str) {
    return str.replace(/[&<>]/g, kpEscape);
}

function csvToArray (csv) {
    rows  = csv.split("\n");
    return rows.map(function (row) {
        return row.split(",");
    });
};

 function LinkIsValid(url) {    
      var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
      return regexp.test(url);    
 }

function creditCardValidate(value) {
var cards = {
    'mc':'5[1-5][0-9]{14}',
    'ec':'5[1-5][0-9]{14}',
    'vi':'4(?:[0-9]{12}|[0-9]{15})',
    'ax':'3[47][0-9]{13}',
    'dc':'3(?:0[0-5][0-9]{11}|[68][0-9]{12})',
    'bl':'3(?:0[0-5][0-9]{11}|[68][0-9]{12})',
    'di':'6011[0-9]{12}',
    'jcb':'(?:3[0-9]{15}|(2131|1800)[0-9]{11})',
    'er':'2(?:014|149)[0-9]{11}'
};
value = String(value).replace(/[- ]/g,''); //ignore dashes and whitespaces
var cardinfo = cards, results = [];
for(var p in cardinfo){
    if(value.match('^' + cardinfo[p] + '$')){
        results.push(p);
    }
}
return results.length ? results.join('|') : false; // String | boolean
}

$(document).ready(function () {

    document.onkeydown = function(evt) {
        evt = evt || window.event;
        var isEscape = false;
        if ("key" in evt) {
            isEscape = (evt.key === "Escape" || evt.key === "Esc");
        } else {
            isEscape = (evt.keyCode === 27);
        }
        if (isEscape) {
            $(".control-sidebar").removeClass("control-sidebar-open");
        }
    };

    $(".table tr").on("click",function (e) {
        if (e.shiftKey) {
            $('.table tr').addClass("unselectable");
        }else{
            $('.table tr').removeClass("unselectable"); 
        }
    });

	$("#checkbox-all").on("change",function () {
        $('.table tbody input[type="checkbox"]').prop('checked', this.checked);
        if(this.checked){
            $( ".table tbody input[type='checkbox']" ).parents("tr").addClass("isSelected");
        }else{
            $( ".table tbody input[type='checkbox']" ).parents("tr").removeClass("isSelected");
        }
    });
    
    $('.table tbody input[type="checkbox"]').on("change",function () {
        if(this.checked){
            $( this ).parents("tr").addClass("isSelected");
        }else{
            $( this ).parents("tr").removeClass("isSelected");
        }
    });

    $('.nodeTitle').click(function(event) {
        $("#select"+this.id).parents("tr").removeClass("isSelected");
		if($("#select"+this.id).is(":checked")){
            $("#select"+this.id).prop('checked', false);
            
		}else{
            $("#select"+this.id).prop('checked', true);
            $("#select"+this.id).parents("tr").addClass("isSelected");
		}
    });

    var lastcheck = null;
    var checkboxes = document.querySelectorAll('.table tbody input[type=checkbox], .table tbody .nodeTitle')
    Array.prototype.forEach.call(checkboxes, function (cbx, idx) {
      cbx.addEventListener('click', function (evt) {
        if ( evt.shiftKey && null !== lastcheck && idx !== lastcheck ) {
          Array.prototype.slice.call(checkboxes, Math.min(lastcheck, idx), Math.max(lastcheck, idx))
            .forEach(function (ccbx) { 
                ccbx.checked = true 
                if(ccbx.checked){
                    $( ccbx ).parents("tr").addClass("isSelected");
                }else{
                    $( ccbx ).parents("tr").removeClass("isSelected");
                }
            })
        }
        lastcheck = idx;
      })
    })
});


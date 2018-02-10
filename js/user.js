function updatePerks(str)
{
    xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById("char_perks").innerHTML = this.responseText;
        }
    }
    xmlhttp2.open("GET", "/handler/perk_handler.php?UPDATE=" + str, true);
    xmlhttp2.send();
}

function updateAttribute(str)
{
    var xmlhttp2=new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function() {
        if (this.readyState==4 && this.status==200) {
            document.getElementById("char_attribute").innerHTML = this.responseText;
        }
    }
    xmlhttp2.open("GET", "/handler/attribute_handler.php?UPDATE=" + str, true);
    xmlhttp2.send();
}

function setPerks(str)
{
    var perk_checkbox_value = "";
    $(".perkIcon").each(function () {
        var ischecked = $(this).is(":checked");
        if (ischecked) {
            perk_checkbox_value += $(this).val() + ",";
        }
    });
  if (window.XMLHttpRequest) {
  // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("character_perks").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","/handler/perk_handler.php?PERKS="+perk_checkbox_value + "&ID=" +str,true);
  xmlhttp.send();
  setTimeout(function() {
      updatePerks(str);
    }, 500);
}

function setCharacterAttribute(str)
{
    var attribute_checkbox_value = "";
    $(".attributeIcon").each(function () {
        var ischecked = $(this).is(":checked");
        if (ischecked) {
            attribute_checkbox_value = $(this).val();
        }
    });
  if (window.XMLHttpRequest) {
  // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("character_attributes").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","/handler/attribute_handler.php?ATTRIBUTE="+attribute_checkbox_value + "&ID=" +str,true);
  xmlhttp.send();
  setTimeout(function() {
      updateAttribute(str);
    }, 500);
}

function showDescription(e,divid){

    var left  = e.clientX  + 10 + "px";
    var top  = e.clientY  + -50 + "px";

    var div = document.getElementById(divid);

    div.style.left = left;
    div.style.top = top;

    $("#"+divid).toggle();
    return false;
}
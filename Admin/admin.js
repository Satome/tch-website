function removeArticle(str)
{
  if (confirm("Are you sure?") != true) {
      return false;
   }
  if (str=="") {
    document.getElementById("news_list").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("news_list").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","/handler/news_handler.php?Remove="+str,true);
  xmlhttp.send();
}

function activateUser(str)
{
  if (confirm("Are you sure?") != true) {
      return false;
   }
  if (str=="") {
    document.getElementById("user_list").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("user_list").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","/handler/user_handler.php?Activate="+str,true);
  xmlhttp.send();
}

function removeUser(str)
{
  if (confirm("Are you sure?") != true) {
      return false;
   }
  if (str=="") {
    document.getElementById("user_list").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("user_list").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","/handler/user_handler.php?Remove="+str,true);
  xmlhttp.send();
}
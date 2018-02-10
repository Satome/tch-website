function showBounty(id)
{
    var div = document.getElementById(id);
    div.style.display = div.style.display == "none" ? "block" : "none";
}

function showBountyForm(id)
{
    var div = document.getElementById(id);
    div.style.display = div.style.display == "none" ? "block" : "none";
}

function showArticle(id)
{
    var div = document.getElementById(id);
    div.style.display = div.style.display == "none" ? "block" : "none";
}

function showFullPost(str)
{
  if (str=="") {
    document.getElementById("news").innerHTML="";
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
      document.getElementById("news").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","/handler/news_handler.php?ID="+str,true);
  xmlhttp.send();
}
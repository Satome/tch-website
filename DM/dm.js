function setBountyStatus(id, status)
{
  if (window.XMLHttpRequest) {
  // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("bountyList").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","/handler/bounty_handler.php?id="+id + "&status=" +status,true);
  xmlhttp.send();
}

function setRank(id, rank)
{
  if (window.XMLHttpRequest) {
  // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("characters").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","/handler/character_handler.php?RANK="+rank + "&ID=" +id,true);
  xmlhttp.send();
}
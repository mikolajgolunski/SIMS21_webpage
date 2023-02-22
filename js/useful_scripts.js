function goBack() {
  window.history.back();
}

function checkcountry(val) {
  if (val === "United States") {
    document.getElementById("state").disabled = false;
    document.getElementById("state").required = true;
    document.getElementById("state_required").style.visibility = "visible";
  } else {
    document.getElementById("state").disabled = true;
    document.getElementById("state").required = false;
    document.getElementById("state_required").style.visibility = "hidden";
  }
}

function textCounter(field,cnt,maxlimit) {         
  var cntfield = document.getElementById(cnt);
  if (field.value.length > maxlimit) {// if too long...trim it!
    field.value = field.value.substring(0, maxlimit);
  } else {// otherwise, update 'characters left' counter
    cntfield.innerHTML = maxlimit - field.value.length;
  }
}

//Tooltip by hscripts.com
var text1="H&lt;sup&gt;+&lt;/sup&gt;&rArr;H<sup>+</sup>"; //This is the text to be displayed on the tooltip.
var text2="C&lt;sub&gt;60&lt;/sub&gt;&rArr;C<sub>60</sub>";

function showToolTip(e,text,nr){
  if(document.all)e = event;
    if(nr==1) {
      var obj = document.getElementById('bubble_tooltip');
      var obj2 = document.getElementById('bubble_tooltip_content');
    } else if(nr==2) {
      var obj = document.getElementById('bubble_tooltip2');
      var obj2 = document.getElementById('bubble_tooltip_content2');
    }
  obj2.innerHTML = text;
  obj.style.display = 'block';
  var st = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
  if(navigator.userAgent.toLowerCase().indexOf('safari')>=0)st=0;
  var leftPos = e.clientX-2;
  if(leftPos<0)leftPos = 0;
  obj.style.left = leftPos + 'px';
  obj.style.top = e.clientY-obj.offsetHeight+2+st+ 'px';

  var rect = obj.getBoundingClientRect();
  var xMove = rect.right - (window.innerWidth || document.documentElement.clientWidth);
  if(xMove > 0) {
    obj.style.left = (leftPos - xMove) + 'px';
  }
}

function hideToolTip()
{
  document.getElementById('bubble_tooltip').style.display = 'none';
  document.getElementById('bubble_tooltip2').style.display = 'none';
}
//Tooltip by hscripts.com

function isElementInViewport (el) {

  //special bonus for those using jQuery
  if (typeof jQuery === "function" && el instanceof jQuery) {
    el = el[0];
  }

  var rect = el.getBoundingClientRect();

  if (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /*or $(window).height() */
    rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
  ) {
    return 0;
  } else {
    var lower = rect.bottom - (window.innerHeight || document.documentElement.clientHeight);
    var higher = rect.top;
    if(lower > 0) {
      return lower;
    } else if(higher < 0) {
      return higher;
    } else {
      return 0;
    }
  }
}

function submenu_check() {
  //var q = document.querySelectorAll(":hover");
  //q = q[q.length-1];
  //q.id = "active";
  //var menu_sub_lis = document.querySelectorAll("#active ul");
  var menu_sub_lis = document.querySelectorAll("li.active ul");
  for(var i = 0; i < menu_sub_lis.length; i++) {
    var change_height = isElementInViewport(menu_sub_lis[i]);
    if(change_height != 0) {
      //menu_sub_lis[i].style.top = "-"+change_height+"px";
      if(change_height > 0) {
        menu_sub_lis[i].style.top = "-"+(change_height+20)+"px";
      } else {
        menu_sub_lis[i].style.top = "1px";
      }
    }
  }
}

function PrintElem(elem) {
  var mywindow = window.open('', 'PRINT', 'height=400,width=600');

  mywindow.document.write('<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><link rel="stylesheet" type="text/css" href="./css/main.css"><link rel="stylesheet" type="text/css" href="./extras/font-awesome-4.6.3/css/font-awesome.min.css"><link rel="stylesheet" type="text/css" href="./css/modaldialog.css"><title>' + document.title  + '</title>');

  mywindow.document.write('</head><body>');
  mywindow.document.write('<h1>' + document.title  + '</h1>');
  mywindow.document.write(document.getElementById(elem).innerHTML);
  mywindow.document.write('</body></html>');

  mywindow.document.close(); // necessary for IE >= 10
  mywindow.focus(); // necessary for IE >= 10*/

  mywindow.print();
  mywindow.close();

  return true;
}

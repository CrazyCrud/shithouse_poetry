var overlayTemplate = null;
var lawTemplate = null;
var rootFolder = null;
var AUTH_KEY_LENGTH = 45;

$(document).ready(function() {
	 $(document).foundation();
    setupOverlayBackground();
    setupLawMenu();
    cookieUser();
    greetUser();
    getCurrentUser();
});

function setupOverlayBackground(){
    if($("script.overlay-template").length > 0){
        overlayTemplate = _.template($("script.overlay-template").html()); 
    }
}

function setupLawMenu(){
    if($("script.law-template").length > 0){
        lawTemplate = _.template($("script.law-template").html()); 
        $("body").append(lawTemplate());
        $(".law-icon-container").click(function(event) {
            if($("#law-overlay").css('display') != "block"){
              $("#law-overlay").css('display', 'block');
            }else{
              $("#law-overlay").css('display', 'none');
            }
        });

        $(this).mouseup(function (e)
        {

            var container = $("#law-overlay");
            if (!container.is(e.target) && !($(e.target).parent().hasClass('law-icon-container')) &&
                container.has(e.target).length === 0) {
                $(container).css('display', 'none');
            }
        });
    }
}

function createOverlayBackground(){
    if($("#overlay-background").length > 0){
        return;
    }else{
        $("body").append(overlayTemplate());
    }
}

function removeOverlayBackground(){
    $("#overlay-background").remove();
}

function cookieUser(){
    user = {};
    user.id = parseInt(document.cookie.replace(/(?:(?:^|.*;\s*)userid\s*\=\s*([^;]*).*$)|^.*$/, "$1"));
    user.username = document.cookie.replace(/(?:(?:^|.*;\s*)username\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    user.admin = document.cookie.replace(/(?:(?:^|.*;\s*)admin\s*\=\s*([^;]*).*$)|^.*$/, "$1")=="1";
    user.status = parseInt(document.cookie.replace(/(?:(?:^|.*;\s*)admin\s*\=\s*([^;]*).*$)|^.*$/, "$1"));
}

function greetUser(){
    if(!_.isEmpty(user)&&user.status!=4&&user.status!="4"){
      if(user.username.length > 0){
        $("#link-login").children('span').html(getUserName(user.username));
        $("#link-login i").removeAttr('class');
        $("#link-login i").addClass('icon-menu');
      }
    }
}

function loggedIn(){
  return(user&&user.username&&user.username.length>0);
}

function saveUser(user){
  var d = new Date();
  var thirtyDays = 2592000000;
  d.setTime(d.getTime() + thirtyDays);
  document.cookie = "username=" + user.username + "; expires=" + d.toGMTString();
  document.cookie = "userid=" +user.id+ "; expires=" + d.toGMTString();
  document.cookie = "admin=" + user.status + "; expires=" + d.toGMTString();
}

function formatTime(time){
  var ONE_SEC = 1000;
  var ONE_MIN = 60*ONE_SEC;
  var ONE_HOUR = 60*ONE_MIN;
  var ONE_DAY = 24*ONE_HOUR;
  var ONE_WEEK = 7*ONE_DAY;
  if(!time)return "";
  var monthNames = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
  var today = new Date();
  var timeObj = convertDateTime(time);
  var timestamp = timeObj.getTime();
  var difference = today-timestamp;
  if(difference>ONE_DAY){
      if(difference<ONE_WEEK){
          if(timeObj.getDate()==today.getDate()-1){
              var mins = timeObj.getMinutes();
              if(mins<10)mins="0"+mins;
              return "gestern um %1".replace("%1",timeObj.getHours()+":"+mins);
          }else{
              var days = Math.round((difference/ONE_DAY));
              return (days==1?
                    "vor einem Tag":
                    "vor %1 Tagen".replace("%1",days)                     
              );
          }
      }else{
          if(timeObj.getFullYear()!=today.getFullYear()){
              return timeObj.getDate()+". "+monthNames[timeObj.getMonth()]+" "+timeObj.getFullYear();
          }else{
              return timeObj.getDate()+". "+monthNames[timeObj.getMonth()];
          }
      }
  }else if(difference>ONE_HOUR){
      var hours = Math.round((difference/ONE_HOUR));
      return (hours==1?
                "vor einer Stunde":
                "vor %1 Stunden".replace("%1",hours)                   
          );
  }else if(difference>ONE_MIN){
      var minutes = Math.round((difference/ONE_MIN));
      return (minutes==1?
                "vor einer Minute":
                "vor %1 Minuten".replace("%1",minutes)                   
          );
  }else{
      return "gerade eben";
  }
}

function convertDateTime(dt){
    if(!dt)return null;
    dateTime = dt.split(" ");

    var date = dateTime[0].split("-");
    if(date.length<3){
        date = dateTime[0].split(".");
    }
    if(date[0].length==4){
        var yyyy = date[0];
        var dd = date[2];
    }else{
        var yyyy = date[2];
        var dd = date[0];
    }
    var mm = parseInt(date[1])-1;

    var time = dateTime[1].split(":");
    var h = time[0];
    var m = time[1];
    if(time.length==3){
        var s = parseInt(time[2]); //get rid of that 00.0;
    }else{
        var s = 0;
    }
    
    var result = new Date(yyyy,mm,dd,h,m,s);
    
    return result;
}

getAvatar = function(name){
    return "http://social.microsoft.com/profile/u/avatar.jpg?displayname=%1".replace("%1",name);
}

function getCurrentUser(){
    var authkey = document.cookie.replace(/(?:(?:^|.*;\s*)authkey\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    if(authkey){
        ImgurManager.getUserAuth(logoutUser, authkey);
    }
}

function logoutUser(data){
    if(_.isNull(data)){
        ImgurManager.logout(logoutSuccess);
    }
}

function logoutSuccess(yep){
  $("#link-login").children('span').html("Login");
  var d = new Date(1970, 1);
  document.cookie = "username=''  ; expires=" + d.toGMTString();
  document.cookie = "userid=''; expires=" + d.toGMTString();
  document.cookie = "admin=''; expires=" + d.toGMTString();
  document.cookie = "authkey=''; expires=" + d.toGMTString();
  if(yep){
    window.location = "index.php";

  }else{
    window.location = "index.php"; // change dat
  }
}

function getUserIcon(status, title){
  var $icon = $('<img src="img/global/admin.png" title="Administrator"></img>');
  if(status==1){
    $icon.attr("src","img/global/icons/icon.svg");
    if(title.trim().length == 0)title = "Administrator";
  }else{
    if(title.trim().length > 0)$icon.attr("src", "img/global/icons/"+title.toLowerCase().replace(" ","_")+".svg");
  }
  if(title.trim().length > 0){
    $icon.attr("title", title);
    return $icon;
  }
}

function getUserName(user){
  if(typeof user === "string"){
    user = user.trim();
    if(user.indexOf(":")!=-1){
      return user.replace(/.*:/,"");
    }
    if(user.indexOf("User")==0&&user.length>=15){
      return "Jemand";
    }else{
      return user;
    }
  }else{
    switch(user.status){
      case -1:
      case "-1":
        return "Gel&ouml;schter Nutzer";
      case 4:
      case "4":
        return "Anonymer Nutzer";
      default:
        if(user.name)
          return getUserName(user.name);
        if(user.username)
          return getUserName(user.username);
        return "???";
    }
  }
}

function s4() {
  return Math.floor((1 + Math.random()) * 0x10000)
             .toString(16)
             .substring(1);
}

function guid() {
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
         s4() + '-' + s4() + s4() + s4();
}

function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.round(Math.random() * 15)];
    }
    return color;
}

function formatCommentText(comment){
  comment = formatUsersInComment(comment);
  comment = formatTagsInComment(comment);
  return comment;
}
function formatUsersInComment(comment){
  var users = comment.match(/(^|[^0-9])@\-?[0-9]+@[a-zA-Z0-9]+/gi);
  if(users){
    for(var i=users.length-1; i>=0; i--){
      users[i] = users[i].trim();
      var userid = users[i].match(/@\-?[0-9]+@/)[0];
      userid = userid.substring(1,userid.length-1);
      var username = users[i].replace("@"+userid+"@", "").trim();
      if(userid == "-1"){
        comment = comment.replace(users[i],"@"+username);
      }else{
        comment = comment.replace(users[i],'<a href="user.php?id='+userid+'">@'+username+'</a>');
      }
    }
  }
  return comment;
}
function formatTagsInComment(comment){
  var tags = comment.match(/#[a-zA-Z0-9]+/gi);
  if(tags){
    for(var i=tags.length-1; i>=0; i--){
      tags[i] = tags[i].trim();
      var tag = tags[i].substring(1);
      comment = comment.replace(tags[i],'<a href="search.php?type=tag&values='+tag+'">#'+tag+'</a>');
    }
  }
  return comment;
}
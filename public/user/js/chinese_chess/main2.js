
"use strict";

if(typeof start_fen === 'undefined')
{
     var STARTUP_FEN = [
      "rnbakabnr/9/1c5c1/p1p1p1p1p/9/9/P1P1P1P1P/1C5C1/9/RNBAKABNR w",
      "rnbakabnr/9/1c5c1/p1p1p1p1p/9/9/P1P1P1P1P/1C5C1/9/RNBAKAB1R w",
      "rnbakabnr/9/1c5c1/p1p1p1p1p/9/9/P1P1P1P1P/1C5C1/9/R1BAKAB1R w",
      "rnbakabnr/9/1c5c1/p1p1p1p1p/9/9/9/1C5C1/9/RN2K2NR w",
    ];
} 
else
{
    var STARTUP_FEN = [
      start_fen,
      start_fen,
      start_fen,
      start_fen,
    ];
}

function reverse_move(inp)
{   
    var result = "";
    switch(inp)
    {
        case "A" : 
                    result = "I";
                    break;
        case "B" : 
                    result = "H";
                    break;
        case "C" : 
                    result = "G";
                    break;
        case "D" : 
                    result = "F";
                    break;
        case "E" : 
                    result = "E";
                    break;
        case "F" : 
                    result = "D";
                    break;
        case "G" : 
                    result = "C";
                    break;
        case "H" : 
                    result = "B";
                    break;
        case "I" : 
                    result = "A";
                    break;                                                                         
    } 
    return result;
}

function createOption(text, value, ie8) {
  var opt = document.createElement("option");
  opt.selected = true;
  opt.value = value;
  if (ie8) {
    opt.text = text;
  } else {
    opt.innerHTML = text.replace(/ /g, "&nbsp;");
  }
  return opt;
}

if(typeof start_fen === 'undefined')
{
 var start_fen = "rnbakabnr/9/1c5c1/p1p1p1p1p/9/9/P1P1P1P1P/1C5C1/9/RNBAKABNR w - - 0 1";
} 

var check_bl = 0;
if(start_fen.indexOf(" b") !== -1 && jQuery("#selMoveMode").val() == 0)
{
  //start_fen = start_fen.replace(/ b/g,' w');
  check_bl = 1;
}

var start_fen_temp = start_fen;

if(start_fen_temp.indexOf(" w") === -1 && start_fen_temp.indexOf(" b") === -1)
{
    start_fen_temp+= " w";
}

start_fen_temp = start_fen_temp.replace(/h/g,'n');
start_fen_temp = start_fen_temp.replace(/H/g,'N');
start_fen_temp = start_fen_temp.replace(/e/g,'b');
start_fen_temp = start_fen_temp.replace(/E/g,'B');

var board = new Board(container, "images/", "sounds/", start_fen, check_bl);
board.setSearch(16);
board.millis = 10;
board.millis = 2000;
board.sellMode = 2;


//firebase.database().ref('chinese_chess/').set({
//    start_fen : start_fen,
//    user_move_1 : "",
//    user_move_2 : "",
//    current_fen : start_fen
//});


//console.log();

board.gameType = jQuery("#gameType").val();

board.onAddMove = function(inp_move = "") {  
  AsyncUpdateMoves();  
  var counter = (board.pos.mvList.length >> 1);
  var space = (counter > 99 ? "    " : "   ");
  counter = (counter > 9 ? "" : " ") + counter + ".";
  //console.log(counter);
  var text = (board.pos.sdPlayer == 0 ? space : counter) + move2Iccs(board.mvLast);
  //console.log(text);
  var value = "" + board.mvLast;
  
  var act_index = jQuery(".steps table tr[class=active]").index();
  
  jQuery("#selMoveList option").each(function(){
    if(jQuery(this).index()>act_index)
    {
        jQuery(this).remove();
    }
  });
  
  jQuery("div.steps table tbody tr").each(function(){
    if(jQuery(this).index()>act_index)
    {
        jQuery(this).remove();
    }
  });
  try {
    selMoveList.add(createOption(text, value, false));
  } catch (e) {
    selMoveList.add(createOption(text, value, true));
  }
  selMoveList.scrollTop = selMoveList.scrollHeight;
  if(jQuery("div.steps table tbody tr").last().index() % 2 == 0)
  {
    var str_mov = "<tr><td><strong>"+counter+"</strong></td><td>"+inp_move+"</td></tr>";  
  }
  else
  {
    var str_mov = "<tr><td></td><td>"+inp_move+"</td></tr>";  
  }
  
  jQuery("div.steps table tbody").append(str_mov);
  
  jQuery(".steps table tr[class=active]").each(function(){
    jQuery(this).removeClass("active");
  });
  jQuery("div.steps table tbody tr").last().addClass("active");
  
  jQuery("div.steps table tbody tr").last().click(function(){
        jQuery(".steps table tr[class=active]").each(function(){
            jQuery(this).removeClass("active");
        });
       jQuery(this).addClass("active");
       var cur_index = jQuery(this).index();
       //console.log(cur_index);
       if(cur_index == 0)
       {
           board.fromFen(start_fen);
           board.flushBoard();
       }
       else
       {
           //jQuery("#selMoveList option").each(function(){
//                jQuery(this).removeAttr("selected");
//           });
//           jQuery("#selMoveList option").eq(cur_index).attr("selected","selected"); 
           selMoveList.selectedIndex = cur_index;
           //jQuery("#selMoveList").val(cur_val);
           moveList_change();  
       }
  });
  jQuery("div.steps").scrollTop(jQuery( "div.steps table" ).height());
};

function level_change() {
    let tt = document.getElementById("selLevel")
    board.millis = tt.options[tt.selectedIndex].value;
}


function restart_click() { 
  if(confirm('Bạn có muốn bắt đầu game mới không?'))
  {   
      selMoveList.options.length = 1;
      selMoveList.selectedIndex = 0;
      board.gameType = 1;
      board.sellMode = 2;
      //jQuery("#selMoveMode").val(2);
      
      //if(jQuery("#name_player").val()=='dau')
//        {
//            board.computer = 0;
//            board.start_target = 2;
//        }
//        else
//        {
//            board.computer = 1 - selMoveMode.selectedIndex;
//            board.start_target = 1;
//        }
      
      board.restart(STARTUP_FEN[selHandicap.selectedIndex]);
      jQuery("div.steps table tbody tr").not(":first").remove();
      jQuery("div.steps table tbody tr").first().addClass("active");
      jQuery("#message_area_84423").fadeOut(); 
      if(board.gameType == 2)
      {
        jQuery("#stop_action input").css("display","block");
        jQuery("#prev_action input[type=button]").css("background","burlywood");
        jQuery("#prev_action input[type=button]").removeAttr('onclick');
      
        jQuery("#start_game_action input[type=button]").css("background","burlywood");
        jQuery("#start_game_action input[type=button]").removeAttr('onclick');
      }  
      else if(board.gameType == 1)
      {
        jQuery("#stop_action input").css("display","none");
        jQuery("#stop_action input").val("∎ Tạm dừng");
      } 
      board.move_list = [];
      AsyncUpdateMoves();
  }
}

function retract_click() {
  if(confirm('Bạn có muốn lùi 1 bước không?'))
  {  
      for (var i = board.pos.mvList.length; i < selMoveList.options.length; i ++) {
        board.pos.makeMove(parseInt(selMoveList.options[i].value));
      }
      board.retract();
      jQuery("#message_area_84423").fadeOut(); 
      selMoveList.options.length = board.pos.mvList.length;
      selMoveList.selectedIndex = selMoveList.options.length - 1;
      jQuery("div.steps table tbody tr").last().remove();
      jQuery("div.steps table tbody tr").last().remove();
      start_fen = board.pos.toFen();
      jQuery("div.steps table tbody tr").last().addClass("active");
      board.move_list = [];
      AsyncUpdateMoves();
  }
}

function stop_game()
{
    if(jQuery("#stop_action input").val()=="∎ Tạm dừng")
    {
        board.gameType = 1;
        jQuery("#gameType").val(1);
        board.busy = true;
        jQuery("#stop_action input").val("▶ Tiếp tục");
        jQuery("#stop_action input").css("background","mediumseagreen");
        //jQuery("#stop_action input").val("▶ Tiếp tục");
        //jQuery("#stop_action input").css("opacity","1");  
        jQuery("#stop_action input").removeAttr("disabled");
        
        jQuery("#prev_action input[type=button]").css("background","brown");
        jQuery("#prev_action input[type=button]").attr('onclick','retract_click();');
        jQuery("#start_game_action input[type=button]").css("background","darkblue");
        jQuery("#start_game_action input[type=button]").attr('onclick','restart_click();');       
    }
    else
    {                        
        jQuery("#prev_action input[type=button]").css("background","burlywood");
        jQuery("#prev_action input[type=button]").removeAttr('onclick');
      
        jQuery("#start_game_action input[type=button]").css("background","burlywood");
        jQuery("#start_game_action input[type=button]").removeAttr('onclick');
        
        board.busy = false;
        board.gameType = 2;
        jQuery("#gameType").val(2);
        jQuery("#stop_action input").val("∎ Tạm dừng");
        jQuery("#stop_action input").css("background","darkcyan");
        board.response();
    }
}

function moveList_change() {
    //console.log(board.result);
  //if (board.result == RESULT_UNKNOWN) {
//    selMoveList.selectedIndex = selMoveList.options.length - 1;
//    return;
//  }
  var from = board.pos.mvList.length;
  var to = selMoveList.selectedIndex;
  if (from == to + 1) {
    return;
  }
  if (from > to + 1) {
    for (var i = to + 1; i < from; i ++) {
      board.pos.undoMakeMove();
    }
  } else {
    for (var i = from; i <= to; i ++) {
      board.pos.makeMove(parseInt(selMoveList.options[i].value));
    }
  }
  board.flushBoard();
}


window.fbAsyncInit = function() {     
    FB.init({
        appId      : '3683990404990934',
        status     : true,
        xfbml      : true
    });
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/vi_VN/all.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

document.addEventListener ('contextmenu', ((x) =>  x.preventDefault ()) , false);
 jQuery('p:empty').remove();
 jQuery(document).ready(function(){
    
    jQuery("#gameType option[value=2]").css("display","none");
    jQuery("#selMoveMode option[value=2]").css("display","none");
    
    jQuery("div.steps table tr").each(function(){
        jQuery(this).click(function(){
            jQuery(".steps table tr[class=active]").each(function(){
                jQuery(this).removeClass("active");
            });
           jQuery(this).addClass("active");
     });
    });
    
    jQuery(".sd-sharing .sd-title").html("Chia sẻ ván cờ của bạn nhanh chóng tại đây :");
    
    
    jQuery("a.share-facebook").removeAttr("href");
    jQuery("a.share-facebook").removeAttr("target");
    jQuery("a.share-facebook").off('click');
    jQuery("a.share-facebook").removeClass("share-facebook");
    
    jQuery("li.share-facebook a").click(function() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        var hour = today.getHours();
        hour = (parseInt(hour) < 10 ? "0"+hour : hour);
        var minute = today.getMinutes();
        minute = (parseInt(minute) < 10 ? "0"+minute : minute);
        
        
        var start_fen_board = start_fen;
        var str_board = "";
        if(jQuery(".entry-title").length>0)
        {
            var title_chess = "Dữ liệu "+jQuery(".entry-title").html()+" ("+hour+":"+minute+" "+dd+"/"+mm+"/"+yyyy + ")";
        }
        else
        {
            var title_chess = "Dữ liệu "+jQuery(".page-title").html()+" ("+hour+":"+minute+" "+dd+"/"+mm+"/"+yyyy + ")";
        }
        jQuery("div.steps table tbody tr").not(":first").each(function(){
            str_board += jQuery(this).find("td").last().html();
        });
        var encodedString = Base64.encode(str_board);
        //console.log(start_fen_board);
        //if(board.computer === 1)
//        {
//            start_fen_board = start_fen_board.replace("w", "b");
//        }
        
        var link_share = window.location.href;
        if(jQuery(".steps table tr").length>1)
        {
            link_share = "https://covuive.com/du-lieu-van-co/?start_fen="+start_fen_board+"&move_list="+encodedString+"&title_chess="+title_chess;
        }
        jQuery("meta[property='og:url']").attr('content',link_share);
        jQuery("meta[property='og:title']").attr('content',title_chess);
        //console.log(link_share);
        //return false;
        FB.ui({
          method: 'feed',
          display : 'popup',
          name : title_chess,
          caption : title_chess,
          description : title_chess
          ,
          properties: JSON.stringify({
            object: {
                'og:url': link_share,
                'og:title': title_chess
            }
          }),
          link: link_share
        }, function(response){});
    }); 
    
    jQuery("div.steps table tbody tr").first().click(function(){
        jQuery(".steps table tr[class=active]").each(function(){
            jQuery(this).removeClass("active");
        });
       jQuery(this).addClass("active");
       var cur_index = jQuery(this).index();
       if(cur_index == 0)
       {
           board.pos.fromFen(start_fen);
           board.flushBoard();
       }
  });   
    AsyncUpdateMoves();   
    
    jQuery("head").append("<script src='/cvv/ChineChess/screenshot.js'></script>"); 
    jQuery("#game_action").append('<a id="img_link" style="display:none"></a>');  
    jQuery(".mh-meta").append('<input type="button" class="button" value="Chụp hình cờ" style="background: darkslategray; border-radius: 5px; color: white; padding: 10px; margin-left:5px; cursor:pointer;" onclick="ScreenShot()">');  
});

var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}} 

function getXmlHttp() {
	var xmlhttp;
	if (typeof XMLHttpRequest != 'undefined') {
		xmlhttp = new XMLHttpRequest();
	} else {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(e) {
			xmlhttp = false;
		}
	}
	return xmlhttp;
}

function sleepFor( sleepDuration ){
    var now = new Date().getTime();
    while(new Date().getTime() < now + sleepDuration){ /* do nothing */ } 
}

function ActionRepond(mov)
{
    //console.log(mov);
    mov = mov.toUpperCase();
    board.search_mov = mov;
    
    var str1 = ASC(mov.substr(0,1));
    var str2 = ASC(mov.substr(1,1));
    var end1 = ASC(mov.substr(2,1));
    var end2 = ASC(mov.substr(3,1));
    //console.log(mov);
    
    for(var tt = 1; tt<=100000; tt++)
    {
       if(((tt & 255) & 15) == (str1 - 62) && ((tt & 255) >> 4) == (60 - str2) && ((tt >> 8) & 15) == (end1 - 62) && ((tt >> 8) >> 4) == (60 - end2))
       {
         //console.log(tt);
         //break;
         board.addMove(board.search.searchMain(LIMIT_DEPTH, board.millis,tt), true);
         arr_move = [];
         board.thinking.style.visibility = "hidden";  
         if(board.gameType == 1)
         {
              jQuery("#prev_action input[type=button]").css("background","brown");
              jQuery("#prev_action input[type=button]").attr('onclick','retract_click();');
              jQuery("#start_game_action input[type=button]").css("background","darkblue");
              jQuery("#start_game_action input[type=button]").attr('onclick','restart_click();');
         }
         //board.busy = false;
         //AsyncUpdateMoves();
         board.move_list = [];
         break;
       }
    }
}

function GetMoveList()
{
    var movelist = new String();
    
    if(jQuery("#selMoveList option").length>1)
    {
        jQuery("#selMoveList option").not(":first").each(function(){
            var temp = jQuery(this).html().replace(/&nbsp;/g,'');
            var temp__ = temp.split(".");
            
            if(temp__.length>1)
            {
                temp__ = temp__[1];
            }
            else
            {
                temp__ = temp__[0];
            }
            temp__ = temp__.replace(/-/g,'');
            movelist+=temp__.toLowerCase() + "|";
        });
    }
    
    if(movelist!="")
    {
        movelist = movelist.substr(0,movelist.length-1);
    }
    return movelist;
}

function AsyncGetEngineMove() {
	var xmlhttpMove = getXmlHttp();

	xmlhttpMove.open('POST', 'https://www.chessdb.cn/chessdb.php', true);
	xmlhttpMove.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttpMove.onreadystatechange = function () {
		if (xmlhttpMove.readyState == 4) {
			if (xmlhttpMove.status == 200) {
				
                var ss = new String();
				if (xmlhttpMove.responseText.search(/move:/) != -1) {
					var rps = new RegExp(xmlhttpMove.responseText.substr(5, 4));
                    while(board.move_list.length > 0)
                    {
                        for (var x = 0; x < board.move_list.length; x++) {
    						if (board.move_list[x].search(rps) != -1) {
    							ss = board.move_list[x];
                                ActionRepond(ss);
                                break;
    						}
    					}
                    }
				}
			} else {
			}
		}
	};
    
    var temp_fen = start_fen_temp;
	var s = start_fen_temp;
    
	function d(n, t) {
		var r = (65535 & n) + (65535 & t);
		return (n >> 16) + (t >> 16) + (r >> 16) << 16 | 65535 & r
	}
	function f(n, t, r, e, o, c) {
		return d((u = d(d(t, n), d(e, c))) << (f = o) | u >>> 32 - f, r);
		var u, f
	}
	function l(n, t, r, e, o, c, u) {
		return f(t & r | ~t & e, n, t, o, c, u)
	}
	function m(n, t, r, e, o, c, u) {
		return f(t & e | r & ~e, n, t, o, c, u)
	}
	function v(n, t, r, e, o, c, u) {
		return f(t ^ r ^ e, n, t, o, c, u)
	}
	function g(n, t, r, e, o, c, u) {
		return f(r ^ (t | ~e), n, t, o, c, u)
	}
	function o() {
		var n, t, r, e;
		(t = s.concat(u),
		function(n) {
			var t, r, e = "0123456789abcdef", o = "";
			for (r = 0; r < n.length; r += 1)
				t = n.charCodeAt(r),
				o += e.charAt(t >>> 4 & 15) + e.charAt(15 & t);
			return o
		}((r = t,
		function(n) {
			var t, r = "", e = 32 * n.length;
			for (t = 0; t < e; t += 8)
				r += String.fromCharCode(n[t >> 5] >>> t % 32 & 255);
			return r
		}(function(n, t) {
			var r, e, o, c, u;
			n[t >> 5] |= 128 << t % 32,
			n[14 + (t + 64 >>> 9 << 4)] = t;
			var f = 1732584193
			  , a = -271733879
			  , i = -1732584194
			  , h = 271733878;
			for (r = 0; r < n.length; r += 16)
				a = g(a = g(a = g(a = g(a = v(a = v(a = v(a = v(a = m(a = m(a = m(a = m(a = l(a = l(a = l(a = l(o = a, i = l(c = i, h = l(u = h, f = l(e = f, a, i, h, n[r], 7, -680876936), a, i, n[r + 1], 12, -389564586), f, a, n[r + 2], 17, 606105819), h, f, n[r + 3], 22, -1044525330), i = l(i, h = l(h, f = l(f, a, i, h, n[r + 4], 7, -176418897), a, i, n[r + 5], 12, 1200080426), f, a, n[r + 6], 17, -1473231341), h, f, n[r + 7], 22, -45705983), i = l(i, h = l(h, f = l(f, a, i, h, n[r + 8], 7, 1770035416), a, i, n[r + 9], 12, -1958414417), f, a, n[r + 10], 17, -42063), h, f, n[r + 11], 22, -1990404162), i = l(i, h = l(h, f = l(f, a, i, h, n[r + 12], 7, 1804603682), a, i, n[r + 13], 12, -40341101), f, a, n[r + 14], 17, -1502002290), h, f, n[r + 15], 22, 1236535329), i = m(i, h = m(h, f = m(f, a, i, h, n[r + 1], 5, -165796510), a, i, n[r + 6], 9, -1069501632), f, a, n[r + 11], 14, 643717713), h, f, n[r], 20, -373897302), i = m(i, h = m(h, f = m(f, a, i, h, n[r + 5], 5, -701558691), a, i, n[r + 10], 9, 38016083), f, a, n[r + 15], 14, -660478335), h, f, n[r + 4], 20, -405537848), i = m(i, h = m(h, f = m(f, a, i, h, n[r + 9], 5, 568446438), a, i, n[r + 14], 9, -1019803690), f, a, n[r + 3], 14, -187363961), h, f, n[r + 8], 20, 1163531501), i = m(i, h = m(h, f = m(f, a, i, h, n[r + 13], 5, -1444681467), a, i, n[r + 2], 9, -51403784), f, a, n[r + 7], 14, 1735328473), h, f, n[r + 12], 20, -1926607734), i = v(i, h = v(h, f = v(f, a, i, h, n[r + 5], 4, -378558), a, i, n[r + 8], 11, -2022574463), f, a, n[r + 11], 16, 1839030562), h, f, n[r + 14], 23, -35309556), i = v(i, h = v(h, f = v(f, a, i, h, n[r + 1], 4, -1530992060), a, i, n[r + 4], 11, 1272893353), f, a, n[r + 7], 16, -155497632), h, f, n[r + 10], 23, -1094730640), i = v(i, h = v(h, f = v(f, a, i, h, n[r + 13], 4, 681279174), a, i, n[r], 11, -358537222), f, a, n[r + 3], 16, -722521979), h, f, n[r + 6], 23, 76029189), i = v(i, h = v(h, f = v(f, a, i, h, n[r + 9], 4, -640364487), a, i, n[r + 12], 11, -421815835), f, a, n[r + 15], 16, 530742520), h, f, n[r + 2], 23, -995338651), i = g(i, h = g(h, f = g(f, a, i, h, n[r], 6, -198630844), a, i, n[r + 7], 10, 1126891415), f, a, n[r + 14], 15, -1416354905), h, f, n[r + 5], 21, -57434055), i = g(i, h = g(h, f = g(f, a, i, h, n[r + 12], 6, 1700485571), a, i, n[r + 3], 10, -1894986606), f, a, n[r + 10], 15, -1051523), h, f, n[r + 1], 21, -2054922799), i = g(i, h = g(h, f = g(f, a, i, h, n[r + 8], 6, 1873313359), a, i, n[r + 15], 10, -30611744), f, a, n[r + 6], 15, -1560198380), h, f, n[r + 13], 21, 1309151649), i = g(i, h = g(h, f = g(f, a, i, h, n[r + 4], 6, -145523070), a, i, n[r + 11], 10, -1120210379), f, a, n[r + 2], 15, 718787259), h, f, n[r + 9], 21, -343485551),
				f = d(f, e),
				a = d(a, o),
				i = d(i, c),
				h = d(h, u);
			return [f, a, i, h]
		}(function(n) {
			var t, r = [];
			for (r[(n.length >> 2) - 1] = void 0,
			t = 0; t < r.length; t += 1)
				r[t] = 0;
			var e = 8 * n.length;
			for (t = 0; t < e; t += 8)
				r[t >> 5] |= (255 & n.charCodeAt(t / 8)) << t % 32;
			return r
		}(e = unescape(encodeURIComponent(r))), 8 * e.length))))).substring(0, 2) == Array(3).join("0") ? xmlhttpMove.send('action=queryengine&board=' + s + '&movelist=' + GetMoveList() + '&token=' + u) : setTimeout(function() {
			u += Math.floor(100 * Math.random()),
			o()
		}, 0)
	}
	var u = Math.floor(1e4 * Math.random());
	o();
}

function AsyncGetAutoMove(banarr) {
	var xmlhttpMove = getXmlHttp();

	var banlist = new String();
	if (banarr.length) {
		for (var x = 0; x < banarr.length; x ++) {
			if (banlist.length) {
				banlist = banlist + '|';
			}
			banlist = banlist + banarr[x];
		}
	}
	xmlhttpMove.open('POST', '/cvv/ChineChess/api/get_move.php', true);
	xmlhttpMove.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttpMove.onreadystatechange = function() {
		if (xmlhttpMove.readyState == 4) {
			if (xmlhttpMove.status == 200) {
			    var ss = new String(); 
				if (xmlhttpMove.responseText.search(/move:/) != -1 || xmlhttpMove.responseText.search(/egtb:/) != -1) {
					var rps = new RegExp(xmlhttpMove.responseText.substr(5, 4));
					for (var x = 0; x < board.move_list.length; x++) {
						if (board.move_list[x].search(rps) != -1) {
							ss = board.move_list[x];
                            break;
						}
					}
				} else if (xmlhttpMove.responseText.search(/search:/) != -1) {
					var rps = new RegExp(xmlhttpMove.responseText.substr(7, 4));
					for (var x = 0; x < board.move_list.length; x++) {
						if (board.move_list[x].search(rps) != -1) {
							ss = board.move_list[x];
                            break;
						}
					}
				}
                if(ss!="")
                {
                    ActionRepond(ss);
                }
                else
                {
                    AsyncGetEngineMove();
                }
			}
		}
	};
    
    var temp_fen = board.pos.toFen();
    
    if(temp_fen.indexOf(" w") === -1 && temp_fen.indexOf(" b") === -1)
    {
        temp_fen+= " w";
    }
    temp_fen = temp_fen.replace(/h/g,'n');
    temp_fen = temp_fen.replace(/H/g,'N');
    temp_fen = temp_fen.replace(/e/g,'b');
    temp_fen = temp_fen.replace(/E/g,'B');
	//var s = temp_fen;
    
	xmlhttpMove.send('act=get_qrbest&learn=1&fen=' + temp_fen + '&mov=' + banlist);
	
}


function AsyncUpdateMoves() {
    if(board.sellMode!=2)
    {
        if(board.check_black == 1)
        {
             if (board.search == null || board.computerMove()) {
                
                if(board.gameType == 1)
                {
                    board.busy = false;
                    return;            
                }        
             }
        }
        else
        { 
            if (board.search == null || !board.computerMove()) {
            
                if(board.gameType == 1)
                {
                    board.busy = false;
                    return;            
                }        
            }
        }    
        var temp_fen = board.pos.toFen();
        
        if(temp_fen.indexOf(" w") === -1 && temp_fen.indexOf(" b") === -1)
        {
            temp_fen+= " w";
        }
        temp_fen = temp_fen.replace(/h/g,'n');
        temp_fen = temp_fen.replace(/H/g,'N');
        temp_fen = temp_fen.replace(/e/g,'b');
        temp_fen = temp_fen.replace(/E/g,'B');
    	//var s = temp_fen;
        
    	var xmlhttp = getXmlHttp();
    
        xmlhttp.open('GET', '/cvv/ChineChess/api/get_move.php?act=get_all&fen=' + temp_fen, true);
    
    	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    	xmlhttp.onreadystatechange = function() {
    		if (xmlhttp.readyState == 4) {
    			if (xmlhttp.status == 200) {
    				var s = xmlhttp.responseText.replace(/[\r\n]/, '');
                    //console.log(s);
    				var arr_temp = s.split("|");
                    //console.log(arr_temp);
                    for(var i_arr_temp in arr_temp)
                    {
                        var arr_t = arr_temp[i_arr_temp].split(",");
                        arr_t = arr_t[0].split(":");
                        board.move_list.push(arr_t[1]);
                    }
    			} else {
    			}
    		}
    	};
    	xmlhttp.send(null);
    }
}

function AutoMove() {
    
    //var time_out = 10;
    //if(board.gameType == 2)
    //{
        var time_out = 2000;
    //}
    setTimeout(function(){ 
        var banarr = new Array();
        var curstep = jQuery("div.steps table tr").length - 1;
    	if (curstep >= 4) {
    		var xmlhttpAuto = getXmlHttp();
    		xmlhttpAuto.open('POST', '/cvv/ChineChess/api/get_move.php', true);
    		xmlhttpAuto.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    		xmlhttpAuto.onreadystatechange = function() {
    			if (xmlhttpAuto.readyState == 4) {
    				if (xmlhttpAuto.status == 200) {
    					if(xmlhttpAuto.responseText.search(/move:/) != -1) {
    						var rulelist = xmlhttpAuto.responseText.split('|');
    						for (var x = 0; x < rulelist.length; x++) {
    							if(rulelist[x].search(/,rule:ban/) != -1) {
    								banarr.push(rulelist[x].split(',')[0]);
    							}
    						}
    						AsyncGetAutoMove(banarr);
    					} else {
    					}
    				} else {
    				}
    			}
    		};
    		xmlhttpAuto.send('act=get_rul&fen=' + start_fen_temp + '&mov=' + GetMoveList());
    	} else {
    		AsyncGetAutoMove(banarr);
    	}
    }, time_out);
}

function ScreenShot() {
    
    if(jQuery(document).width()<480)
    {
        jQuery("#container").width(330);
        jQuery("#container").height(365.5);
        jQuery("#container").addClass("fitScreen");
        jQuery("#container img").each(function(){    
            jQuery(this).attr("top",jQuery(this).position().top);
            jQuery(this).attr("left",jQuery(this).position().left);
            jQuery(this).attr("width",jQuery(this).width());
            jQuery(this).attr("height",jQuery(this).height());
            //console.log(jQuery(this).position().top);
            var curr_top = jQuery(this).position().top * (330/521);
            var curr_left = jQuery(this).position().left * (365.5/577);
            var curr_width = jQuery(this).width(330/9);
            var curr_height = jQuery(this).height(365.5/10);
            jQuery(this).css("top",curr_top + "px");
            jQuery(this).css("left",curr_left + "px");
            jQuery(this).css("width",curr_width + "px");
            jQuery(this).css("height",curr_height + "px");
            //jQuery(this).addClass("scale65");
        });
    }
    jQuery(window).scrollTop(0);
	html2canvas(document.querySelector("#container")).then(function(canvas) {	    
		if(!window.navigator.msSaveBlob) {
			var imglink = document.getElementById('img_link');
			imglink.setAttribute('download', 'screenshot.png');
			imglink.setAttribute('href', canvas.toDataURL("image/png"));
			imglink.click();
		} else {
			window.navigator.msSaveBlob(canvas.msToBlob(), 'screenshot.png');
		}
	});
    
    if(jQuery(document).width()<480)
    {
        jQuery("#container").width(521);
        jQuery("#container").height(577);
        jQuery("#container").removeClass("fitScreen");
        jQuery("#container img").each(function(){    
            jQuery(this).css("top",jQuery(this).attr("top") + "px");
            jQuery(this).css("left",jQuery(this).attr("left") + "px");
            jQuery(this).css("width",jQuery(this).attr("width") + "px");
            jQuery(this).css("height",jQuery(this).attr("height") + "px");
            //jQuery(this).addClass("scale65");
        });
    }
} 

/**
var starCountRef = firebase.database().ref('chinese_chess');
starCountRef.on('value', (snapshot) => {
    var data = snapshot.val();
    var user_move_1 = data['user_move_1'];
    var user_move_2 = data['user_move_2'];
    //console.log(board.pos.sdPlayer);
    if(user_move_1 != "" && board.pos.sdPlayer == 0)
    {
        //console.log(user_move_1);
        //console.log(parseInt(user_move_1.substr(1,1)));
        //console.log(board.pos.sdPlayer);
        var str1 = ASC(user_move_1.substr(0,1));
        var str2 = ASC(user_move_1.substr(1,1));
        var end1 = ASC(user_move_1.substr(2,1));
        var end2 = ASC(user_move_1.substr(3,1));
        //var str1 = ASC(reverse_move(user_move_1.substr(0,1)));
//        var str2 = ASC((9 - parseInt(user_move_1.substr(1,1))).toString());
//        var end1 = ASC(reverse_move(user_move_1.substr(2,1)));
//        var end2 = ASC((9 - parseInt(user_move_1.substr(3,1))).toString());
        
        //console.log(mov);
        
        for(var tt = 1; tt<=100000; tt++)
        {
           if(((tt & 255) & 15) == (str1 - 62) && ((tt & 255) >> 4) == (60 - str2) && ((tt >> 8) & 15) == (end1 - 62) && ((tt >> 8) >> 4) == (60 - end2))
           {
             //console.log(tt);
             //break;
             board.addMove(board.search.searchMain(LIMIT_DEPTH, board.millis,tt), true);
             arr_move = [];
             //board.thinking.style.visibility = "hidden";  
//             if(board.gameType == 1)
//             {
//                  jQuery("#prev_action input[type=button]").css("background","brown");
//                  jQuery("#prev_action input[type=button]").attr('onclick','retract_click();');
//                  jQuery("#start_game_action input[type=button]").css("background","darkblue");
//                  jQuery("#start_game_action input[type=button]").attr('onclick','restart_click();');
//             }
             //board.busy = false;
             //AsyncUpdateMoves();
             board.move_list = [];
            // board.busy = false;
             break;
           }
        }
    }
    
    
    if(user_move_2 != "" && board.pos.sdPlayer == 1)
    {
        //var str1 = ASC(reverse_move(user_move_2.substr(0,1)));
//        var str2 = ASC((9 - parseInt(user_move_2.substr(1,1))).toString());
//        var end1 = ASC(reverse_move(user_move_2.substr(2,1)));
//        var end2 = ASC((9 - parseInt(user_move_2.substr(3,1))).toString());
        var str1 = ASC(user_move_2.substr(0,1));
        var str2 = ASC(user_move_2.substr(1,1));
        var end1 = ASC(user_move_2.substr(2,1));
        var end2 = ASC(user_move_2.substr(3,1));
        //console.log(mov);
        //console.log(board.pos.sdPlayer);
        for(var tt = 1; tt<=100000; tt++)
        {
           if(((tt & 255) & 15) == (str1 - 62) && ((tt & 255) >> 4) == (60 - str2) && ((tt >> 8) & 15) == (end1 - 62) && ((tt >> 8) >> 4) == (60 - end2))
           {
             //console.log(tt);
             //break;
             board.addMove(board.search.searchMain(LIMIT_DEPTH, board.millis,tt), true);
             arr_move = [];
             //board.thinking.style.visibility = "hidden";  
//             if(board.gameType == 1)
//             {
//                  jQuery("#prev_action input[type=button]").css("background","brown");
//                  jQuery("#prev_action input[type=button]").attr('onclick','retract_click();');
//                  jQuery("#start_game_action input[type=button]").css("background","darkblue");
//                  jQuery("#start_game_action input[type=button]").attr('onclick','restart_click();');
//             }
             //board.busy = false;
             //AsyncUpdateMoves();
             board.move_list = [];
            // board.busy = false;
             break;
           }
        }
    }
});
**/

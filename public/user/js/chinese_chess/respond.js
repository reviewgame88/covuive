var fire_base = firebase.database();
var current_city_id = "";
var current_score = "";
var current_board = "";
var interval_coundown = null;
var start_coundown = null;
var check_offline = false;
var blur_win;
var boss_id = ""; 
var user_score = "";
var time_left_1 = 600;
var time_left_2 = 600;
var user_1 = "";
var user_2 = "";
jQuery(document).ready(function(){
    
    
    var width = jQuery(window).width();
    
    jQuery("#pretl").css("display","block");
    jQuery(".anav").css("display","block");
     
    jQuery(".tbvusers").css("display","block");
    jQuery(".navttl").css("display","block");      
    jQuery(".sbfixed").css("display","none");
    
    jQuery(".astat").css("display","none");
    
    if(width<=480)
    {
        jQuery(".nav0").css("display","block");   
        jQuery(".uls2").css("display","none");   
        jQuery(".newtab2").css("display","block");  
        jQuery(".navcont").css("display","none");   
        jQuery("#pretl").css("margin-top","46px");  
        jQuery(".tlst").css("margin-top","0px");         
        jQuery("#mysticky-wrap").css("display","none");
        jQuery(".tsinbo").css("display","none");
        jQuery(".tbvtabs").css("display","block");       
        jQuery(".tsinsb").css("display","block");     
        jQuery(".sbclrd").css("margin-top","45px");   
            
        jQuery(".noth>div").css("margin-top","40%");
        jQuery(".thead").css("display","block");
        jQuery(".thnavcont").css("display","block");
        
        jQuery(".ttlnav").css("display","none");
        jQuery(".ttlnav").next().css("text-align","center");
        
        jQuery("#pretabs").remove();
        jQuery("#appcont").removeClass("aleg");
        jQuery(".tcrdtabcont .tcrdtab .tcrdcell:nth-child(2)").css("display","none");
        jQuery(".tcrdtabcont .tcrdpan>div:nth-child(2)").css("display","none");
        jQuery("#precont").click(function(){
            if(jQuery(".nav0").hasClass("nav0open"))
            {
                jQuery(".nav0").removeClass("nav0open");
            }  
        });
        
        jQuery(".tplext").each(function(){
            jQuery(this).css("display","none");
        });
        
        jQuery(".mbut").click(function(){
            if(jQuery(this).parent().hasClass("nav0open"))
            {
                jQuery(this).parent().removeClass("nav0open");
            }
            else
            {
                jQuery(this).parent().addClass("nav0open");
                get_info_user();
            }       
        });
        
        jQuery(".thnavcont .cmenu").click(function(){
           if(jQuery(".sbclrd").is(":visible")) 
           { 
              jQuery(".sbclrd").css("display","none");
           }     
           else
           {
              jQuery(".sbclrd").css("display","block");
           }
        });
        
        jQuery(".ubut").click(function(){
           if(jQuery(".uls2").is(":visible")) 
           {
              jQuery(".uls2").css("display","none");
              jQuery(".tbvtabs").css("display","block");
           }     
           else
           {
              jQuery(".uls2").css("display","block");
              jQuery(".tbvtabs").css("display","none");
           }
        });
        jQuery(".tcrdcont .tcrdpan>div:first-child").css("min-height",(jQuery(window).height()*0.3));
        jQuery("#main-content").height(jQuery(window).height()-50);
        jQuery("#appcont").height(jQuery(window).height()-50);
        jQuery("#appcont").css("min-height",jQuery(window).height()-50);
    }
    
    jQuery(".ttlcont .ttlnav button").first().click(function(){
        jQuery("#pretl").css("display","block");
        jQuery(".anav").css("display","block");
         
        jQuery(".tbvusers").css("display","block");
        jQuery(".navttl").css("display","block");      
        jQuery(".sbfixed").css("display","none");
        
        jQuery(".astat").css("display","none");
        
        if(width<=480)
        {
            jQuery(".nav0").css("display","block");   
            jQuery(".uls2").css("display","none");   
            jQuery(".newtab2").css("display","block");  
            jQuery(".navcont").css("display","none");   
            jQuery("#pretl").css("margin-top","46px");  
            jQuery(".tlst").css("margin-top","0px");  
            jQuery("#pretabs").remove();
            jQuery("#appcont").removeClass("aleg");
        }
    });
    
    jQuery(".bsbb .butlh").off('click');
    jQuery(".bsbb .butlh").next().css("display","none");
    jQuery(".bsbb .butlh").click(function(){
       if(jQuery(this).next().is(":visible")) 
       {
          jQuery(this).next().css("display","none");
       }     
       else
       {
          jQuery(this).next().css("display","block");
       }
    });
    
    jQuery("#chat_off").click(function(){
       var str = "";
       if(jQuery(this).is(":checked"))
       {
          str += '<div class="tind">+ Tắt chat</div>';
          jQuery('.h1s .bsbb').attr("readonly","");
          jQuery('.h1s .bsbb').css("background","palegoldenrod");
       } 
       else
       {
          str += '<div class="tind">+ Bật chat</div>';
          jQuery('.h1s .bsbb').removeAttr("readonly","");
          jQuery('.h1s .bsbb').css("background","white");
       }
       jQuery(".tcrdpan .msg_area").append(str);
              
       if(jQuery(".bsbb .butlh").next().is(":visible")) 
       {
          jQuery(".bsbb .butlh").next().css("display","none");
       }     
       else
       {
          jQuery(".bsbb .butlh").next().css("display","block");
       }
    });

    jQuery('.h1s .bsbb').keyup(function(e){
        if(e.keyCode == 13)
        {
            if(!jQuery("#chat_off").is(":checked"))
            {
                var d = new Date();
                var n = d.getTime();
                var arr_cmt = {};                              
                  arr_cmt[user_id_temp] = jQuery('.h1s .bsbb').val();
                  jQuery('.h1s .bsbb').val("");
                  fire_base.ref('chinese_chess_comment/'+current_city_id+"-"+current_board+"/"+n).set(arr_cmt)
                  .then(function() {
                  })
                  .catch(function(error) {
                    console.log("error");
                  });
            }
        }
    });
    
    jQuery(".selcsl").change(function(){
        var val_temp = jQuery(this).find(":selected").text();
        if(val_temp.search("(Đầy)")!==-1)
        {
            alert("Phòng đã đầy! Mong bác quay lại sau!");
        }
        else
        {
            val_temp = val_temp.substr(0,val_temp.indexOf("(")-1);        
            jQuery(".selcwr .selcbt").html(val_temp);
            update_quantity_city(jQuery(this).val());
            refreshListBoard(current_city_id);  
        }              
    });
    
    jQuery(".tcrdcell").each(function(){
        jQuery(this).click(function(){
            jQuery(this).parent().find("button[class=active]").removeClass("active");
            jQuery(this).find("button").addClass("active");
            var this_index = jQuery(this).index();
            this_index += 1;
            jQuery(".tcrdpan>div").css("visibility","hidden");
            jQuery(".tcrdpan>div:nth-child("+this_index+")").css("visibility","visible");
        });
    });
    
    jQuery("button.minwd").each(function(){
        jQuery(this).click(function(){           
            jQuery(this).hide();           
            //var getAllBoard = fire_base.ref('chinese_chess_comment/'+current_city_id);
//            getAllBoard.remove();
            var getAllBoard = fire_base.ref('chinese_chess_board/'+current_city_id);
            //getAllBoard.remove();
            max_board = "";
            getAllBoard.orderByKey().limitToLast(1).once('value', (snapshot) => {
                if(snapshot.exists())
                {
                    snapshot.forEach((childSnapshot_temp) => {
                        var max_board = childSnapshot_temp.key;                   
                        max_board = parseInt(max_board) + 1;    
                        var newBoardData = {};
                        newBoardData= {  
                                    act_1 : "",
                                    act_2 : "",
                                    city  : current_city_id,
                                    current_fen : "rnbakabnr/9/1c5c1/p1p1p1p1p/9/9/P1P1P1P1P/1C5C1/9/RNBAKABNR",
                                    extra_time : 0,
                                    name : max_board,
                                    none_rate : 0,
                                    start_fen : "rnbakabnr/9/1c5c1/p1p1p1p1p/9/9/P1P1P1P1P/1C5C1/9/RNBAKABNR",
                                    time_play : 10,
                                    time_user_1 : 600,
                                    time_user_2 : 600,
                                    u_s1 : "",
                                    u_s2 : "",
                                    undo : 0,
                                    user_id_1 : "",
                                    user_id_2 : "",
                                    user_move_1 : "",
                                    user_move_2 : "",
                                    boss_id : user_id_temp,
                                    start : 0,
                                    limit : 0
                         };
                         current_board = max_board;
                         fire_base.ref('chinese_chess_board/'+current_city_id+"/"+max_board).set(newBoardData)
                          .then(function() {             
                              boss_id =  user_id_temp; 
                              inGame(max_board,"create");
                              jQuery(".nowrel .mlh").html("Key: "+user_id_temp);
                              jQuery(".time_left_user_1").html("10:00");
                              jQuery(".time_left_user_2").html("10:00");
                          })
                          .catch(function(error) {
                            console.log("error");
                          });                   
                    });               
                }
                else
                {
                    max_board = 1;   
                    var newBoardData = {};
                    newBoardData[current_city_id] = {};
                    newBoardData[current_city_id][max_board] = {  
                                act_1 : "",
                                act_2 : "",
                                city  : current_city_id,
                                current_fen : "rnbakabnr/9/1c5c1/p1p1p1p1p/9/9/P1P1P1P1P/1C5C1/9/RNBAKABNR",
                                extra_time : 0,
                                name : max_board,
                                none_rate : 0,
                                start_fen : "rnbakabnr/9/1c5c1/p1p1p1p1p/9/9/P1P1P1P1P/1C5C1/9/RNBAKABNR",
                                time_play : 10,
                                time_user_1 : 600,
                                time_user_2 : 600,
                                u_s1 : "",
                                u_s2 : "",
                                undo : 0,
                                user_id_1 : "",
                                user_id_2 : "",
                                user_move_1 : "",
                                user_move_2 : "",
                                boss_id : user_id_temp,
                                start : 0,
                                limit : 0
                    }; 
                    current_board = max_board;
                    fire_base.ref('chinese_chess_board/').set(newBoardData)
                    .then(function() {
                         inGame(max_board,"create");
                         boss_id =  user_id_temp;  
                         jQuery(".nowrel .mlh").html("Key: "+user_id_temp);  
                         jQuery(".time_left_user_1").html("10:00");
                         jQuery(".time_left_user_2").html("10:00");                  
                    })
                      .catch(function(error) {
                        console.log("error");
                    });                                  
                 }
            });
        });
    });
    jQuery("script").html("");
});

window.onblur = function() { 
     var act = {};
     if(user_id_temp == user_1 || user_id_temp == user_2)
     {
         if(user_id_temp == user_1)
         {
            act = { act_1 : "blur" };
         }
         else if(user_id_temp == user_2)
         {
            act = { act_2 : "blur" };
         }
         
         fire_base.ref('chinese_chess_board/'+current_city_id+"/"+current_board).update(act).then(function() { 
            blur_win = setTimeout(function(){ 
                ///console.log(11);
                if(!check_offline)
                {   
                    fire_base.goOffline(); 
                    check_offline = true;
                    console.log("stop_data");
                    clearTimeout(blur_win);
                }
            }, 60000);
         })
         .catch(function(error) {
         });
     }  
}

window.onfocus = function() {
    var act = {};
    
    if(user_id_temp == user_1 || user_id_temp == user_2)
    {
         if(user_id_temp == user_1)
         {
            act = { act_1 : "focus" };
         }
         else if(user_id_temp == user_2)
         {
            act = { act_2 : "focus" };
         }
         //console.log(current_city_id);
         //console.log(current_board);
        fire_base.ref('chinese_chess_board/'+current_city_id+"/"+current_board).update(act).then(function() { 
            clearTimeout(blur_win);
         })
         .catch(function(error) {
        });
    }       
}

addCity();
function get_pre_info()
{
    fire_base.ref('city').once('value', (snapshot) => {
      var str = ""; 
      var list_tp = {};
      snapshot.forEach((childSnapshot) => {
        var childKey = childSnapshot.key;
        var childData = childSnapshot.val();
        list_tp[childKey] = childData;
        if(parseInt(childData['total_player'])>=100)
        {
            str += "<option value='"+childKey+"'>"+childData['name']+" (Đầy)</option>";
        }
        else
        {
            str += "<option value='"+childKey+"'>"+childData['name']+" ("+childData['total_player']+")</option>";
        }
      });
      jQuery(".selcsl").each(function(){
        jQuery(this).html(str);
      });
      
      var getCurrentUser = fire_base.ref('user/'+user_id_temp);
      getCurrentUser.once('value', (snapshot) => {
        if(snapshot.exists())
        {
            current_city_id = snapshot.val().on_city;
            current_score = snapshot.val().score_game;    
            jQuery(".selcwr .selcbt").html(list_tp[current_city_id]['name']);
            jQuery(".selcsl option[value="+current_city_id+"]").attr("selected","");
            refreshListBoard(current_city_id);
            refreshListUser(current_city_id);   
        } 
      });  
      
      var getCurrentUser = fire_base.ref('chinse_chess_score/'+user_id_temp);
      getCurrentUser.once('value', (snapshot) => {
            if(snapshot.exists())
            {
                var arr_data = {
                    game_out : snapshot.val().game_out,
                    lost : snapshot.val().lost,
                    rank : snapshot.val().rank,
                    score_game : snapshot.val().score,
                    total_game : snapshot.val().total_game,
                    win : snapshot.val().win,
                    on_game : 1
                }
                fire_base.ref('user/'+user_id_temp).update(arr_data);  
            } 
      });
    });
}
var refListBoard = setInterval(function(){ 
    if(current_city_id!="")
    {
        refreshListBoard(current_city_id);  
    }
}, 5000);

var refListUser = setInterval(function(){ 
    if(current_city_id!="")
    {
        refreshListUser(current_city_id);  
    }
}, 5000);

function refreshListBoard(city_id)
{  
    var getAllBoard = fire_base.ref('chinese_chess_board/'+city_id);

    getAllBoard.orderByKey().limitToLast(60).once('value', (snapshot) => {
      //var all_board = snapshot.val();  
      var arr_temp = [];
      snapshot.forEach((childSnapshot_temp) => {
        var childKey = childSnapshot_temp.key;
        var childData = childSnapshot_temp.val();
        var play_num = 1;
        if(childData['user_id_1']!="" && childData['user_id_2']!="")
        {
            play_num = 2;
        }
        arr_temp.push({pl_num : play_num, id : childKey, value : childData});
      });
      arr_temp.sort( function ( a, b ) { return a.pl_num - b.pl_num; } );
      //console.log(arr_temp);
      var str = "";
      for(var i_r in arr_temp)
      {        
         str +=  '<a class="awrap dcpd" onclick="inGame('+arr_temp[i_r]['id']+',\'view\');" id="chess_game_'+arr_temp[i_r]['id']+'">'
                +'   <div class="tmaxw">'
                +'      <div class="tnum">#'+arr_temp[i_r]['value']['name']+'</div>'
                +'      <div class="tpar1">'+arr_temp[i_r]['value']['time_play']+'m</div>'
                +'      <div class="tplbl">'
                +'         <div class="tplnorm">'
                +'            <div class="r2"></div>'
                +'            '+arr_temp[i_r]['value']['user_id_1']+'<span class="tplrn snum">'+arr_temp[i_r]['value']['u_s1']+'</span>'
                +'         </div>'
                +'         <div class="tplnorm">'
                +'            <div class="r2"></div>'
                +'            '+arr_temp[i_r]['value']['user_id_2']+'<span class="tplrn snum">'+arr_temp[i_r]['value']['u_s2']+'</span>'
                +'         </div>'
                +'         <div class="tpar0">'
                +'            <div class="rnone"></div>'
                +'            '+arr_temp[i_r]['value']['time_play']+'m'
                +'         </div>'
                +'      </div>'
                +'      <div class="tjoin"><button class="butbl">&gt;&gt;</button></div>'
                +'   </div>'
                +'</a>';
      }
      jQuery(".tlst").html(str); 
    });
    return;
}

function get_info_user()
{
    var getCurrentUser = fire_base.ref('user/'+user_id_temp);
    getCurrentUser.once('value', (snapshot) => {
    
        //current_city_id = snapshot.val().on_city;
        //console.log(current_city_id);
        //snapshot.forEach((childSnapshot_temp) => {
            var childKey = snapshot.key;
            var childData = snapshot.val();
            jQuery(".msub p").html("<b>"+user_id_temp+"</b>");
            jQuery(".snum").html("<b>"+childData['score_game']+"</b>");
            jQuery(".mlst .btab").html("#"+childData['on_board']);
            
            user_score = childData['score_game'];
        //});
    }); 
    return;
}

/**
{
"movies": {
    "movie1": {
        "genre": "comedy",
        "name": "As good as it gets",
        "lead": "Jack Nicholson"
    },
    "movie2": {
        "genre": "Horror",
        "name": "The Shining",
        "lead": "Jack Nicholson"
    },
    "movie3": {
        "genre": "comedy",
        "name": "The Mask",
        "lead": "Jim Carrey"
    }
  }  
 }
https://stackoverflow.com/questions/26700924/query-based-on-multiple-where-clauses-in-firebase/26701282#26701282
**/
function refreshListUser(city_id)
{
    var getAllBoard = fire_base.ref('user');
    
    getAllBoard.orderByChild("on_city")
      .equalTo(parseInt(city_id))
      .once('value', function(snapshot) { 
          var str = "";
          
          snapshot.forEach((childSnapshot_temp) => {
            var childKey = childSnapshot_temp.key;
            var childData = childSnapshot_temp.val();
            str +=   '<tr class="info_player" onclick="get_user(this);" user_id="'+childKey+'" on_board="'+childData['on_board']+'" game_out="'+childData['game_out']+'" lost="'+childData['lost']+'" win="'+childData['win']+'" rank="'+childData['rank']+'" score_game="'+childData['score_game']+'" total_game="'+childData['total_game']+'" win="'+childData['win']+'">'
                    +'    <td>'
                    +'        <div class="ulnm">'
                    +'            <div class="r2"></div>'
                    +'            '+childKey+'<span class="ulla ulla0"></span>'
                    +'        </div>'
                    +'    </td>'
                    +'    <td class="m0ac ulnu">'+childData['score_game']+'</td>'
                    +'    <td class="m0ac ulnu" board_id="'+childData['on_board']+'">#</td>'
                    +'</tr>';
          });   
          jQuery(".uls2 tr").not(":first-child").remove(); 
          jQuery(".uls2").append(str);  
      });  
      return;  
}



function update_quantity_city(city_id)
{
  city_id = parseInt(city_id);               
  current_city_id = city_id;
  var getCurrentUser = fire_base.ref('user/'+user_id_temp);
  var current_city = "";
  
  getCurrentUser.once('value', (snapshot) => {
    //console.log(snapshot.val());
        var current_city = snapshot.val().on_city;
        subOnPlayer(current_city);
        fire_base.ref('user/'+user_id_temp).update({"on_city" : city_id});         
   });  
   addOnPlayer(city_id);       
   return;
}

function get_user(obj)
{
    jQuery(".noth").css("display","");
    jQuery(".bsbb>.fb").html(jQuery(obj).attr("user_id"));
    jQuery(".bsbb .total_game").html(jQuery(obj).attr("total_game"));
    jQuery(".bsbb .mbh .minw").html("#"+jQuery(obj).attr("on_board"));
    return;
}

function inGame(boardId, act)
{
    jQuery("#pretl").css("display","none");
    jQuery(".anav").css("display","none");
     
    jQuery(".tbvusers").css("display","none");
    jQuery(".navttl").css("display","none");      
    jQuery(".sbfixed").css("display","");
    
    jQuery("div.tsinbo").css("visibility","visible");
    
    //
    //jQuery(".usno").css("visibility","hidden");
    //jQuery(".astat").css("display","");
    
    fire_base.ref('user/'+user_id_temp).update({on_board : boardId}); 
    //jQuery("#pl_user_id_1").html(user_id_temp);
    if(act == "view")
    {
        getBoardData(boardId);
        current_board = boardId;        
    }
    return;
}

function getBoardData(boardId)
{
    var getCurrentUser = fire_base.ref('chinese_chess_board/'+current_city_id+"/"+boardId);
        getCurrentUser.once('value', (snapshot) => {
        if(snapshot.exists())
        {    
            actGetBoardData(snapshot)   
        }     
    });
    return;
}

function actGetBoardData(sns)
{
    jQuery(".nowrel .mlh").html("Key: "+sns.val().boss_id);
    if(sns.val().user_id_1=="")
    {
        user_id_1 = "-";
    }
    else
    {
        user_id_1 =  sns.val().user_id_1;
    }
    if(sns.val().user_id_2=="")
    {
        user_id_2 = "-";
    }
    else
    {
        user_id_2 =  sns.val().user_id_2;
    }
    user_1 = user_id_1;
    user_2 = user_id_2;        
    jQuery("div#pl_user_id_1").html(user_id_1);
    jQuery("div#pl_user_id_2").html(user_id_2);
    jQuery(".mbsp select option").each(function(){
        if(jQuery(this).val()!=sns.val().limit)
        {
            jQuery(this).removeAttr("selected");
        }
        else
        {
            jQuery(this).attr("selected","");
        }
    });
    jQuery(".mbsp select").val(sns.val().limit);
    jQuery(".mbsp select").attr("disabled","");
    
    if(sns.val().none_rate == 1)
    {
        jQuery("#none_rate").attr("checked","");
    }
    jQuery("#none_rate").attr("disabled","");
    if(sns.val().undo == 1)
    {
        jQuery("#undo").attr("checked","");
    }
    jQuery("#undo").attr("disabled","");
    
    jQuery("select#game_time option").each(function(){
        if(jQuery(this).val()!=sns.val().time_play)
        {
            jQuery(this).removeAttr("selected");
        }
        else
        {
            jQuery(this).attr("selected","");
        }
    });
    jQuery("select#game_time").val(sns.val().time_play);
    jQuery("select#game_time").attr("disabled","");
    
    jQuery("select#extra_time option").each(function(){
        if(jQuery(this).val()!=sns.val().extra_time)
        {
            jQuery(this).removeAttr("selected");
        }
        else
        {
            jQuery(this).attr("selected","");
        }
    });
    jQuery("select#extra_time").val(sns.val().extra_time);
    jQuery("select#extra_time").attr("disabled","");

    //jQuery(".time_left_user_1").html(updateTimeLeft(sns.val().time_user_1));
    //jQuery(".time_left_user_2").html(updateTimeLeft(sns.val().time_user_2));
    
    if(jQuery("#pl_user_id_1").html()!="-")
    {
        jQuery("#pl_user_id_1").parent().prev().attr("disabled","");
        jQuery("#pl_user_id_1").parent().prev().css("visibility","hidden");
        jQuery("div#pl_user_id_1").parent().css("visibility","visible");
        if(user_id_temp != sns.val().boss_id && user_id_temp!= user_id_1)
        {
            jQuery("div#pl_user_id_1").prev().css("display","none");
        }
    }
    if(jQuery("#pl_user_id_2").html()!="-")
    {
        jQuery("#pl_user_id_2").parent().prev().attr("disabled","");
        jQuery("#pl_user_id_2").parent().prev().css("visibility","hidden");
        jQuery("div#pl_user_id_2").parent().css("visibility","visible");
        if(user_id_temp != sns.val().boss_id && user_id_temp!= user_id_2)
        {
            jQuery("div#pl_user_id_2").prev().css("display","none");
        }
    } 
    
    if(sns.val().act_1 == "blur")
    {
        jQuery("#pl_user_id_1").parent().css("background","darkgrey");
    }
    else
    {
        jQuery("#pl_user_id_1").parent().css("background","white");
    }
    
    if(sns.val().act_2 == "blur")
    {
        jQuery("#pl_user_id_2").parent().css("background","darkgrey");
    }
    else
    {
        jQuery("#pl_user_id_2").parent().css("background","white");
    }

    
    var total_ply = 0;
    jQuery("div[id^=pl_user_id]").each(function(){
        if(jQuery(this).html()!="-")
        {
           total_ply++; 
        }
    });
    
    if(total_ply == 0)
    {
        jQuery(".bsbb .tstatlabl").html("Mời bác chọn bên!");
    }
    else if(total_ply==1)
    {
        if(user_id_temp == user_id_1 || user_id_temp == user_id_2)
        {
            jQuery(".bsbb .tstatlabl").html("Xin chờ đối thủ!");
            if(user_id_temp == user_id_1)
            {
                jQuery("#pl_user_id_2").parent().prev().attr("disabled","");
            }
            else if(user_id_temp == user_id_2)
            {
                jQuery("#pl_user_id_1").parent().prev().attr("disabled","");
            }
        }
        else
        {
            jQuery(".bsbb .tstatlabl").html("Mời bác chọn bên!");
        }
    }
    else if(total_ply == 2)
    {
        if(sns.val().start==0)
        {
            var start_time = 11;
            if(start_coundown === null)
            {
                start_coundown = setInterval( function(){                           
                                   start_time--;
                                   jQuery(".tstatlabl").html("Đếm ngược : "+updateTimeLeft(start_time));
                                   if(start_time == 0)
                                   {
                                      //clearInterval(start_coundown);
                                      start_game(user_id_1, user_id_2);
                                   }
                                }, 1000);
            }                 
        }                
    }  
}


function time_left(target)
{
    clearInterval(interval_coundown); 
    var getCurrentUser = fire_base.ref('chinese_chess_board/'+current_city_id+"/"+current_board);
        getCurrentUser.once('value', (snapshot) => {
            var childData = snapshot.val();
            time_left_1 = childData['time_user_1'];
            time_left_2 = childData['time_user_2'];
            if(target == "user_1")
            {    
                //if(interval_coundown === null)
                //{
                    interval_coundown = setInterval( function(){    
                       time_left_1--;
                       jQuery(".time_left_user_1").html(updateTimeLeft(time_left_1));
                    }, 1000);
                //}
            }
            else
            {
                //if(interval_coundown === null)
                //{
                    interval_coundown = setInterval( function(){
                       time_left_2--;
                       jQuery(".time_left_user_2").html(updateTimeLeft(time_left_2));
                    }, 1000);
                //}
            }
    });      
}

function convertStrTime(str)
{
    var str_temp = str.split(":");
    return parseInt(str_temp[0])*60 + parseInt(str_temp[1]);
}

function updateTimeLeft(strTime)
{
    var minute = Math.floor(strTime/60);
    minute = (minute<10 ? "0" + minute : minute);
    var second = strTime%60;
    second = (second<10 ? "0" + second : second);
    return minute + ":" + second;
}

function selectSide(obj)
{
    jQuery(obj).attr("disabled","");
    var user_id_1 = "";
    var user_id_2 = "";
    if(jQuery(obj).html()=="#1")
    {
        fire_base.ref('chinese_chess_board/'+current_city_id+"/"+current_board).update({user_id_1 : user_id_temp, u_s1 : user_score, act_1 : "focus"});
        //jQuery("#pl_user_id_1").html(user_id_temp);
        jQuery(obj).next().css("visibility","visible");
        jQuery("button.butsit").each(function(){
            if(jQuery(this).html()=="#2")
            {
                jQuery(this).attr("disabled","");
            }
        });
    }
    else
    {
        fire_base.ref('chinese_chess_board/'+current_city_id+"/"+current_board).update({user_id_2 : user_id_temp, u_s2 : user_score, act_2 : "focus"});
        //jQuery("#pl_user_id_2").html(user_id_temp);
        jQuery(obj).next().css("visibility","visible");
        jQuery("button.butsit").each(function(){
            if(jQuery(this).html()=="#1")
            {
                jQuery(this).attr("disabled","");
            }
        });
    }
    
    //var total_ply = 0;
//    jQuery("div[id^=pl_user_id]").each(function(){
//        if(jQuery(this).html()!="-")
//        {
//           total_ply++; 
//           if(jQuery(this).attr("id")=="pl_user_id_1")
//           {
//              user_id_1 = jQuery(this).html();
//           }
//           else if(jQuery(this).attr("id")=="pl_user_id_2")
//           {
//              user_id_2 = jQuery(this).html();
//           }
//        }
//    });
//    if(total_ply==1)
//    {
//        jQuery(".bsbb .tstatlabl").html("Xin chờ đối thủ!");
//    }
//    else if(total_ply == 2)
//    {
        //var start_time = 16;
//        
//        if(start_coundown === null)
//        {
//                start_coundown = setInterval( function(){                           
//                                   start_time--;
//                                   jQuery(".tstatlabl").html("Đếm ngược : "+updateTimeLeft(start_time));
//                                   if(start_time == 0)
//                                   {
//                                      //clearInterval(start_coundown);
//                                      start_game(user_id_1, user_id_2);
//                                   }
//                                }, 1000);
//        }               
    //}
}

function addCity()
{            
    var getCurrentUser = fire_base.ref('user/'+user_id_temp);
        getCurrentUser.once('value', (snapshot) => {
        if(snapshot.exists())
        {    
            var childKey = snapshot.key;
            var childData = snapshot.val();
            if(childData['on_city']=="")
            {
                var newCity = "";
                var get_total_city = fire_base.ref('city');
                get_total_city.orderByChild("total_player").once('value', (snapshot) => {
                    snapshot.forEach((childSnapshot_temp) => { 
                        var childData_val = childSnapshot_temp.val();
                        //console.log(childData_val['total_player']);
                        if(childData_val['total_player']<100)
                        {
                            newCity = childSnapshot_temp.key;
                        }
                        else
                        {
                            return true;
                        }
                    });    
                    newCity = parseInt(newCity);                 
                    fire_base.ref('user/'+user_id_temp).update({on_city : newCity}).then(function() {   
                        addOnPlayer(newCity);
                        current_city_id = newCity;
                    })
                    .catch(function(error) {
                    });    
                });
            }
        }     
        else
        {
            var newCity = "";
            var get_total_city = fire_base.ref('city');
            get_total_city.orderByChild("total_player").once('value', (snapshot) => {
                snapshot.forEach((childSnapshot_temp) => { 
                    var childData_val = childSnapshot_temp.val();
                    //console.log(childData_val['total_player']);
                    if(childData_val['total_player']<100)
                    {
                        newCity = childSnapshot_temp.key;
                    }
                    else
                    {
                        return true;
                    }
                });    
                newCity = parseInt(newCity);                                   
                var newUser = {};
                newUser = {  
                            "game_out" : 0,
                            "lost" : 0,
                            "on_board" : 0,
                            "on_city" : newCity,
                            "on_game" : 0,
                            "play" : 0,
                            "rank" : 0,
                            "score_game" : 1000,
                            "status" : 1,
                            "total_game" : 0,
                            "win" : 0
                };
                
                fire_base.ref('user/'+user_id_temp).set(newUser).then(function() {
                    addOnPlayer(newCity);
                    current_city_id = newCity;
                })
                .catch(function(error) {
                });                
                
                var newScore = {};
                newScore= {  
                          "game_out" : 0,
                          "lost" : 0,
                          "rank" : 0,
                          "score" : 1000,
                          "total_game" : 0,
                          "win" : 0
                };
                
                fire_base.ref('chinse_chess_score/'+user_id_temp).set(newScore).then(function() {    
                    
                })
                .catch(function(error) {
                    console.log("error");
                });                  
            });
            
        }
    });
    
    get_pre_info();
    return;
}

function addOnPlayer(city_id)
{
    var getCurrentUser = fire_base.ref('city/'+city_id);
        getCurrentUser.once('value', (snapshot) => {
            fire_base.ref('city/'+city_id).update({"total_player" : parseInt(snapshot.val().total_player)+1});        
        });
    return;    
}

function subOnPlayer(city_id)
{
    var getCurrentUser = fire_base.ref('city/'+city_id);
        getCurrentUser.once('value', (snapshot) => {
            fire_base.ref('city/'+city_id).update({"total_player" : parseInt(snapshot.val().total_player)-1});        
        });
    return;    
}

function outPosition(obj)
{   
    var user_target = jQuery(obj).next().html();
    var target = jQuery(obj).next().attr("id");
    var getCurrentUser = fire_base.ref('chinese_chess_board/'+current_city_id+"/"+current_board);
        getCurrentUser.once('value', (snapshot) => {
        boss_id = snapshot.val().boss_id;
        if(user_id_temp == boss_id || user_target == user_id_temp)
        {           
            if(target=="pl_user_id_1")
            {
                fire_base.ref('chinese_chess_board/'+current_city_id+"/"+current_board).update({user_id_1 : "", u_s1 : 0, act_1 : ""});
                fire_base.ref('user/'+user_target).update({on_game : 0}); 
                jQuery(obj).parent().prev().removeAttr("disabled","");
                jQuery(obj).parent().prev().css("visibility","visible");
                jQuery(obj).parent().css("visibility","hidden");
                jQuery(obj).next().html("-");
                if(jQuery("#pl_user_id_2").html()=="-")
                {
                    jQuery("#pl_user_id_2").parent().prev().removeAttr("disabled","");
                }
            }
            else
            {
                fire_base.ref('chinese_chess_board/'+current_city_id+"/"+current_board).update({user_id_2 : "", u_s2 : 0, act_2 : ""});
                fire_base.ref('user/'+user_target).update({on_game : 0}); 
                jQuery(obj).parent().prev().removeAttr("disabled","");
                jQuery(obj).parent().prev().css("visibility","visible");
                jQuery(obj).parent().css("visibility","hidden");
                jQuery(obj).next().html("-");
                if(jQuery("#pl_user_id_1").html()=="-")
                {
                    jQuery("#pl_user_id_1").parent().prev().removeAttr("disabled","");
                }
            }
        }
    });
    return true; 
}

function start_game(user_id_1, user_id_2)
{
      selMoveList.options.length = 1;
      selMoveList.selectedIndex = 0;
      board.gameType = 1;
      board.sellMode = 2;
      //jQuery("#selMoveMode").val(2);
      if(user_id_temp == user_id_2)
      {
            board.computer = 0;
            board.start_target = 2;
      }
      else
      {
            if(user_id_temp!=user_id_1)
            {
                board.viewer = 1;
            }
            board.computer = 1 - selMoveMode.selectedIndex;
            board.start_target = 1;
      }
      board.start_game = 1;
      board.restart(STARTUP_FEN[selHandicap.selectedIndex]);
      
      var option_game = {};
      if(user_id_temp == boss_id)
      {
        option_game['start'] = 1;
        option_game['limit'] = jQuery(".mbsp select").val();
        option_game['none_rate'] = ( jQuery("#none_rate").is(":checked") ? 1 : 0);
        option_game['time_play'] = jQuery("select#game_time").val();
        option_game['time_user_1'] = parseInt(jQuery("select#game_time").val())*60;
        option_game['time_user_2'] = parseInt(jQuery("select#game_time").val())*60;
        option_game['extra_time'] = jQuery("select#extra_time").val();
        option_game['undo'] = ( jQuery("#undo").is(":checked") ? 1 : 0);
      }
      //console.log(option_game);
      fire_base.ref('chinese_chess_board/'+current_city_id+"/"+current_board).update(option_game);
      clearInterval(start_coundown);
      time_left("user_1");
      jQuery(".tsinbo").css("visibility","hidden");
      
      jQuery("div.steps table tbody tr").not(":first").remove();
      jQuery("div.steps table tbody tr").first().addClass("active");
      
      jQuery("div[id^=pl_user_id]").each(function(){
        jQuery(this).prev().css("display","none");
      });
      /**
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
      **/
      board.move_list = [];
      AsyncUpdateMoves();
      return true;
}

function updateMov(sns)
{
    if(sns.val()!=="")
    {
        var data = sns.val();
        var user_move_1 = data['user_move_1'];
        var user_move_2 = data['user_move_2'];
        //console.log(board.pos.sdPlayer);
        if(user_move_1 != "" && user_move_2 != "")
        {
            clearInterval(interval_coundown); 
        }    
        if(user_move_1 != "" && board.pos.sdPlayer == 0)
        {
            var str1 = ASC(user_move_1.substr(0,1));
            var str2 = ASC(user_move_1.substr(1,1));
            var end1 = ASC(user_move_1.substr(2,1));
            var end2 = ASC(user_move_1.substr(3,1));
            
            for(var tt = 1; tt<=100000; tt++)
            {
               if(((tt & 255) & 15) == (str1 - 62) && ((tt & 255) >> 4) == (60 - str2) && ((tt >> 8) & 15) == (end1 - 62) && ((tt >> 8) >> 4) == (60 - end2))
               {
                 board.addMove(board.search.searchMain(LIMIT_DEPTH, board.millis,tt), true);
                 arr_move = [];
                 board.move_list = [];
                 break;
               }
            }
                  
            fire_base.ref('chinese_chess_board/'+current_city_id+"/"+current_board).update({time_user_1 : time_left_1})
            .then(function() {    
                //jQuery(".time_left_user_1").html(updateTimeLeft(time_left_1));     
                time_left("user_2");
            })
            .catch(function(error) {
                console.log("error");
            });                               
        }
        
        if(user_move_1!="" && board.pos.sdPlayer == 1)
        {
            time_left("user_2");
        }
        
        if(user_move_2 != "" && board.pos.sdPlayer == 1)
        {
            var str1 = ASC(user_move_2.substr(0,1));
            var str2 = ASC(user_move_2.substr(1,1));
            var end1 = ASC(user_move_2.substr(2,1));
            var end2 = ASC(user_move_2.substr(3,1));
            for(var tt = 1; tt<=100000; tt++)
            {
               if(((tt & 255) & 15) == (str1 - 62) && ((tt & 255) >> 4) == (60 - str2) && ((tt >> 8) & 15) == (end1 - 62) && ((tt >> 8) >> 4) == (60 - end2))
               {
                 board.addMove(board.search.searchMain(LIMIT_DEPTH, board.millis,tt), true);
                 arr_move = [];
                 board.move_list = [];
                 break;
               }
            }
            fire_base.ref('chinese_chess_board/'+current_city_id+"/"+current_board).update({time_user_2 : time_left_2})
            .then(function() {    
                //jQuery(".time_left_user_2").html(updateTimeLeft(time_left_2)); 
                time_left("user_1");
            })
            .catch(function(error) {
                console.log("error");
            });                 
        } 
        if(user_move_2!="" && board.pos.sdPlayer == 0)
        {
            time_left("user_1");
        }
    }
}


/** lang nghe sk **/

function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp * 1000);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  var sec = a.getSeconds();
  var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
  return time;
}

 var interv =  setInterval(function(){ 
                if(current_city_id!="" && current_board!="")
                {
                    clearInterval(interv);
                      fire_base.ref('chinese_chess_comment/'+current_city_id+'-'+current_board).on('child_added', (snapshot) => {
                      if(!jQuery("#chat_off").is(":checked"))
                      {  
                          if(snapshot.exists())
                          {   
                             snapshot.forEach((childSnapshot_temp) => {
                                var child_key = childSnapshot_temp.key;
                                var child_val = childSnapshot_temp.val();
                                str = "<div class='tind'><span class='user_msg'>"+child_key + "</span>: "+child_val+"</div>";
                                jQuery(".tcrdpan .msg_area").append(str);   
                                jQuery(".tcrdpan .msg_area").scrollTop(jQuery( ".tcrdpan .msg_area" ).height());                                                                       
                             });      
                          }  
                      }
                    });
                    fire_base.ref('chinese_chess_board/'+current_city_id+"/"+current_board).on('value', (snapshot) => {
                        
                      if(snapshot.exists())
                      {   
                            actGetBoardData(snapshot);
                            updateMov(snapshot);    
                      }  
                    });
               } 
            }, 500);
   
    
fire_base.ref('city').on('child_changed', (snapshot) => {
  var str = ""; 
  var childKey = snapshot.key;
  var childData = snapshot.val();  
  if(parseInt(childData['total_player'])>=100)
  {
    str = childData['name']+" (Đầy)";
  }
  else
  {
    str = childData['name']+" ("+childData['total_player']+")";
  }
  jQuery(".selcsl option[value="+snapshot.key+"]").html(str); 
});

/** end **/


//function sleepFor( sleepDuration ){
//    var now = new Date().getTime();
//    while(new Date().getTime() < now + sleepDuration){ /* do nothing */ } 
//}


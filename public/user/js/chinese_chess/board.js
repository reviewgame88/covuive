/*
board.js - Source Code for XiangQi Wizard Light, Part IV

XiangQi Wizard Light - a Chinese Chess Program for JavaScript
Designed by Morning Yellow, Version: 1.0, Last Modified: Sep. 2012
Copyright (C) 2004-2012 www.xqbase.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

"use strict";

var arr_move = [];
var RESULT_UNKNOWN = 0;
var RESULT_WIN = 1;
var RESULT_DRAW = 2;
var RESULT_LOSS = 3;

var BOARD_WIDTH = 521;
var BOARD_HEIGHT = 577;
var SQUARE_SIZE = 57;
var SQUARE_LEFT = (BOARD_WIDTH - SQUARE_SIZE * 9) >> 1;
var SQUARE_TOP = (BOARD_HEIGHT - SQUARE_SIZE * 10) >> 1;
var THINKING_SIZE = 32;
var THINKING_LEFT = (BOARD_WIDTH - THINKING_SIZE) >> 1;
var THINKING_TOP = (BOARD_HEIGHT - THINKING_SIZE) >> 1;
var MAX_STEP = 8;
var PIECE_NAME = [
  "oo", null, null, null, null, null, null, null,
  "rk", "ra", "rb", "rn", "rr", "rc", "rp", null,
  "bk", "ba", "bb", "bn", "br", "bc", "bp", null,
];

//var vnPiece = { c: "P", h: "M", r: "X", o: "C", e: "V", a: "S", k: "T" };

function convert_img_to_piece(c) {
  switch (c) {
  case "a":
    return "S";
  case "b":
    return "V";
  case "c":
    return "P";
  case "k":
    return "T";
  case "n":
    return "M";
  case "p":
    return "C";
  case "r":
    return "X";
  default:
    return -1;
  }
}

function SQ_X(sq) {
  return SQUARE_LEFT + (FILE_X(sq) - 3) * SQUARE_SIZE;
}

function SQ_Y(sq) {
  return SQUARE_TOP + (RANK_Y(sq) - 3) * SQUARE_SIZE;
}

function MOVE_PX(src, dst, step) {
  return Math.floor((src * step + dst * (MAX_STEP - step)) / MAX_STEP + .5) + "px";
}

function alertDelay(message) {
  //setTimeout(function() {
      jQuery("#message_area_84423 marquee").html(message);
  //}, 250);
  jQuery("#message_area_84423").fadeIn("slow");
}

function Board(container, images, sounds, start_fen, check_bl = "") {
    
  if(typeof start_fen === 'undefined')
  {
     var start_fen = "rnbakabnr/9/1c5c1/p1p1p1p1p/9/9/P1P1P1P1P/1C5C1/9/RNBAKABNR w - - 0 1";
  }          
  //console.log(start_fen);
  this.images = images;
  this.sounds = sounds;  
  this.pos = new Position();
  this.pos.fromFen(start_fen);
  this.animated = true;
  this.sound = true;
  this.search = null;
  this.imgSquares = [];
  this.sqSelected = 0;
  this.mvLast = 0;
  this.millis = 0;
  this.computer = -1;
  this.gameType = 1;
  this.sellMode = 0;
  this.result = RESULT_UNKNOWN;
  this.busy = false;
  this.search_mov = ""; 
  this.move_list = []; 
  this.check_black = check_bl;
  this.start_target = 1;
  this.viewer = -1;
  this.start_game = -1;
  var style = container.style;
  
  style.position = "relative";
  style.width = BOARD_WIDTH + "px";
  style.height = BOARD_HEIGHT + "px";
  style.background = "url(../../../cvv/ChineChess/" + images + "board.jpg)";
  var this_ = this;
  for (var sq = 0; sq < 256; sq ++) {
    if (!IN_BOARD(sq)) {
      this.imgSquares.push(null);
      continue;
    }
    var img = document.createElement("img");
    var style = img.style;
    style.position = "absolute";
    style.left = SQ_X(sq) + "px";
    style.top = SQ_Y(sq) + "px";
    style.width = SQUARE_SIZE;
    style.height = SQUARE_SIZE;
    style.zIndex = 0;
    img.onmousedown = function(sq_) {
      return function() {
        this_.clickSquare(sq_);
      }
    } (sq);
    container.appendChild(img);
    this.imgSquares.push(img);
  }

  this.thinking = document.createElement("img");
  this.thinking.src = "../../../cvv/ChineChess/" + images + "thinking.gif";
  //console.log(this.thinking);
  style = this.thinking.style;
  style.visibility = "hidden";
  style.position = "absolute";
  style.left = THINKING_LEFT + "px";
  style.top = THINKING_TOP + "px";
  container.appendChild(this.thinking);
  this.dummy = document.createElement("div");
  this.dummy.style.position = "absolute";
  container.appendChild(this.dummy);   
  if(start_fen.indexOf(" b") !== -1 && jQuery("#selMoveMode").val() == 0)
  {
      //this.computer = 1;
      //this.pos.sdPlayer = 0;
  } 
  this.flushBoard();
  
}

Board.prototype.playSound = function(soundFile) {
  if (!this.sound) {
    return;
  }
  try {
    new Audio("../../../cvv/ChineChess/" + this.sounds + soundFile + ".wav").play();
  } catch (e) {
    this.dummy.innerHTML= "<embed src=\"" + this.sounds + soundFile +
        ".wav\" hidden=\"true\" autostart=\"true\" loop=\"false\" />";
  }
}

Board.prototype.setSearch = function(hashLevel) {
  this.search = hashLevel == 0 ? null : new Search(this.pos, hashLevel);
}

Board.prototype.flipped = function(sq) {
  return this.computer == 0 ? SQUARE_FLIP(sq) : sq;
}

Board.prototype.computerMove = function() {
  return this.pos.sdPlayer == this.computer;
}

Board.prototype.computerLastMove = function() {
  return 1 - this.pos.sdPlayer == this.computer;
}

Board.prototype.addMove = function(mv, computerMove) {
    
   //for(var tt = 1; tt<=199999; tt++)
//   {
//      if(((tt & 255) & 15) == 8 && ((tt & 255) >> 4) == 4 && ((tt >> 8) & 15) == 10 && ((tt >> 8) >> 4) == 3)
//      {
//        console.log(tt);
//        break;
//      }
//   }
  if (!this.pos.legalMove(mv)) {
    //console.log("a");
    return;
  }
  if (!this.pos.makeMove(mv)) {
    //console.log("b");
    this.playSound("illegal");
    return;
  }
  //console.log(mv);
  this.busy = true;
  if (!this.animated) {
    this.postAddMove(mv, computerMove);
    return;
  }
  //console.log("c");
  var sqSrc = this.flipped(SRC(mv));
  var xSrc = SQ_X(sqSrc);
  var ySrc = SQ_Y(sqSrc);
  var sqDst = this.flipped(DST(mv));
  var xDst = SQ_X(sqDst);
  var yDst = SQ_Y(sqDst);
  var style = this.imgSquares[sqSrc].style;
  style.zIndex = 256;
  var step = MAX_STEP - 1;
  var this_ = this;
  var timer = setInterval(function() {
    if (step == 0) {
      clearInterval(timer);
      style.left = xSrc + "px";
      style.top = ySrc + "px";
      style.zIndex = 0;
      this_.postAddMove(mv, computerMove);
      
    } else {
      style.left = MOVE_PX(xSrc, xDst, step);
      style.top = MOVE_PX(ySrc, yDst, step);
      step --;   
    }
  }, 2);
}

Board.prototype.postAddMove = function(mv, computerMove) {
        
  if (this.mvLast > 0) {
    this.drawSquare(SRC(this.mvLast), false);
    this.drawSquare(DST(this.mvLast), false);
  }
  this.drawSquare(SRC(mv), true);
  this.drawSquare(DST(mv), true);
  this.sqSelected = 0;
  this.mvLast = mv;

  if (this.pos.isMate()) {
    //console.log(1)
    this.playSound(computerMove ? "loss" : "win");
    this.result = computerMove ? RESULT_LOSS : RESULT_WIN;

    var pc = SIDE_TAG(this.pos.sdPlayer) + PIECE_KING;
    var sqMate = 0;
    for (var sq = 0; sq < 256; sq ++) {
      if (this.pos.squares[sq] == pc) {
        sqMate = sq;
        break;
      }
    }
    if (!this.animated || sqMate == 0) {
      this.postMate(computerMove);
      return;
    }

    sqMate = this.flipped(sqMate);
    var style = this.imgSquares[sqMate].style;
    style.zIndex = 256;
    var xMate = SQ_X(sqMate);
    var step = MAX_STEP;
    var this_ = this;
    var timer = setInterval(function() {
      if (step == 0) {
        clearInterval(timer);
        style.left = xMate + "px";
        style.zIndex = 0;
        this_.imgSquares[sqMate].src = "../../../cvv/ChineChess/" + this_.images +
            (this_.pos.sdPlayer == 0 ? "r" : "b") + "km.gif";
        this_.postMate(computerMove);
      } else {
        style.left = (xMate + ((step & 1) == 0 ? step : -step) * 2) + "px";
        step --;
      }
    }, 50);
    return;
  }

  var vlRep = this.pos.repStatus(3);
  if (vlRep > 0) {
    vlRep = this.pos.repValue(vlRep);
    if (vlRep > -WIN_VALUE && vlRep < WIN_VALUE) {
      this.playSound("draw");
      this.result = RESULT_DRAW;
      alertDelay("Cờ Hòa");      
    } else if (computerMove == (vlRep < 0)) {
      this.playSound("loss");
      this.result = RESULT_LOSS;
      alertDelay("Bạn đã thua! Xin đừng nản lòng!");
    } else {
      this.playSound("win");
      this.result = RESULT_WIN;
      alertDelay("Bạn đã chiến thắng Siêu máy tính!");
    }
    end_game();
    this.postAddMove2();
    this.busy = false;
    return;
  }

  if (this.pos.captured()) {
    var hasMaterial = false;
    for (var sq = 0; sq < 256; sq ++) {
      if (IN_BOARD(sq) && (this.pos.squares[sq] & 7) > 2) {
        hasMaterial = true;
        break;
      }
    }
    if (!hasMaterial) {
      this.playSound("draw");
      this.result = RESULT_DRAW;
      alertDelay("Ván cờ thật là khó khăn! Hai bên không đưa ra được nước đi sáng sủa nào cả!");
      this.postAddMove2();
      this.busy = false;
      end_game();
      return;
    }
  } else if (this.pos.pcList.length > 100) {
    var captured = false;
    for (var i = 2; i <= 100; i ++) {
      if (this.pos.pcList[this.pos.pcList.length - i] > 0) {
        captured = true;
        break;
      }
    }
    if (!captured) {
      this.playSound("draw");
      this.result = RESULT_DRAW;
      alertDelay("Làm việc chăm chỉ!");
      end_game();
      this.postAddMove2();
      this.busy = false;
      return;
    }
  }

  if (this.pos.inCheck()) {
    //console.log(1);
    this.playSound(computerMove ? "check2" : "check");
  } else if (this.pos.captured()) {
    //console.log(2);
    this.playSound(computerMove ? "capture2" : "capture");
  } else {
    //console.log(3);
    
    this.playSound(computerMove ? "move2" : "move");
  }
  
  //console.log(arr_move.length);
   
    
  //jQuery("#stop_action input").css("background","darkcyan");
  //jQuery("#stop_action input").removeAttr("disabled");

  this.postAddMove2(this.getMoveVN());
  //console.log(this.start_target);
  //console.log(this.pos.sdPlayer);
  
  if(typeof firebase !== 'undefined')
  {
      var data_update = {};
      if(this.pos.sdPlayer == 1 && this.start_target == 1)
      {
          data_update = {
                user_move_1 : move2Iccs(board.mvLast).replace(/-/g,''),
                user_move_2 : "",
                current_fen : this.pos.toFen()
          };       
          board.busy = true;        
      }
      
      if(this.pos.sdPlayer == 1 && this.start_target == 2)
      {
         board.busy = false;
      }
      
      if(this.pos.sdPlayer == 0 && this.start_target == 2)
      {
         data_update = {
                user_move_1 : "",
                user_move_2 : move2Iccs(board.mvLast).replace(/-/g,''),
                current_fen : this.pos.toFen()
          };
          board.busy = true;  
      }
      
      if(this.pos.sdPlayer == 0 && this.start_target == 1)
      {
         board.busy = false;
      }
      //console.log("a");
      firebase.database().ref('chinese_chess_board/'+current_city_id+"/"+current_board).update(data_update); 
      
  }
  this.response();
  //sleepFor(5000);
}

Board.prototype.getMoveVN = function(inp_move = "") {
  if(jQuery(arr_move).size == 4)
  {
      var check_stt = 1;
      for(var i_arr_move in arr_move)
      {
        if(check_stt==2)
        {
            delete arr_move[i_arr_move];
        }
        else
        {
            check_stt++;
        }
      }
  }
  
  var t_m = ""; // ten quan co
  var p_t = 0;  // start_left
  var p_e = 0;  // end_left
  var a_t = ""; // action_move
  var top_start = 0; 
  var top_end = 0;
  var str_final = "";
  for(var i_arr_move in arr_move)
  {
     if(i_arr_move != "-1" && i_arr_move!="side")
     {
        t_m = i_arr_move;
        top_end = arr_move[i_arr_move]['top'];
        p_e = arr_move[i_arr_move]['left'];
     }
     else if(i_arr_move == "-1")
     {
        p_t = arr_move[i_arr_move]['left'];
        top_start = arr_move[i_arr_move]['top'];
     }
  }
  
  if(board.computer === 0)
  {
    p_t = 10 - p_t;
    p_e = 10 - p_e;
    top_end = 10 - top_end;
    top_start = 10 - top_start;
  }
  var dist_m = top_end - top_start;

  if(t_m != "S" && t_m != "V" && t_m != "M")
  {
     if(t_m.length>1)
     {
        p_t = "";
     }
    if(arr_move['side'] == 'b')
    {
        if(dist_m < 0)
        {
            a_t = "/";
            dist_m = Math.abs(dist_m);
            str_final = t_m + p_t + a_t + dist_m;
        }
        else if(dist_m == 0)
        {
            a_t = "-";
            str_final = t_m + p_t + a_t + p_e;
        }
        else 
        {
            a_t = ".";
            dist_m = Math.abs(dist_m);
            str_final = t_m + p_t + a_t + dist_m;
        }
    }
    else
    {
        if(dist_m > 0)
        {
            a_t = "/";
            dist_m = Math.abs(dist_m);
            str_final = t_m + p_t + a_t + dist_m;
        }
        else if(dist_m == 0)
        {
            a_t = "-";
            str_final = t_m + p_t + a_t + p_e;
        }
        else 
        {
            a_t = ".";
            dist_m = Math.abs(dist_m);
            str_final = t_m + p_t + a_t + dist_m;
        }
    }   
  }
  else
  {
     if(arr_move['side'] == 'b')
     {
        if(dist_m < 0)
        {
            a_t = "/";           
        }
        else 
        {
            a_t = ".";
        }     
     }
     else
     {
        if(dist_m > 0)
        {
            a_t = "/";
        }
        else 
        {
            a_t = ".";
        }        
     } 
     str_final = t_m + p_t + a_t + p_e;
  }
  return str_final;
}

Board.prototype.postAddMove2 = function(inp_move = "") {
  if (typeof this.onAddMove == "function") {
    this.onAddMove(inp_move);
  }
}

Board.prototype.postMate = function(computerMove) {
  alertDelay(computerMove ? "Hãy tiếp tục!": "Xin chúc mừng! Bạn đã chiến thắng");
  this.postAddMove2(this.getMoveVN());
  end_game();
  this.busy = false;
}

Board.prototype.response = function() {
  if(this.sellMode==2 || this.viewer == 1)
  {
    return;
  }
  if(this.check_black == 1)
  {
     if (this.search == null || this.computerMove()) {
        
        if(this.gameType == 1)
        {
            this.busy = false;
            return;            
        }        
     }
  }
  else
  {  
      if (this.search == null || !this.computerMove()) {
        
        if(this.gameType == 1)
        {
            this.busy = false;
            return;            
        }        
      }
  }
  this.thinking.style.visibility = "visible";
  if(this.gameType == 1)
  {
      jQuery("#prev_action input[type=button]").css("background","burlywood");
      jQuery("#prev_action input[type=button]").removeAttr('onclick');
      
      jQuery("#start_game_action input[type=button]").css("background","burlywood");
      jQuery("#start_game_action input[type=button]").removeAttr('onclick');
  }
  
  //jQuery("#countup_img").append('<img src="../../../cvv/ChineChess/images/countup.gif" style="width:75px; height:35px;" />');
  var this_ = this;
  this.busy = true;
  var sleep_s = 250;
  //if(this_.gameType2 == 2)
//  {
//    sleep_s = 2000;
//  }
  //console.log(sleep_s); 
  
  AutoMove();
  
  /**  
  setTimeout(function() {
      if(this_.gameType2 == 1)
      {
          jQuery("#prev_action input[type=button]").css("background","brown");
          jQuery("#prev_action input[type=button]").attr('onclick','retract_click();');
          jQuery("#start_game_action input[type=button]").css("background","darkblue");
          jQuery("#start_game_action input[type=button]").attr('onclick','restart_click();');  
      }
    
    this_.addMove(board.search.searchMain(LIMIT_DEPTH, board.millis), true);
    this_.thinking.style.visibility = "hidden";  
    
    
    //jQuery("#countup_img img").remove();
    arr_move = [];
  }, sleep_s);
  **/
  //console.log(2);
  
  //sleepFor(2000);
}

function end_game()
{
    jQuery("#prev_action input[type=button]").css("background","brown");
    jQuery("#prev_action input[type=button]").attr('onclick','retract_click();');
    jQuery("#start_game_action input[type=button]").css("background","darkblue");
    jQuery("#start_game_action input[type=button]").attr('onclick','restart_click();'); 
    jQuery("#stop_action input").css("display","none");
}

function sleepFor( sleepDuration ){
    var now = new Date().getTime();
    while(new Date().getTime() < now + sleepDuration){ /* do nothing */ } 
}

Board.prototype.clickSquare = function(sq_) {
    arr_move = [];

  if (this.busy || this.result != RESULT_UNKNOWN || this.viewer == 1 || this.start_game==-1) {
    return;
  }
  var sq = this.flipped(sq_);
  var pc = this.pos.squares[sq];
  if ((pc & SIDE_TAG(this.pos.sdPlayer)) != 0) {
    this.playSound("click");
    if (this.mvLast != 0) {
      this.drawSquare(SRC(this.mvLast), false);
      this.drawSquare(DST(this.mvLast), false);
    }
    if (this.sqSelected) {
      this.drawSquare(this.sqSelected, false);
    }
    this.drawSquare(sq, true);
    this.sqSelected = sq;
  } else if (this.sqSelected > 0) {
    this.addMove(MOVE(this.sqSelected, sq), false);
  }
}



Board.prototype.drawSquare = function(sq, selected) {
  var img = this.imgSquares[this.flipped(sq)];
  //console.log(this.imgSquares);
  img.src = "../../../cvv/ChineChess/" + this.images + PIECE_NAME[this.pos.squares[sq]] + ".gif";
  img.alt = PIECE_NAME[this.pos.squares[sq]];
  var src_temp = "../../../cvv/ChineChess/" + this.images + PIECE_NAME[this.pos.squares[sq]] + ".gif";
  img.style.backgroundImage = selected ? "url(../../../cvv/ChineChess/" + this.images + "oos.gif)" : "";
  var top_move = Math.round((img.offsetTop - 3)/57) + 1;     
  var left_move = Math.round((img.offsetLeft - 4)/57) + 1;   
  if(selected)
  {
      var current_piece = convert_img_to_piece(img.src.substr(39,1));
      var total_piece = 1;
      var side = img.src.substr(38,1);
      var stt_move = 1;
      
      arr_move[current_piece] = [];
      arr_move[current_piece]['top'] = top_move;     
      arr_move[current_piece]['left'] = left_move;   
      if(side == 'b' || side == 'r')
      {
        arr_move['side'] = side;
        if(side == 'r')
        {
            for(var i_arr_move in arr_move)
            {
                if(i_arr_move!='side')
                {
                    arr_move[i_arr_move]['left'] = 10 - arr_move[i_arr_move]['left'];
                }
            }
        }
      }
      //console.log(arr_move);
      
      if(typeof arr_move["-1"] !== 'undefined' && current_piece != "V" && current_piece!="S" && current_piece!="M")
      {
          jQuery("div#board_game div#container img").not(img).each(function(){
             
             if(jQuery(this).attr('src') == src_temp && jQuery(this).attr('src')!= "../../../cvv/ChineChess/images/oo.gif")
             { 
                
                var t_left = arr_move["-1"]['left'];
                var t_top = arr_move["-1"]['top'];                  
                var cur_top = Math.round((jQuery(this).position().top - 3)/57 + 1);
                var cur_left = Math.round((jQuery(this).position().left - 4)/57 + 1);

                if(side == "b")
                {
                    if(cur_top > t_top)
                    {
                        stt_move++;
                    }
                }
                else
                {
                    if(cur_top < t_top)
                    {
                        stt_move++;
                    }
                    cur_left = 10 - cur_left;
                }
                if(t_left == cur_left)
                {
                    total_piece++;
                }
             }
          });
          
          if(total_piece>1)
          {
             var temp_arr = arr_move[current_piece];
             delete arr_move[current_piece];
             current_piece = current_piece + get_postion(stt_move,total_piece); 
             arr_move[current_piece] = temp_arr;
          }
      }    
  }
}

Board.prototype.flushBoard = function() {
  this.mvLast = this.pos.mvList[this.pos.mvList.length - 1];
  for (var sq = 0; sq < 256; sq ++) {
    if (IN_BOARD(sq)) {
      this.drawSquare(sq, sq == SRC(this.mvLast) || sq == DST(this.mvLast));
    }
  }
}

Board.prototype.restart = function(fen) {
  if (this.busy) {
    return;
  }
  //console.log("b");
  this.result = RESULT_UNKNOWN;
  this.pos.fromFen(fen);
  if(fen.indexOf(" b") !== -1 && jQuery("#selMoveMode").val() == 1)
  {
     this.computer = 1;
  }
  this.flushBoard();
  this.playSound("newgame");        
  this.response();
}

Board.prototype.retract = function() {
  if (this.busy) {
    return;
  }
  this.result = RESULT_UNKNOWN;
  if (this.pos.mvList.length > 1) {
    this.pos.undoMakeMove();
  }
  if (this.pos.mvList.length > 1 && this.computerMove()) {
    this.pos.undoMakeMove();
  }
  this.flushBoard();
  this.response();
}

Board.prototype.setSound = function(sound) {
  this.sound = sound;
  if (sound) {
    this.playSound("click");
    new Audio("../../../cvv/ChineChess/sounds/vltk.mp3").play();
  }
  else
  {
    new Audio("../../../cvv/ChineChess/sounds/vltk.mp3").stop();
  }
}

function get_postion(position, total_pos) {
  if(total_pos == 2)
  {
    switch(position)
    {
        case 1 : 
                 return "t";
        case 2 : 
                 return "s";         
    }
  }
  else if(total_pos == 3)
  {
    switch(position)
    {
        case 1 : 
                 return "t";
        case 2 : 
                 return "g";        
        case 3 : 
                 return "s";             
    }
  }
  else if(total_pos == 4)
  {
    switch(position)
    {
        case 1 : 
                 return "t";
        case 2 : 
                 return "gt";        
        case 3 : 
                 return "gs";    
        case 4 : 
                 return "s";                   
    }
  }
  else if(total_pos == 5)
  {
    switch(position)
    {
        case 1 : 
                 return "t";
        case 2 : 
                 return "gt";        
        case 3 : 
                 return "g";    
        case 4 : 
                 return "gs";        
        case 5 : 
                 return "s";                        
    }
  }
}

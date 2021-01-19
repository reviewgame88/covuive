"use strict";

function CHR(n) {
  return String.fromCharCode(n);
}

function ASC(c) {
  return c.charCodeAt(0);
}

function move2Iccs(mv) {
  var sqSrc = SRC(mv);
  var sqDst = DST(mv);
  //console.log(ASC("A"));
//  console.log(sqSrc);
//  console.log(FILE_X(sqSrc));
//  console.log(FILE_LEFT);
//  console.log(ASC("A") + FILE_X(sqSrc) - FILE_LEFT);
//console.log(mv);
//console.log(ASC("9") - RANK_Y(sqDst) + RANK_TOP);
  return CHR(ASC("A") + FILE_X(sqSrc) - FILE_LEFT) +
      CHR(ASC("9") - RANK_Y(sqSrc) + RANK_TOP) + "-" +
      CHR(ASC("A") + FILE_X(sqDst) - FILE_LEFT) +
      CHR(ASC("9") - RANK_Y(sqDst) + RANK_TOP);
}
@extends('user.master')
@section('content')
<meta name="_token" content="{{ csrf_token() }}">
<div class="mh-wrapper mh-clearfix">
    <div id="main-content" class="mh-content" role="main" itemprop="mainContentOfPage">
        <link rel="stylesheet" href="{!! asset('public/user/css/chinese_chess/style_chinese_chess.css') !!}">
        <link rel="stylesheet" href="{!! asset('public/user/css/chinese_chess/chessonl.css') !!}" type="text/css">
        <script src="https://www.gstatic.com/firebasejs/8.2.2/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.2.2/firebase-analytics.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.2.2/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.2.2/firebase-database.js"></script>
        <script>
            var user_id_temp = "k56bkhn";
            var firebaseConfig = {
                apiKey: "AIzaSyDU0BYaT-MtgBu_VwqS-uRN-UCkuajnPiA",
                authDomain: "covuive.com",
                projectId: "best-giai-tri-9c837",
                storageBucket: "best-giai-tri-9c837.appspot.com",
                messagingSenderId: "539920652872",
                appId: "1:539920652872:web:6ff27c6f155ef5e6eed67d",
                measurementId: "G-FYNT7XW7SP"
              };
            // Initialize Firebase
            firebase.initializeApp(firebaseConfig);
            firebase.analytics();

            jQuery.ajax({
              method: "POST",
              url: "{!! asset('public/user/api/chinese_chess/resful_api.php') !!}",
              data: { "_token" : jQuery('meta[name=_token]').attr('content'), "secret_key": '123456'}
            })
              .done(function( msg ) {
                firebase.auth().signInWithCustomToken(msg)
                  .then((user) => {
                    // Signed in
                    // ...
                    console.log("Signed in");
                  })
                  .catch((error) => {
                    var errorCode = error.code;
                    var errorMessage = error.message;
                    // ...
                  });
            });
        </script>
        <script defer="" src="{!! asset('public/user/js/chinese_chess/book.js') !!}"></script>
        <script defer="" src="{!! asset('public/user/js/chinese_chess/position.js') !!}"></script>
        <script defer="" src="{!! asset('public/user/js/chinese_chess/search.js') !!}"></script>
        <script defer="" src="{!! asset('public/user/js/chinese_chess/board.js') !!}"></script>
        <script defer="" src="{!! asset('public/user/js/chinese_chess/cchess.js') !!}"></script>
        <script defer="" src="{!! asset('public/user/js/chinese_chess/main2.js') !!}"></script>
        <script defer="" src="{!! asset('public/user/js/chinese_chess/respond.js') !!}"></script>
        <div id="appcont" class="k2base aleg hvok h100vh asizing navtabopen dosize" style="max-width: 1064px; height: 600px; min-height: 0px; top: 36px;">
           <div class="anav usno" style="z-index: 99; display: block;">
              <div class="dclpd bsbb navcont" style="display: inline-block;">
                 <div class="newtab1">
                    <button class="butsys minwd">Tạo bàn mới</button>
                    <div class="selcwr mro">
                       <button class="selcbt butsys vsel"></button>
                       <select class="selcsl"></select>
                    </div>
                    <span class="tuinfo fb">-</span>
                 </div>
                 <div class="nav ib"><button class="bmain active">Các bàn chơi</button><button>mở rộng...</button><button class="btab">#628</button></div>
              </div>
              <div class="navttl fb fl" style="display: block;">CỜ TƯỚNG</div>
           </div>
           <div id="precont" class="acon bsbb">
              <div id="pretl" class="tblobby usno" style="display: block;">
                 <div class="newtab2 dcpd">
                    <button class="minwd">Tạo bàn mới</button>
                    <div class="selcwr mro">
                       <button class="selcbt min85"></button>
                       <select class="selcsl"></select>
                    </div>
                    <div class="ib mro">
                       <button class="ubut">
                          <div class="uicon"></div>
                       </button>
                    </div>
                    <span class="tuinfo" style="color: gray;">- </span>
                 </div>
                 <div id="pretabs" class="tbvtabs">
                    <div class="tldeco"></div>
                    <div></div>
                    <div class="chpan dcpd">
                       <div class="chtop">
                          <select class="chgrlist minwd"> </select>
                          <input type="checkbox">Trò chuyện
                          <span> </span>
                       </div>
                       <div class="chsub">
                          <div style="display: block; position: relative; width: 100%; max-width: 640px; height: 140px;">
                             <div style="
                                position: absolute;
                                padding: 3px 4px 3px 8px;
                                top: 0px;
                                left: 0px;
                                right: 0px;
                                bottom: 2.5em;
                                overflow-y: scroll;
                                overflow-wrap: break-word;
                                background: rgb(255, 255, 255);
                                border: 1px solid rgba(0, 0, 0, 0.3);
                                ">
                                <div class="tind">+ xiangqi</div>
                             </div>
                             <form>
                                <div style="display: table; width: 100%; position: absolute; bottom: 0px;">
                                   <div style="display: table-cell;">
                                      <input class="bsbb" name="somename" type="text" autocomplete="off" autocapitalize="off" style="width: 100%; margin: 0px;">
                                   </div>
                                </div>
                             </form>
                          </div>
                       </div>
                    </div>
                    <div class="tlst"></div>
                 </div>
                 <div class="tbvusers" style="display: block;">
                    <div class="ulpan" style="display: none;"><button>Loại bỏ</button></div>
                    <div>
                       <table class="ul uls2">
                          <tbody>
                             <tr class="ulhead">
                                <td>
                                   <div class="darr"></div>
                                </td>
                                <td>
                                   <div class="darr"></div>
                                </td>
                                <td>
                                   <div class="darr"></div>
                                </td>
                             </tr>
                          </tbody>
                       </table>
                    </div>
                 </div>
                 <div class="tbvtabs" style="display: none;">
                    <div class="tldeco"></div>
                    <div></div>
                    <div class="chpan dcpd">
                       <div class="chtop">
                          <select class="chgrlist minwd"> </select>
                          <input type="checkbox">Trò chuyện
                          <span> </span>
                       </div>
                       <div class="chsub">
                          <div style="display: block; position: relative; width: 100%; max-width: 640px; height: 140px;">
                             <div style="position: absolute; padding: 3px 4px 3px 8px; inset: 0px 0px 2.5em; overflow-y: scroll; overflow-wrap: break-word; background: rgb(255, 255, 255); border: 1px solid rgba(0, 0, 0, 0.3);">
                                <div class="tind">+ cờ tướng</div>
                             </div>
                             <form>
                                <div style="display: table; width: 100%; position: absolute; bottom: 0px;">
                                   <div style="display: table-cell;">
                                      <input class="bsbb" name="somename" type="text" autocomplete="off" autocapitalize="off" style="width: 100%; margin: 0px;">
                                   </div>
                                </div>
                             </form>
                          </div>
                       </div>
                    </div>
                    <div class="tlst"></div>
                 </div>
              </div>
              <div class="astat bsbb" style="display: none;">
                 <table>
                    <tbody>
                       <tr>
                          <td>
                             <div class="loader"></div>
                          </td>
                       </tr>
                    </tbody>
                 </table>
              </div>
              <div class="gview sbfixed" style="display: none; min-height: 460px; background: rgb(232, 176, 96);">
                 <div class="thnavcont usno tama">
                    <button class="xbut hdhei" style="z-index: 100; right: 0px; width: 44px;">X</button>
                    <button class="cmenubut hdhei" style="z-index: 100; right: 38px; width: 44px;">
                       <div class="cmenu"></div>
                    </button>
                 </div>
                 <div class="thead bsbb usno hdhei" style="z-index: 99;">
                    <div style="display: table; width: 100%; height: 100%;">
                       <div style="display: table-cell; vertical-align: middle; text-align: center;">
                          <div class="tabany" style="margin: 0px auto; padding-right: 8px;">
                             <div style="display: table-cell; text-align: right; width: 50%; padding: 0px 0.4em; white-space: nowrap;">
                                <div class="ib" style="text-align: left; margin-right: 0.4em;"><b>#1</b></div>
                                <div class="ib time_left_user_1" style="text-align: right;"></div>
                             </div>
                             <div style="display: table-cell; text-align: left; width: 50%; padding: 0px 0.4em; white-space: nowrap;">
                                <div class="ib" style="text-align: left; margin-right: 0.4em;"><b>#2</b></div>
                                <div class="ib time_left_user_2" style="text-align: right;"></div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
                 <div class="bsbb tsb sbclrd">
                    <div class="tsbinner bsbb">
                       <div class="ttlcont">
                          <div class="ttlnav"><button class="butsys butlh">-</button><button class="butsys butlh" style="display: none;">X</button></div>
                          <div>table #231 &nbsp; 10m</div>
                       </div>
                       <div>
                          <div class="tplcont" style="overflow-y: auto;">
                             <div style="float: left; width: 49.5%; overflow-x: hidden; margin-top: 0px;">
                                <div class="f12" style="vertical-align: middle; line-height: 12px; background: rgba(0, 0, 0, 0.8); color: rgba(255, 255, 255, 0.95); font-weight: bold; padding: 0px 5px;">
                                   <div style="display: inline-block; width: 7px; height: 7px; background: rgb(255, 17, 17); margin-right: 5px;"></div>
                                   #1
                                </div>
                                <div style="position: relative;">
                                   <button class="butsys butsit" onclick="selectSide(this);" style="position: absolute; width: 100%; height: 100%;">#1</button>
                                   <div style="background: rgb(255, 255, 255); padding: 6px 6px 6px 0px; visibility: hidden;">
                                      <button style="float: right; border: 0px; padding: 2px 6px; font-weight: bold; margin: 1px 0px; background: rgb(187, 187, 187); color: rgb(255, 255, 255);" onclick="outPosition(this);">X</button>
                                      <div id="pl_user_id_1" class="nowrel" style="font-size: 115%; color: inherit; padding: 2px 6px;">-</div>
                                   </div>
                                </div>
                                <div class="tplext" style="margin-top: 6px; width: 100%;">
                                   <div style="display: table-cell; vertical-align: middle; text-align: left;">
                                      <span class="time_left_user_1">0:00</span>
                                      <div style="
                                         margin-left: 8px;
                                         display: inline-block;
                                         width: 0px;
                                         height: 0px;
                                         border-left: 4px solid transparent;
                                         border-right: 4px solid transparent;
                                         border-bottom: 8px solid rgba(0, 0, 0, 0.8);
                                         visibility: hidden;
                                         "></div>
                                   </div>
                                </div>
                             </div>
                             <div style="float: right; width: 49.5%; overflow-x: hidden; margin-top: 0px;">
                                <div class="f12" style="vertical-align: middle; line-height: 12px; background: rgba(0, 0, 0, 0.8); color: rgba(255, 255, 255, 0.95); font-weight: bold; padding: 0px 5px;">
                                   <div style="display: inline-block; width: 7px; height: 7px; background: rgb(102, 102, 102); margin-right: 5px;"></div>
                                   #2
                                </div>
                                <div style="position: relative;">
                                   <button class="butsys butsit" onclick="selectSide(this);" style="position: absolute; width: 100%; height: 100%;">#2</button>
                                   <div style="background: rgb(255, 255, 255); padding: 6px 6px 6px 0px; visibility: hidden;">
                                      <button style="float: right; border: 0px; padding: 2px 6px; font-weight: bold; margin: 1px 0px; background: rgb(187, 187, 187); color: rgb(255, 255, 255);" onclick="outPosition(this);">X</button>
                                      <div id="pl_user_id_2" class="nowrel" style="font-size: 115%; color: inherit; padding: 2px 6px;">-</div>
                                   </div>
                                </div>
                                <div class="tplext" style="margin-top: 6px; width: 100%;">
                                   <div style="display: table-cell; vertical-align: middle; text-align: left;">
                                      <span class="time_left_user_2">0:00</span>
                                      <div style="
                                         margin-left: 8px;
                                         display: inline-block;
                                         width: 0px;
                                         height: 0px;
                                         border-left: 4px solid transparent;
                                         border-right: 4px solid transparent;
                                         border-bottom: 8px solid rgba(0, 0, 0, 0.8);
                                         visibility: inherit;
                                         "></div>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                       <div class="tsinsb lh1s" style="text-align: center; background: rgb(255, 34, 17); color: rgb(255, 255, 255); padding-left: 0.5em; padding-right: 0.5em;">
                          <div class="tstatlabl nowrel">-</div>
                          <div class="tstatstrl"><button class="butwb" style="min-width: 8em;">Bắt đầu</button></div>
                       </div>
                       <div class="trqcont lh1s" style="position: relative;">
                          <div class="nowrel"><button class="minw" disabled="">Cầu hòa</button> <button class="minw" disabled="">Xin thua</button> <button class="minw" disabled="">Đi lại</button></div>
                          <div class="trqans dsp1 nowrel" style="display: none;">
                             <button class="minw">Có</button> <button class="minw">Không</button>
                             <span>... </span>
                          </div>
                          <div class="nowrel" style="display: none;">
                             <button class="minw">Có</button> <button class="minw">Không</button>
                             <span class="ttup">resign </span>
                          </div>
                       </div>
                       <div class="tcrdcont">
                          <div class="tcrdtabcont">
                             <div class="tcrdtab">
                                <div class="tcrdcell"><button class="active">Trò chuyện</button></div>
                                <div class="tcrdcell"><button>Nước đi</button></div>
                                <div class="tcrdcell"><button>Người xem</button></div>
                                <div class="tcrdcell"><button>Cài đặt</button></div>
                             </div>
                          </div>
                          <div class="tcrdpan">
                             <div style="position: absolute; width: 100%; min-height: 300px; visibility: inherit;">
                                <div class="bsbb mb1s msg_area" style="position: absolute; inset: 0px; background: rgb(255, 255, 255); padding: 2px 4px 3px 8px; overflow-wrap: break-word; overflow-y: scroll;">
                                </div>
                                <div class="h1s" style="position: absolute; bottom: 0px; left: 0px; right: 0px; padding-top: 4px;">
                                   <input class="bsbb" name="somename" type="text" autocomplete="off" autocapitalize="off" style="width: 100%; border: none;">
                                </div>
                                <div class="bsbb" style="position: absolute; top: 100%; width: 100%; margin: -2px 0px 4px;">
                                   <button class="ddbut butlh" style="position: absolute; top: 0px; background: rgb(248, 248, 248); border: none; border-radius: 0px;">...</button>
                                   <div class="ddcont bsbb bs dsp1" style="position: absolute; bottom: 0px; width: 100%; background: rgb(248, 248, 248); padding-top: 1em; display: none;">
                                      <p><button style="color: red; border-color: red;">Báo cáo hành vi</button></p>
                                      <p><label style="cursor: pointer;"><input id="chat_off" type="checkbox"> Tắt chat</label></p>
                                      <p><span class="emo" style="cursor: pointer; margin-right: 2px;">������</span><span class="emo" style="cursor: pointer; margin-right: 2px;">������</span><span class="emo" style="cursor: pointer; margin-right: 2px;"><img draggable="false" role="img" class="emoji" alt="☹️" src="https://s.w.org/images/core/emoji/13.0.1/svg/2639.svg"></span><span class="emo" style="cursor: pointer; margin-right: 2px;">������</span><span class="emo" style="cursor: pointer; margin-right: 2px;">������</span><span class="emo" style="cursor: pointer; margin-right: 2px;">������</span><span class="emo" style="cursor: pointer; margin-right: 2px;">������</span><span class="emo" style="cursor: pointer; margin-right: 2px;">������</span><span class="emo" style="cursor: pointer; margin-right: 2px;">������</span><span class="emo" style="cursor: pointer; margin-right: 2px;">������</span></p>
                                      <p><span style="cursor: pointer; margin-right: 0.5em; padding: 0.4em 0px;">hi</span><span style="cursor: pointer; margin-right: 0.5em; padding: 0.4em 0px;">thx</span><span style="cursor: pointer; margin-right: 0.5em; padding: 0.4em 0px;">gg</span><span style="cursor: pointer; margin-right: 0.5em; padding: 0.4em 0px;">gl</span><span style="cursor: pointer; margin-right: 0.5em; padding: 0.4em 0px;">ok</span><span style="cursor: pointer; margin-right: 0.5em; padding: 0.4em 0px;">lol</span><span style="cursor: pointer; margin-right: 0.5em; padding: 0.4em 0px;">brb</span></p>
                                   </div>
                                </div>
                             </div>
                             <div style="position: absolute; width: 100%; height: 100%; visibility: hidden;">
                                <div class="mb1s" style="position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px; overflow-y: scroll; background: rgb(255, 255, 255);">
                                   <table class="br" style="width: 100%; border-collapse: collapse;">
                                      <tbody>
                                         <tr>
                                            <td width="10%">1</td>
                                            <td width="40%" class="" style="cursor: pointer;">E7+5</td>
                                            <td width="45%" class="" style="cursor: pointer;">c2.5</td>
                                         </tr>
                                         <tr>
                                            <td>2</td>
                                            <td class="" style="cursor: pointer;">H8+6</td>
                                            <td class="" style="cursor: pointer;">r1+1</td>
                                         </tr>
                                         <tr>
                                            <td>3</td>
                                            <td class="" style="cursor: pointer;">H2+1</td>
                                            <td class="" style="cursor: pointer;">r1.6</td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </div>
                                <div class="lh1s" style="position: absolute; left: 0px; right: 0px; bottom: 0px;">
                                   <button style="min-width: 65px;">&lt;</button> <button style="min-width: 65px;">&gt;</button>
                                   <a class="lbut minw bsbb" target="_blank" href="https://www.playok.com/p/?g=xq148142807" rel="noopener"> WXF </a>
                                </div>
                             </div>
                             <div style="position: absolute; width: 100%; height: 100%; visibility: hidden;">
                                <div class="mb1s ulwp ovysct">
                                   <table class="ul uls1">
                                      <tbody>
                                         <tr>
                                            <td>
                                               <div class="ulnm">
                                                  <div class="r2"></div>
                                                  gsp502g
                                                  <span class="ulla">(vi) </span>
                                               </div>
                                            </td>
                                            <td class="m1ac"><button class="ulbx">X</button></td>
                                            <td class="m0ac ulnu">1248</td>
                                         </tr>
                                      </tbody>
                                   </table>
                                </div>
                                <div class="lh1s nowrel" style="position: absolute; left: 0px; right: 0px; bottom: 0px;">
                                   <button class="minw">Mời</button> <button class="minw">Chơi với máy</button>
                                   <span class="mlh"></span>
                                </div>
                             </div>
                             <div class="bsbb dsp1" style="background: rgb(255, 255, 255); position: absolute; top: 0px; width: 100%; height: 100%; visibility: hidden;">
                                <div style="width: 50%; float: left; margin-top: 0.75em;">
                                   <div class="mbsp">
                                      <select>
                                         <option value="0" selected="">Công khai</option>
                                         <option value="1200">1200+</option>
                                         <option value="1350">1350+</option>
                                         <option value="1500">1500+</option>
                                         <option value="1650">1650+</option>
                                         <option value="1800">1800+</option>
                                         <option value="1950">1950+</option>
                                         <option value="2100">2100+</option>
                                         <option value="1">Riêng tư</option>
                                      </select>
                                   </div>
                                   <div class="mbsp">
                                      <div>Thời gian:</div>
                                      <select id="game_time">
                                         <option value="3">3</option>
                                         <option value="5">5</option>
                                         <option value="7">7</option>
                                         <option value="10" selected="">10</option>
                                         <option value="15">15</option>
                                         <option value="20">20</option>
                                         <option value="30">30</option>
                                      </select>
                                   </div>
                                   <div class="mbsp"><input type="checkbox" id="undo">Cho đi lại</div>
                                   <div><input type="checkbox">Âm thanh</div>
                                </div>
                                <div style="width: 50%; float: right; margin-top: 0.75em;">
                                   <div class="mbsp nowrel"><input type="checkbox" id="none_rate">Không tính Rank</div>
                                   <div class="mbsp">
                                      <div class="nowrel">Thêm giờ:</div>
                                      <select id="extra_time">
                                         <option value="0">0</option>
                                         <option value="2">2</option>
                                         <option value="3">3</option>
                                         <option value="5">5</option>
                                         <option value="10">10</option>
                                         <option value="15">15</option>
                                      </select>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
                 <div class="bcont noth usno" style="touch-action: none;">
                    <div id="cls_action" style="display: none;">
                       <div id="message_area_84423">
                          <marquee width="100%" behavior="alternate" bgcolor="pink"></marquee>
                       </div>
                       <div id="stop_action">
                          <input type="button" class="button" value="∎ Tạm dừng" onclick="stop_game();">
                       </div>
                    </div>
                    <div style="float: left;" id="board_game">
                       <span class="td">
                          <div id="container" style="position: relative; width: 521px; height: 577px; background: url('../../../cvv/ChineChess/images/board.jpg');">                             
                          </div>
                       </span>
                    </div>
                    <div class="steps hide" style="float: left; width: 250px;">
                       <table>
                          <tbody>
                             <tr class="active">
                                <td style="width: 15px;"></td>
                                <td>Bắt đầu...</td>
                             </tr>
                          </tbody>
                       </table>
                    </div>
                    <div style="float: left; width: 205px !important;" id="game_action">
                       <div class="input80233" id="prev_action" style="margin-top: 20px;">
                          <input type="button" class="button" value="Lùi 1 bước" style="background: brown; border-radius: 5px; color: white; padding: 10px;" onclick="retract_click()">
                       </div>
                       <br/>
                       <div class="input80233" id="move_history" style="display: none;">
                          <div class="label">Moves</div>
                          <select id="selMoveList" size="10" onchange="moveList_change()">
                             <option selected="" value="0">=== Start ===</option>
                          </select>
                       </div>
                       <div class="input80233">
                          <div class="label" style="font-weight: bold;">Ai đi trước?</div>
                          <select id="selMoveMode" size="1">
                             <option selected="" value="0">Người chơi</option>
                             <option value="1">Máy</option>
                             <option value="2" style="display: none;">Tự chơi</option>
                          </select>
                       </div>
                       <div class="input80233">
                          <div class="label" style="font-weight: bold;">Hình thức</div>
                          <select id="gameType" size="1">
                             <option selected="" value="1">Người vs Máy</option>
                             <option value="2" style="display: none;">Máy vs Máy</option>
                          </select>
                       </div>
                       <div class="input80233" style="margin: 0px; margin-left: 5px;">
                          <div class="label" style="font-weight: bold;">Cờ chấp?</div>
                          <select id="selHandicap">
                             <option selected="" value="0">Không chấp</option>
                             <option value="1">Mã phải</option>
                             <option value="2">Đôi mã</option>
                             <option value="3">Chấp 9 quân</option>
                          </select>
                       </div>
                       <div class="input80233" style="margin: 0px; margin-left: 5px;">
                          <div class="label" style="font-weight: bold;">Trình độ máy</div>
                          <select id="selLevel" size="1" onchange="level_change()">
                             <option value="500">Dễ</option>
                             <option value="1000">Trung bình</option>
                             <option selected="" value="2000">Khó</option>
                             <option value="3000">Kỳ thủ</option>
                             <option value="4000">Kỳ thánh</option>
                          </select>
                       </div>
                       <div class="input80233">
                          <label for="chkAnimated" style="font-weight: bold;">
                          Hiệu ứng<br/>
                          <input type="checkbox" class="checkbox" id="chkAnimated" checked="" onclick="board.animated = checked">
                          </label>
                       </div>
                       <div class="input80233">
                          <label for="chkSound" style="font-weight: bold;">
                          Âm thanh<br/>
                          <input type="checkbox" class="checkbox" id="chkSound" checked="" onclick="board.setSound(checked)">
                          </label>
                       </div>
                       <div class="input80233" id="start_game_action">
                          <input type="button" class="button" value="Bắt đầu game mới" style="background: darkblue; border-radius: 5px; color: white; padding: 10px;" onclick="restart_click()">
                       </div>
                       <a id="img_link" style="display:none"></a>
                    </div>
                    <div class="tsinbo bsbb" style="position: absolute; width: 100%; height: 100%; text-align: center; z-index: 70;">
                       <div style="display: table-cell; vertical-align: middle;">
                          <div class="bsbb bs ib" style="text-align: center; max-width: 80%; min-width: 35%; padding: 0.75em 2em; border: 3px solid rgb(255, 255, 255); background: rgb(238, 34, 17); color: rgb(255, 255, 255);">
                             <div class="tstatlabl fb">Mời bác chọn bên</div>
                             <div class="tstatstrl"><button class="butwb" style="margin-top: 0.25em; min-width: 8em;">Bắt đầu</button></div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="nav0 usno tama" style="z-index: 100;">
              <button class="mbut hdhei hdbwd">
                 <div class="micon"></div>
              </button>
              <div class="mcont">
                 <div class="mlst"><button class="btab active">#231</button><button class="">tables</button><button>more...</button></div>
                 <div class="msub">
                    <p></p>
                    <div class="mlh r2"></div>
                    <span class="snum"></span>
                 </div>
                 <div class="lgout" style="margin-left: 10px;"><button class="btab" onclick="window.location='https://covuive.com/logout/';">Thoát</button></div>
              </div>
           </div>
           <div class="noth" style="display: none; z-index: 101; position: fixed; inset: 0px; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4);">
              <div style="vertical-align: middle; text-align: center; margin-top:10%;">
                 <div class="bsbb bs" style="display: inline-block; background: rgb(255, 255, 255); text-align: left; min-width: 260px; padding: 0.3em 0px; border-radius: 4px;">
                    <button onclick="jQuery('.noth').css('display','none');" style="float: right; width: 3.4em; height: 3.4em; margin: 0px; padding: 0px; color: rgb(204, 204, 204); background: transparent; border: none; font-weight: normal; cursor: pointer;">X</button>
                    <div style="padding: 0px 15px;">
                       <p class="fb mbh" style="margin-top: -0.25em;">Xếp hạng: <span class="rank_user"></span> 
                       </p>
                       <div class="r3"></div>
                       <br/>Tổng số game: <span class="total_game"></span>
                       <p style="margin: 0.5em 0px; width: 220px; padding: 0.2em 0px; overflow-wrap: break-word; overflow-y: auto;">
                       </p>
                       <div style="float: left; margin-top: 3px; margin-right: 0.5em; width: 52px; height: 52px; border: 1px solid rgb(170, 170, 170); overflow: hidden;"><img src="https://x.playok.com/photos/none.jpg"></div>
                       <div></div>
                       <div></div>
                       <div></div>
                       <p class="mbh"><a class="lbut minwd" target="_blank" href="">full stats</a></p>
                       <p class="mbh"><button class="minw"></button></p>
                       <div class="dtline"></div>
                       <p><button class="minw">ok</button></p>
                    </div>
                 </div>
              </div>
           </div>
        </div>
    </div>
</div>
@endsection
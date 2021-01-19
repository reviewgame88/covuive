<?php

header ("Access-Control-Allow-Origin: https://bestgiaitri.com"); 
if(isset($_REQUEST['_ga']))
{
    if(isset($_REQUEST['act']))
    {
        switch($_REQUEST['act'])
        {
            case "get_all" : 
                                $fen = $_REQUEST['fen'];
         
                                $curl = curl_init();
                                
                                curl_setopt_array($curl, array(
                                  CURLOPT_URL => 'https://www.chessdb.cn/chessdb.php?action=queryall&learn=1&showall=1&board='.$fen,
                                  CURLOPT_RETURNTRANSFER => true,
                                  CURLOPT_ENCODING => '',
                                  CURLOPT_MAXREDIRS => 10,
                                  CURLOPT_TIMEOUT => 0,
                                  CURLOPT_FOLLOWLOCATION => true,
                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                  CURLOPT_CUSTOMREQUEST => 'GET',
                                ));
                                
                                $response = curl_exec($curl);
                                
                                curl_close($curl);
                                
                                 $bom = pack('H*','EFBBBF');
                                 $response = preg_replace("/^$bom/", '', $response);
                                 $response = preg_replace(
                                    '/
                                        ^
                                        [\pZ\p{Cc}\x{feff}]+
                                        |
                                        [\pZ\p{Cc}\x{feff}]+$
                                        /ux',
                                    '',
                                    $response
                                 );
                                
                                echo $response;
                                break;
                                
            case "get_rul" :      
                                $fen = $_REQUEST['fen'];
                                $move_list =  $_REQUEST['mov'];
                                $curl = curl_init();
                            
                                curl_setopt_array($curl, array(
                                  CURLOPT_URL => 'https://www.chessdb.cn/chessdb.php',
                                  CURLOPT_RETURNTRANSFER => true,
                                  CURLOPT_ENCODING => '',
                                  CURLOPT_MAXREDIRS => 10,
                                  CURLOPT_TIMEOUT => 0,
                                  CURLOPT_FOLLOWLOCATION => true,
                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                  CURLOPT_CUSTOMREQUEST => 'POST',
                                  CURLOPT_POSTFIELDS => 'action=queryrule&board='.$fen.'&movelist='.$move_list,
                                  CURLOPT_HTTPHEADER => array(
                                    'Content-Type: application/x-www-form-urlencoded'
                                  ),
                                ));
                                
                                $response = curl_exec($curl);
                                $response = preg_replace("/^$bom/", '', $response);
                                $response = preg_replace(
                                    '/
                                        ^
                                        [\pZ\p{Cc}\x{feff}]+
                                        |
                                        [\pZ\p{Cc}\x{feff}]+$
                                        /ux',
                                    '',
                                    $response
                                );
                                curl_close($curl);
                                echo $response;   
                                break;
             case "get_qrbest" :
                                $fen = $_REQUEST['fen'];
                                $move_list =  $_REQUEST['mov'];
                                $curl = curl_init();
                            
                                curl_setopt_array($curl, array(
                                  CURLOPT_URL => 'https://www.chessdb.cn/chessdb.php',
                                  CURLOPT_RETURNTRANSFER => true,
                                  CURLOPT_ENCODING => '',
                                  CURLOPT_MAXREDIRS => 10,
                                  CURLOPT_TIMEOUT => 0,
                                  CURLOPT_FOLLOWLOCATION => true,
                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                  CURLOPT_CUSTOMREQUEST => 'POST',
                                  CURLOPT_POSTFIELDS => 'action=querybest&learn=1&board='.$fen.'&ban='.$move_list,
                                  CURLOPT_HTTPHEADER => array(
                                    'Content-Type: application/x-www-form-urlencoded'
                                  ),
                                ));
                                
                                $response = curl_exec($curl);
                                $response = preg_replace("/^$bom/", '', $response);
                                $response = preg_replace(
                                    '/
                                        ^
                                        [\pZ\p{Cc}\x{feff}]+
                                        |
                                        [\pZ\p{Cc}\x{feff}]+$
                                        /ux',
                                    '',
                                    $response
                                );
                                curl_close($curl);
                                echo $response;   
                                break;
              case "check_fen" :
                                $fen = $_REQUEST['fen'];
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                  CURLOPT_URL => 'https://www.chessdb.cn/chessdb.php',
                                  CURLOPT_RETURNTRANSFER => true,
                                  CURLOPT_ENCODING => '',
                                  CURLOPT_MAXREDIRS => 10,
                                  CURLOPT_TIMEOUT => 0,
                                  CURLOPT_FOLLOWLOCATION => true,
                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                  CURLOPT_CUSTOMREQUEST => 'POST',
                                  CURLOPT_POSTFIELDS => 'action=queue&board='.$fen,
                                  CURLOPT_HTTPHEADER => array(
                                    'Content-Type: application/x-www-form-urlencoded'
                                  ),
                                ));
                                
                                $response = curl_exec($curl);
                                $response = preg_replace("/^$bom/", '', $response);
                                $response = preg_replace(
                                    '/
                                        ^
                                        [\pZ\p{Cc}\x{feff}]+
                                        |
                                        [\pZ\p{Cc}\x{feff}]+$
                                        /ux',
                                    '',
                                    $response
                                );
                                curl_close($curl);
                                echo $response;    
                                break;                             
        }
        
    }
    else
    {
        echo "";
    }
    
    
    /**
    require_once 'restful_api.php';
    date_default_timezone_set('Asia/Saigon');
    class GetMove extends restful_api{
    
    	function __construct(){
    		parent::__construct();                
    	}
        
        function get_queryrule()
        {
            if ($this->method == 'POST')
            {                 
                $data =  trim($this->file);
                
                $request = new HttpRequest();
                $request->setUrl("https://www.chessdb.cn/chessdb.php");
                $request->setMethod("POST");
                
                $request->setQueryData(array(
                    'action' => 'queryrule',
                    'board' => $start_fen_temp,
                    'movelist'=> $movelist
                ));
                //$data_request = array(
    //                                'setup' => $setup,
    //                                'data' => $data,
    //                                'map' => $map,
    //            );
                $request->setBody(json_encode($data_request));
                
                try {
                    $response = $request->send();
                    $items = $response->getBody();
                    //System::debug($items);exit();
                    $bom = pack('H*','EFBBBF');
                    $items = preg_replace("/^$bom/", '', $items);
                    $items = preg_replace(
                        '/
                            ^
                            [\pZ\p{Cc}\x{feff}]+
                            |
                            [\pZ\p{Cc}\x{feff}]+$
                            /ux',
                        '',
                        $items
                    );
                    
                } catch (HttpException $ex) {
                    $data['status'] = 1;
                }
                $this->response(200, $body);
    		}
    		else{
    		  echo 1;
                $this->response(404, "FAILED"); // METHOD
    		}
        }   
        
        function get_queryall()
        {
            if ($this->method == 'GET')
            {                 
                
                $fen = $_GET['fen'];
                
                $request = new HttpRequest();
                $request->setUrl("https://www.chessdb.cn/chessdb.php");
                $request->setMethod("POST");
                
                $request->setQueryData(array(
                    'action' => 'queryall',
                    'learn' => 1,
                    'showall' => 1,
                    'board'=> $fen
                ));
                //$data_request = array(
    //                                'setup' => $setup,
    //                                'data' => $data,
    //                                'map' => $map,
    //            );
                $request->setBody(json_encode($data_request));
                
                try {
                    $response = $request->send();
                    $items = $response->getBody();
                    //System::debug($items);exit();
                    $bom = pack('H*','EFBBBF');
                    $items = preg_replace("/^$bom/", '', $items);
                    $items = preg_replace(
                        '/
                            ^
                            [\pZ\p{Cc}\x{feff}]+
                            |
                            [\pZ\p{Cc}\x{feff}]+$
                            /ux',
                        '',
                        $items
                    );
                    
                    print_r($items);
                } catch (HttpException $ex) {
                }
                $this->response(200, $body);
    		}
    		else{
    		  echo 2;
                $this->response(404, "FAILED"); // METHOD
    		}
        } 
        
    }   
    
    $api = new GetMove();
    
    **/
}
?>

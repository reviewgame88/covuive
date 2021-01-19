<?php
   
   $curl = curl_init();
                            
                            curl_setopt_array($curl, array(
                              CURLOPT_URL => 'https://giaitriviet.biz/authorization-sign-in',
                              CURLOPT_RETURNTRANSFER => true,
                              CURLOPT_ENCODING => '',
                              CURLOPT_MAXREDIRS => 10,
                              CURLOPT_TIMEOUT => 0,
                              CURLOPT_POSTFIELDS => 'act=SIGN_UP',
                              CURLOPT_FOLLOWLOCATION => true,
                              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                              CURLOPT_CUSTOMREQUEST => 'POST',
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
?>
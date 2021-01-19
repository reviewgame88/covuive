<?php
function stripUnicode($str){
	if(!$str) return false;
	$unicode = array (
		'a' => 'á|à|ả|ạ|ã|ắ|ằ|ặ|ă|ẵ|ẳ|ấ|ầ|ẫ|ậ|â|ẩ',
		'A' => 'Á|À|Ả|Ạ|Ã|Ắ|Ằ|Ặ|Ă|Ẵ|Ẳ|Ấ|Ầ|Ẫ|Ậ|Â|Ẩ',
		'd'	=> 'đ',
		'D' => 'Đ',
		'e' => 'é|è|ẹ|ẽ|ẻ|ê|ế|ề|ể|ệ|ễ',
		'Ê' => 'É|È|Ẹ|Ẽ|Ẻ|Ê|Ế|Ề|Ể|Ệ|Ễ',
		'i' => 'í|ì|ị|ỉ|ĩ',
		'I' => 'Í|Ì|Ị|Ỉ|Ĩ',
		'o' => 'ó|ò|ỏ|ọ|õ|ơ|ớ|ờ|ở|ỡ|ợ|ô|ố|ồ|ỗ|ộ|ổ',
		'O' => 'Ó|Ò|Ơ|Ọ|Õ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|Ô|Ố|Ồ|Ỗ|Ộ|Ổ',
		'u' => 'ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự',
		'U' => 'Ú|Ù|Ũ|Ủ|Ụ|Ư|Ứ|Ừ|Ữ|Ử|Ự',
		'y' => 'ý|ỳ|ỹ|ỷ|ỵ',
		'Y' => 'Ý|Ỳ|Ỹ|Ỷ|Ỵ'	
	);

	foreach($unicode as $khongdau => $codau){
		$arr = explode("|",$codau);
		$str = str_replace($arr,$khongdau,$str);
	}
	return $str;
}
function changeTitle($str){
	$str = trim($str);
	if($str=="") return "";
	$str = str_replace('"','',$str);
	$str = str_replace("'",'',$str);
	$str = stripUnicode($str);
	$str = mb_convert_case($str,MB_CASE_LOWER,'utf-8');
	// MB_CASE_UPPER / MB_CASE_TITLE / MB_CASE_LOWER
	$str = str_replace(' ','-',$str);
	return $str; 
}
function cateParent($data, $parent = 0, $str = "--", $select = 0){
	foreach ($data as $value) {
		$cid = $value['id'];
		$name = $value['name'];
		if($value['parent_id'] == $parent){
			if($select != 0 && $cid == $select){
				echo "<option value=".$cid." selected='selected'>$str $name</option>";
			}
			else{
				echo "<option value=".$cid.">$str $name</option>";
			}
			cateParent($data,$cid,$str."--",$select);
		}
		
	}
	
}
function generateRandomString($length = 10) {

	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
function convertImgName($str){
	$str = trim($str);
	$index = strpos($str,'.');
	$len = strlen($str);
	$extendFile = substr($str,strpos($str,'.'),$len-$index);
	$imgName = substr($str,0,$index).generateRandomString().$extendFile;
	return $imgName;
}
?>
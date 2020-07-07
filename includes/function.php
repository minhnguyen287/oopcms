<?php 
	include('connection.php');
	//Hàm chọn ra 1 hàng trong bảng database theo tham số cho trước
	 function get_A_row($table,$search_field,$param){
	 	$query = "SELECT * FROM $table WHERE $search_field = '{$param}'";
	 	global $conn;
	 	$result = $conn -> query($query);
	 	return $result;
	 } 
	 //Hàm kiểm tra 1 biến có phải dạng số hay không
	 function isNum($num){
	 	if (isset($num)&&filter_var($num,FILTER_VALIDATE_INT)) {
		$result = $num;
		return $result;
	}
	 }
	 //Hàm kiểm tra 1 giá trị có phải dạng ký tự hay không
	 function isCharacter($character){
	 	$pattern = '/^[a-zA-Z0-9 ]+$/';
	 	if (isset($character) && preg_match($pattern, $character)) {
	 		$result = strip_tags($character);
	 		return $result;
	 	}
	 }
	// Hàm kiểmt tra xem giá trị đã tồn tại trong database chưa
	 function isExists($table,$field,$param){
	 	global $conn;
	 	$query = "SELECT * FROM $table WHERE $field = '{$param}'";
	 	$result = $conn -> query($query);
	 	if ($result -> num_rows > 0) {
	 		return TRUE;
	 	} else {
	 		return FALSE;
	 	}
	 }
 ?>
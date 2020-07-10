<?php 
	include('../../includes/function.php');
	if (isset($_POST['action']) && $_POST['action']=='show_position') {
		$query = "SELECT COUNT(*) AS count FROM categories";
		$result = $conn -> query($query);
		$position = $result -> fetch_array(MYSQLI_ASSOC);
		echo json_encode($position)
	}
	/*============== Function CREATE ================*/
	if (isset($_POST['action']) && $_POST['action']=='add') {
		if (isset($_POST['cat_name'])) {//echo $_POST['cat_name'];
			$cat_name = $conn -> real_escape_string(strip_tags($_POST['cat_name'])); 
		}
		if (isset($_POST['cat_position'])&&filter_var($_POST['cat_position'],FILTER_VALIDATE_INT)) {
			$cat_position = $_POST['cat_position'];
		}
		$result = get_A_row('categories','cat_name',$cat_name);
		if($result -> num_rows > 0){
			echo "exists";//Category already exists;
		} else{
			$q = "INSERT INTO categories(cat_name,user_id,creat_date,cat_position) VALUES ('{$cat_name}',1,NOW(),$cat_position)";
			$conn -> query($q);
			if ($conn -> affected_rows == 1) {
				$row = get_A_row('categories','cat_name',$cat_name);
				$result = $row -> fetch_array(MYSQLI_ASSOC);
				$query = "SELECT COUNT(*) AS count FROM categories";
				$count = $conn -> query($query);
				$limit = $count -> fetch_array(MYSQLI_ASSOC);
				$finish_result = array_merge($result,$limit);
				array_push($finish_result, "Category was added succesfully") ;
				echo json_encode($finish_result);
				//echo "Category was added succesfully";
			} else{
				echo "sys_error";
			}
		}
	}//END Function CREATE

	/*============== Function SHOW ================*/
	if(isset($_POST['action']) && $_POST['action']=='show'){
		$edit_id = isNum($_POST['edit_id']);
		$query1 = "SELECT cat_id,cat_name, cat_position FROM categories WHERE cat_id = {$edit_id}";
		$result1 = $conn -> query($query1);
		$query2 = "SELECT COUNT(*) FROM categories";
		$result2 = $conn -> query($query2); 
		if($result1 -> num_rows > 0){
			$fill_data = $result1 -> fetch_array(MYSQLI_ASSOC);
			$all_position = $result2 ->fetch_array(MYSQLI_NUM);
			$data_show = array_merge($fill_data, $all_position) ;
			//echo $show;
			echo json_encode($data_show);
		}//END If num_row
	}// END Function SHOW

	/*============== Function UPDATE ================*/
	if (isset($_POST['action']) && $_POST['action'] == 'update') {
		if (isset($_POST['Ecat_id'])) {
			$Ecat_id = isNum($_POST['Ecat_id']);
		}
		if (isset($_POST['Ecat_name'])) {
			$Ecat_name = isCharacter($_POST['Ecat_name']);
		}
		if (isset($_POST['Ecat_position'])) {
			$Ecat_position = isNum($_POST['Ecat_position']);
		}
		if (isExists('categories','cat_name',$Ecat_name)) {
			echo "exists";
		} else {
			$query = "UPDATE categories SET cat_name = ?, cat_position = ? WHERE cat_id = ? LIMIT 1";
			$stmt = $conn -> prepare($query);
			$stmt -> bind_param("sii",$Ecat_name,$Ecat_position,$Ecat_id);
			$stmt -> execute();
			if ($conn -> affected_rows == 1) {
				$row = get_A_row('categories','cat_id',$Ecat_id);
				$result = $row -> fetch_array(MYSQLI_ASSOC);
				array_push($result, "Category was edited succesfully") ;
				echo json_encode($result);
			} else{
				echo "sys_error";
			}
		}
	}// END Function UPDATE

	/*============== Function DELETE ================*/
	if (isset($_POST['action']) && $_POST['action'] == 'delete'){
		$Dcat_id = isNum($_POST['Dcat_id']);
		$query = "DELETE FROM categories WHERE cat_id = ? LIMIT 1";
		$stmt = $conn -> prepare($query);
		$stmt -> bind_param("i",$Dcat_id);
		$stmt -> execute();
		if ($conn -> affected_rows == 1) {
			echo "complete";
		} else {
			echo "sys_err";
		}
	}
	// END Function DELETE

 ?>
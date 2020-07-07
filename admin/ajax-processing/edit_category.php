<?php 
	include('../../includes/connection.php');
	include('../../includes/function.php');
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
	}
	 
	// 	echo "exists";//Category already exists;
	// } else{
	// 	$q = "INSERT INTO categories(cat_name,user_id,creat_date,cat_position) VALUES ('{$cat_name}',1,NOW(),$cat_position)";
	// 	$conn -> query($q);
	// 	if ($conn -> affected_rows == 1) {
	// 		$result = chooseCategorybyName($cat_name);
	// 		$a_result = $result -> fetch_array(MYSQLI_ASSOC);
	// 		$a_result[] = 'Category was added succesfully';
	// 		echo json_encode($a_result);
	// 		//echo "Category was added succesfully";
	// 	} else{
	// 		echo "sys_error";
	// 	}
	// }
	
 ?>
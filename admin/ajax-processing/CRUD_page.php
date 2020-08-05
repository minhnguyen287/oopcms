<?php 
	include('../../includes/function.php');
	include('../../includes/connection.php');
	/*=== Show option in Add-Modal ===*/
	if (isset($_POST['request']) && $_POST['request']=='show_option') {
		$query = "SELECT COUNT(*) AS count FROM pages";
		$result = $conn -> query($query);
		$position = $result -> fetch_array(MYSQLI_ASSOC);
		echo json_encode($position);
	}

	/*============== Function CREATE ================*/
	if (isset($_POST['action']) && $_POST['action']=='add') {
		if (isset($_POST['pname'])) {//echo $_POST['cat_name'];
			$pname = $conn -> real_escape_string(strip_tags($_POST['pname'])); 
		}
		if (isset($_POST['pcontent'])) {//echo $_POST['cat_name'];
			$pcontent = $conn -> real_escape_string(strip_tags($_POST['pcontent'])); 
		}
		if (isset($_POST['pcat'])&&filter_var($_POST['pcat'],FILTER_VALIDATE_INT)) {
			$pcat = $_POST['pcat'];
		}
		if (isset($_POST['ppos'])&&filter_var($_POST['ppos'],FILTER_VALIDATE_INT)) {
			$ppos = $_POST['ppos'];
		}

		$result = get_A_row('pages','page_name',$pname);
		if($result -> num_rows > 0){
			echo "exists";//Category already exists;
		} else{
			$q = "INSERT INTO pages(page_name,content,user_id,cat_id,post_on,page_position) VALUES ('{$pname}','{$pcontent}',1,$pcat,NOW(),$ppos)";
			$conn -> query($q);
			if ($conn -> affected_rows == 1) {
				$row = get_A_row('pages','page_name',$pname);
				$result = $row -> fetch_array(MYSQLI_ASSOC);
				$query = "SELECT COUNT(*) AS count FROM pages";
				$count = $conn -> query($query);
				$limit = $count -> fetch_array(MYSQLI_ASSOC);
				$finish_result = array_merge($result,$limit);
				array_push($finish_result, "Page was added succesfully") ;
				echo json_encode($finish_result);
				//echo "Category was added succesfully";
			} else{
				echo "sys_error";
			}
		}
	}
	/*============== Function SHOW ================*/
	if (isset($_POST['action']) && $_POST['action']=='show_page') {
		if (isset($_POST['page_id'])&&filter_var($_POST['page_id'],FILTER_VALIDATE_INT)) {
			$page_id = $_POST['page_id'];
		}
		$query = "SELECT page_name, content, post_on, u.username AS author FROM pages AS p JOIN users AS u USING (user_id) WHERE page_id = {$page_id}";
		$page = $conn -> query($query);

		if ($page -> num_rows < 1) {
			echo "Opps, sorry somethings were wrong !";
		} else {
			$result = $page -> fetch_array(MYSQLI_ASSOC);
			echo json_encode($result);
		}
	}
	/*============== Function UPDATE ================*/
	if (isset($_POST['action'])&& $_POST['action']=='load_page') {
		$page_id = isNum($_POST['page_id']);
		$row = get_A_row('pages','page_id',$page_id);
		$result = $row -> fetch_array(MYSQLI_ASSOC);
		$result1 = $conn -> query("SELECT cat_id, cat_name FROM categories");
		while ($cat_option = $result1 -> fetch_array(MYSQLI_ASSOC)) {
			
		}
		echo json_encode($result);

	}
?>
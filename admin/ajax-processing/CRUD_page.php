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
		// Lấy page_id được gửi từ ajax
		$page_id = isNum($_POST['page_id']);
		//Thực hiện truy vấn lấy ra thông tin page theo page id ở trên 
		$row = get_A_row('pages','page_id',$page_id);
		// Fetch kết quả thành 1 array, tạm gọi là array 1; 
		$result1 = $row -> fetch_array(MYSQLI_ASSOC);

		// Truy vấn ra cat_id và category name để làm phần option category cho form update
		$cat = $conn -> query("SELECT cat_id, cat_name FROM categories");
		//Tạo ra 1 array lưu kết quả, tạm gọi là array 2a
		$result2a = array();
		// Lần lượt lưu kết quả thông qua vòng while
		while ($cat_option = $cat -> fetch_array(MYSQLI_ASSOC)) {
			$result2a[] = $cat_option;
		}
		//Truy vấn ra tổng số category
		$all_cat = $conn -> query("SELECT COUNT(*) AS count FROM categories");
		$result2b = $all_cat -> fetch_array(MYSQLI_ASSOC);

		//Tiến hành merge array để có thể build lại một modal hoàn chỉnh
		$result = array_merge($result1,$result2a,$result2b);
		echo json_encode($result);

	}
?>
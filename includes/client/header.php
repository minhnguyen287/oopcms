<!DOCTYPE HTML>
<html>

<head>
  <title>simple news</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="resources/template/style/style.css" />
</head>

<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="index.php">simple<span class="logo_colour">NEWS</span></a></h1>
          <h2>Simple. Contemporary. Website Template.</h2>
        </div>
        <div id="hello">
          <h2>Good morning!</h2>
        </div>
      </div>
      <div id="menubar">
        <ul id="menu">
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
          <li class="selected"><a href="index.php">Home</a></li>
          <li><a href="#">Categories</a>
            <ul class="submenu">
              <?php 
                $query = "SELECT cat_name FROM categories ORDER BY cat_position ASC";
                $result = $conn -> query($query);

                
                
                if ($result -> num_rows > 1) {
                  while ($row = $result -> fetch_array(MYSQLI_NUM)) {
                  echo "<li><a href ='#'>".$row[0]."</a></li>";
                  }
                }
                
               ?>
            </ul>
          </li>
          <li><a href="#">Admin Panel</a>
          </li>
          <li><a href="#">History</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
      </div>
    </div>
    <div id="content_header"></div>
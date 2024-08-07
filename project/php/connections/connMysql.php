<?php
//資料庫主機設定
 $db_host = "localhost";
 $db_username = "root";
 $db_password = "";
 $db_name = "ibeacon";
//連線伺服器
 $db_link = new mysqli($db_host, $db_username, $db_password, $db_name);
 if(!$db_link) die("資料庫連接失敗");
//設定字元及與編碼
 mysqli_multi_query($db_link, "SET NAMES 'utf8'");
?>
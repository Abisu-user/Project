<?php
// 連線資料庫
include("..\connections\connMysql.php");

header('Content-Type: application/json'); // 設置內容類型為 JSON

$response = array(); // 初始化響應數組

try {
    if ($action === 'register') {
        $usernumber = $_POST['usernumber'];
        // $sql = "SELECT * FROM member_data WHERE account = '$usernumber'";
        // $result = $db_link->query($sql);
        // $row_result = $result->fetch_assoc();
        $response['status'] = 'success';
        // $response['message'] = $row_result["actor"];
        $response['message'] = $usernumber;
    }
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = '伺服器錯誤: ' . $e->getMessage();
}
// 返回 JSON 格式的響應
echo json_encode($response);
// 關閉資料庫
$db_link->close();
?>
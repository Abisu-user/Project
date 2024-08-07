<?php
// 連線資料庫
include("..\connections\connMysql.php");

header('Content-Type: application/json'); // 設置內容類型為 JSON

$response = array(); // 初始化響應數組

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];
        $actor = $_POST['actor'];
        $number = '';
        switch ($actor) {
            case 'student':
                $number = $_POST['st_number'];
                $actor = "學生";
                break;
            case 'teacher':
                $number = $_POST['th_number'];
                $actor = "教師";
                break;
            case 'admin':
                $number = $_POST['ad_number'];
                $actor = "管理員";
                break;
        }
        $pwd = $_POST['pwd'];

        if ($action === 'register') {
            $username = $_POST['username'];
            $sex = $_POST['sex'];
            $mail = $_POST['mail'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $birth_date = $_POST['birth_date'];
            // 加密密碼
            $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);
            // 檢查資料庫中是否存在相同的帳號、電子郵件或電話號碼
            $check_query = "SELECT * FROM member_data WHERE account = '$number' OR gmail = '$mail' OR phone = '$phone'";
            $check_result = $db_link->query($check_query);

            if ($check_result->num_rows > 0) {
                $response['status'] = 'error';
                $response['message'] = '帳號、電子郵件或電話號碼已存在';
            } 
            else {
                // 新增資料
                $sql = "INSERT INTO member_data (actor, account, name, sex, gmail, phone, address, birthday, password) 
                        VALUES ('$actor', '$number', '$username', '$sex', '$mail', '$phone', '$address', '$birth_date', '$hashed_password')";

                if ($db_link->query($sql) === TRUE) {
                    $response['status'] = 'success';
                    $response['message'] = '註冊成功';
                } 
                else {
                    $response['status'] = 'error';
                    $response['message'] = '資料庫錯誤: ' . $db_link->error;
                }
            }
        } 
        else if ($action === 'login') {
            // 查詢帳戶
            $sql = "SELECT `actor`, `account`, `password` FROM `member_data` WHERE `account` = '$number' AND `actor` = '$actor'";
            $result = $db_link->query($sql);
            if ($result->num_rows <= 0) {
                $response['status'] = 'warning';
                $response['message'] = '查無此用戶';
            } 
            else {
                $row_result = $result->fetch_assoc();
                // 驗證密碼
                $hashed_password = $row_result["password"];
                if ($actor == $row_result["actor"] && $number == $row_result["account"] && password_verify($pwd, $hashed_password)) {
                    $response['status'] = 'success';
                    $response['message'] = '登入成功';
                    $response['value'] = $number;
                    $response['redirect_url'] = '../view/home.html';
                } 
                else {
                    $response['status'] = 'error';
                    $response['message'] = '密碼錯誤';
                }
            }
        } 
        else {
            $response['status'] = 'error';
            $response['message'] = '無效的操作';
        }
    } 
    else {
        $response['status'] = 'error';
        $response['message'] = '無效的请求方法';
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

 // 選取所有選項卡的觸發按鈕
const triggers = document.querySelectorAll('.tabs-trigger');
const contents = document.querySelectorAll('.tabs-content');
// 為每個觸發按鈕添加點擊事件監聽器
triggers.forEach(trigger => {
    trigger.addEventListener('click', () => {
        // 移除所有觸發按鈕和內容的 active 類
        triggers.forEach(t => t.classList.remove('active'));
        contents.forEach(c => c.classList.remove('active'));

         // 為被點擊的觸發按鈕和相應的內容添加 active 類
        trigger.classList.add('active');
        document.getElementById(trigger.dataset.tab).classList.add('active');
    });
});

// 設置默認的活動選項卡
triggers[0].classList.add('active');
contents[0].classList.add('active');

// 處理登入表單提交
document.getElementById('login-form').onsubmit = function(e) {
    e.preventDefault();
    // 獲取表單數據
    const formData = new FormData(this);
    const message = document.getElementById('login-msg');

    // 使用 Fetch API 發送數據到 PHP 腳本
    fetch('../php/handlers/lg-logic.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // 將響應轉為文本
    .then(data => {
        // 處理 PHP 返回的響應
        console.log(data);
    
        switch (data.status) {
        case 'success':
        alert(data.message);
        sessionStorage.setItem('usernumber', data.value);
        window.location.href = data.redirect_url;
        break;
        case 'error':
        message.textContent = data.message;
        break;
        case 'warning':
        message.textContent = data.message;
        break;
        default:
        alert('ERROR');
        }
    })
    .catch(error => {
        console.error('錯誤:', error);
        alert('登入失敗');
    });
}
//處理註冊表單提交
document.getElementById('pwd').addEventListener('input', updateStrength);
document.getElementById('curretpwd').addEventListener('input', updateStrength);

function updateStrength() {
    const password = document.getElementById('pwd').value;
    const confirmPassword = document.getElementById('curretpwd').value;
    const message = document.getElementById('register-msg');
    const strengthBar = document.getElementById('strength-bar').querySelector('span');
    const minLength = 8;
    const maxLength = 20;

    // 密码强度檢查
    const hasUpperCase = /[A-Z]/.test(password); // 檢查大寫字母
    const hasLowerCase = /[a-z]/.test(password); // 檢查小寫字母
    const hasDigit = /[0-9]/.test(password); // 检查数字
    const hasSpecialChar = /[@$!%*?&#]/.test(password); // 檢查特殊字符

    // 初始化强度
    let strength = 0;
    if (password.length >= minLength) strength += 20; // 長度要求
    if (hasUpperCase) strength += 20;
    if (hasLowerCase) strength += 20;
    if (hasDigit) strength += 20;
    if (hasSpecialChar) strength += 20;

    // 設置强度條的颜色和寬度
    if (strength < 50) {
        strengthBar.style.backgroundColor = 'red';
    } else if (strength < 70) {
        strengthBar.style.backgroundColor = 'orange';
    } else {
        strengthBar.style.backgroundColor = 'green';  
    }
    strengthBar.style.width = strength + '%'; // 設置进度條寬度
    // 檢查密码格式
    if (password.length < minLength) {
        message.textContent = '密码長度太短，最少需要 ' + minLength + ' 個字符。';
        e.preventDefault(); // 阻止表單默認提交
    } 
    else if (password.length > maxLength) {
        message.textContent = '密码長度太长，最多允许 ' + maxLength + ' 個字符。';
        e.preventDefault(); // 阻止表單默認提交
    } 
    else if (!hasUpperCase || !hasLowerCase || !hasDigit || !hasSpecialChar) {
        message.textContent = '密碼需要包含大小寫字母、數字和特殊字符。';
        e.preventDefault(); // 阻止表單默認提交
    }
    else if (password != confirmPassword){
        message.textContent = '密碼和確認密碼不符';
        e.preventDefault(); // 阻止表單默認提交
    }
    else{
        message.textContent = '';
        document.getElementById('register-form').onsubmit = function(e) {
            e.preventDefault(); // 阻止表單默認提交
            //獲取表單數據
            const formData = new FormData(this);
            const message = document.getElementById('register-msg');
            // 使用 Fetch API 發送數據到 PHP 脚本
            fetch('../php/handlers/lg-logic.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // 將响應轉為 JSON
            .then(data => {
                // 處理 PHP 返回的响應
                console.log(data);
                switch (data.status) {
                    case 'success':
                        message.textContent = ''; // 清空消息
                        alert(data.message);
                        window.location.href = '../view/LoginRegister.html';
                        break;
                    case 'error':
                        message.textContent = data.message;
                        break;
                    default:
                        alert('ERROR');
                }
            })
            .catch(error => {
                console.error('错误:', error);
                alert('注册失败');
            });
        };
    }
}

// 根據選擇的角色顯示相應的輸入欄位
document.getElementById('login-role').onchange = handleRoleChange;
document.getElementById('register-role').onchange = handleRoleChange;

    function handleRoleChange() {
    let studentId, teacherId, adminId;
        switch(this.id){
            case 'login-role':
                studentId = document.getElementById('student-id-login');
                teacherId = document.getElementById('teacher-id-login');
                adminId = document.getElementById('admin-id-login');
                break;
            case 'register-role':
                studentId = document.getElementById('student-id-register');
                teacherId = document.getElementById('teacher-id-register');
                adminId = document.getElementById('admin-id-register');
                break;
        }
        studentId.classList.add('hidden');
        teacherId.classList.add('hidden');
        adminId.classList.add('hidden');

        switch(this.value) {
            case 'student':
                studentId.classList.remove('hidden');
                break;
            case 'teacher':
                teacherId.classList.remove('hidden');
                break;
            case 'admin':
                adminId.classList.remove('hidden');
                break;
        }
    }

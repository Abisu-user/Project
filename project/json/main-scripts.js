// 當 DOM 內容加載完成後執行
document.addEventListener('DOMContentLoaded', () => {
  let usernumber = sessionStorage.getItem('usernumber');
   //抓取元素
   const user = document.getElementById('userRole');

    // 使用 fetch 發送數據到 PHP
  fetch('../php/handlers/home-logci.php', {
    method: 'POST',
    body: JSON.stringify({ usernumber: usernumber })
  })
  .then(response => response.json())
  .then(data => {
    console.log(data);
    switch (data.status) {
      case 'success':
        // 修改元素内容
        user.textContent = data.message;
        break;
      case 'error':
        alert(data.message);
        break;
    }
  })
  .catch(error => console.error('Error:', error));
  });

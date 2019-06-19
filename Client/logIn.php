<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="login.css" vale="text/css">
    <title>LogIn</title>
</head>
<body>
    <?php  include_once('./header.php'); ?>
    <div class="box">
        <div>
            <h3>Log In</h3><br><br>
        </div>
        <form>
            <div class="login">
                <input type="text" id="username" class="text-1" placeholder="Username"><br><br>
                <input type="text" id="password" class="text-1" placeholder="Password"><br><br>
                <button type="submit" id="submit" class="btn">Sign Up</button><br><br>
            </div>
        <form>
    </div>

    <div class="notice">
        <div class="notice-content">
            Sign Up Complete
        </div>
    </div>
    

    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        const username = document.getElementById('username');
        const password = document.getElementById('password');
        const submitBtn = document.getElementById('submit');
        const notice = document.querySelector('.notice');
        const noticeContent = document.querySelector('.notice-content');
        submitBtn.addEventListener('click', e => {
            e.preventDefault();
            // Gather data
            const res = JSON.stringify({
                username: username.value,
                password: password.value
            });
            const url = 'http://localhost:5002/user/authenticate';
            $.ajax({
                type: 'POST',
                url: url,
                data: res,
                success: (data) => { 
                    noticeContent.innerText = data.message;
                    notice.classList.add('show');
                    setTimeout(() => {
                        notice.classList.remove('show');
                        if(data.success) {
                            localStorage.setItem('USER_INFO', JSON.stringify(data.data));
                            window.location.replace("./index.php");
                        }
                    }, 2000);
                },
                contentType: "application/json",
                dataType: 'json'
            });
            console.log("Signup Complete");
        });
    </script>
</body>
</html>
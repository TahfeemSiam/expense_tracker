$(document).ready(function () {
    $('#signupForm').submit(function(e) {
        e.preventDefault();
        const fname = document.getElementById('fname').value
        const lname = document.getElementById('lname').value
        const email = document.getElementById('email').value
        const password = document.getElementById('password').value
        const confirmPassword = document.getElementById('confirmPassword').value
        if(password !== confirmPassword) {
            document.querySelector('.pwd-msg').classList.remove('display')
            setTimeout(() => {
                document.querySelector('.pwd-msg').classList.add('display')
            }, 2000)
        }
        else {
            $.ajax({
                'type': "POST",
                'url': 'process.php',
                'data': {
                    fname: fname,
                    lname: lname,
                    email: email,
                    password: password,
                    confirmPassword: confirmPassword
                },
                'success': function(response)
                {
                    window.location.href='user-dashboard.php';
                },
                'error': function(xhr, status, error) {
                    console.error("AJAX Error:", status, error, xhr.responseText);
                }
            });
        }
    });


    $('#loginForm').submit(function(e) {
        e.preventDefault();
        const email = document.getElementById('login_email').value
        const password = document.getElementById('login_password').value
        $.ajax({
            'type': "POST",
            'url': 'process.php',
            'data': {
                login_email: email,
                login_password: password,
            },
            'success': function(response)
            {
                window.location.href='user-dashboard.php';
            },
            'error': function(xhr, status, error) {
                console.error("AJAX Error:", status, error, xhr.responseText);
            }
        });
    });
});
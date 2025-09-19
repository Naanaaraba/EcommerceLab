$(document).ready(function () {
    $('#login-form').submit(function (e) {
        e.preventDefault();


        email = $('#email').val();
        password = $('#password').val();



        if (email == '' || password == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all fields!',
            });

            return;
        } else if (password.length < 6 || !password.match(/[a-z]/) || !password.match(/[A-Z]/) || !password.match(/[0-9]/)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password must be at least 6 characters long and contain at least one lowercase letter, one uppercase letter, and one number!',
            });

            return;
        }

        $.ajax({
            url: '../actions/login_user_action.php',
            type: 'POST',
            data: {

                email: email,
                password: password,

            },
            success: function (response) {
                if (response.status === 'success') {
                    // if (response.role === '2') {
                    window.location.href = '../index.php';
                    // }
                    /* 
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'login.php'; 
                        }
                           
                    }); */
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message,
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred! Please try again later.',
                });
            }
        });
    });
});
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        #message {
            margin-top: 20px;
            text-align: center;
            color: red;
        }

        #login-note {
            text-align: center;
            margin-top: 10px;
        }

        #login-link {
            color: #007bff;
            text-decoration: none;
        }

        #login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form id="registerForm">
            <input type="text" name="name" placeholder="Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required><br>
            <button type="submit">Register</button>
        </form>
        <div id="login-note">Already have an account? <a id="login-link" href="/login">Login here</a></div>
        <div id="message"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registerForm').submit(function(e) {
                e.preventDefault();

                // Get CSRF token from the meta tag
                var token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: '/register',
                    data: $('#registerForm').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': token // Include CSRF token in headers
                    },
                    success: function(response) {
                        $('#message').html(response.message);
                        // Redirect to login page or any other action after successful registration
                        //   window.location.href = '/login';
                    },
                    error: function(xhr, status, error) {
                        var err = JSON.parse(xhr.responseText);
                        $('#message').html('Error: ' + err.message);

                    }
                });
            });
        });
    </script>
</body>
</html>

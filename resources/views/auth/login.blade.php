<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
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

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

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


        #register-note {
            text-align: center;
            margin-top: 20px;
        }

        #register-link {
            color: #007bff;
            text-decoration: none;
        }

        #register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
   
    <form id="loginForm">
        <h2>Login</h2> 
        @csrf <!-- Include CSRF token field -->
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
        <div id="register-note">Not registered yet? <a id="register-link" href="/register">Register here</a></div>

        <div id="message">
            @if(session('success'))
                <p>{{ session('success') }}</p>
            @endif

            @if(session('message'))
                <p class="fade-in-out">{{ session('message') }}</p>
            @endif
        </div>
    </form>

 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '/login',
                    data: $('#loginForm').serialize(),
                    success: function(response) {
                        $('#message').html(response.message);
                        // Redirect to dashboard or any other action after successful login
                        // window.location.href = '/admin/tasks';
                         window.location.href = '/index';

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

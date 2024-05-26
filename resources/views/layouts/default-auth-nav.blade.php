<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body> 



     <nav>
        <div class="nav-left">
            @if(Auth::check())
                <a href="{{ route('tasks.index') }}" class="nav-button">Main Page</a>

            @can('create', App\Models\Task::class)
                <a href="{{ route('tasks.create') }}" class="nav-button">Create New Task</a>
            @endcan
          
               

                
            @endif
        </div>
        <div class="nav-right">
            @if(Auth::check())
                <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                    @csrf <!-- CSRF token -->
                    <button type="submit" class="nav-button">Logout</button>
                </form>
            @else
                <a href="/login" class="nav-button">Login</a>
                <a href="/register" class="nav-button">Register</a>
            @endif
        </div>
    </nav> 

    <div>
          {{-- za da gi zemam so with se prateni od controllerot informaciite  --}}
          <div id="info">
            @if (session('success'))
                <div class="alert success">
                    {{ session('success') }}
                    <span class="close-btn">&times;</span>
                </div>
            @endif
        </div>

        @yield('content')
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      
        $(document).ready(function(){
    // Function to display the alert with fade-in effect
    function showAlert() {
        $('#info .alert').fadeIn();
        // Automatically hide the alert after 2 seconds (adjust as needed)
        setTimeout(function() {
            hideAlert();
        }, 2000);
    }

    // Function to hide the alert with fade-out effect
    function hideAlert() {
        $('#info .alert').fadeOut();
    }

    // Event listener for close button click
    $('.close-btn').click(function(){
        hideAlert();
    });

    // Show the alert when the page loads
    showAlert();
});

        $(document).ready(function() {
            $('#logoutForm').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Perform the logout request
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),

                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        // Redirect to the login page
                        window.location.href = "{{ route('login.get') }}";
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Handle error if needed
                    }
                });
            });
        });
    </script>
</body>
</html>

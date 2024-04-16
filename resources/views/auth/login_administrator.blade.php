<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark">
    <div class="container my-5 py-4">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col col-md-6 col-lg-4 bg-light rounded">
                <main class="form-signin p-4">
                    <h1 class="h3 mb-3 fw-normal text-center">STKIPPGRI-BKL ADMINISTRATOR</h1>
                    <form action="{{ url('8080:2024') }}" method="POST">
                        @csrf
                        @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                        <div class="form-group mt-4">
                            Username/Email
                            <input type="text" class="form-control my-2 @error('email')
                                is-invalid
                            @enderror" name="email" id="email" required value="{{ old('email') }}">
                        </div>
                        <div class="form-group mt-4">
                            Password
                            <input type="password" class="form-control my-2" id="password" name="password" required>
                            <input type="checkbox" onclick="showPassword()" class="mb-4"> Show Password
                        </div>
                        <input type="hidden" value="admin" name="role">
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                        <center class="mt-2"><a href="{{ url('/') }}" class="text-decoration-none">/home</a></center>
                    </form>
                </main>
            </div>
        </div>
    </div>

    <script>
        function showPassword() {
        var x = document.getElementById("password");
        var y = document.getElementById("password_confirmation");
        var z = document.getElementById("current_password");
        if (x.type === "password") {
          x.type = "text";
          y.type = "text";
          z.type = "text";
        } else {
          x.type = "password";
          y.type = "password";
          z.type = "password";
        }
      }
    </script>
</body>
</html>
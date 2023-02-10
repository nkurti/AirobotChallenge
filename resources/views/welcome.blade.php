<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Styles -->

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

  <style>
    body {
      font-family: 'Nunito', sans-serif;
    }

    form {
      max-width: 500px;
      margin: auto;
    }

    form button {
      margin-top: 20px !important;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

  <script>
    // Login API Endpoint

    // Login function
    async function login(e) {
      e.preventDefault();
      e.stopPropagation();
      console.log('login logs', e.target, e)
      // Request Body
      const requestBody = {
        email,
        password,
      };

      // Fetch Options


      // Send Request
      const response = await fetch(loginApi, options);

      // Handle Response
      if (response.ok) {
        const data = await response.json();
        console.log(data);
        // Do something with the data
      } else {
        console.error(response.statusText);
      }
    }
  </script>
</head>

<body class="antialiased">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8" style="padding: 20px; max-width: 600px">
        <div class="card">
          <div class="card-header">{{ __('Login') }}</div>

          <div class="card-body">
            <form id='formLogin'>
              @csrf
              <div>
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control">
              </div>
              <div>
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control">
              </div>
              <button type="submit" class="btn btn-primary btn-block mb-4">Login</button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>



  <script>
    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
    };
    $('#formLogin').submit(async function(e) {
      e.preventDefault();
      var $inputs = $('#formLogin div :input');

      // not sure if you wanted this, but I thought I'd add it.
      // get an associative array of just the values.
      var values = {};
      $inputs.each(function() {
        values[this.name] = $(this).val();
      });
      const loginApi = `http://127.0.0.1:8000/api/login?email=${values.email}&password=${values.password}`;

      const response = await fetch(loginApi, options);
      const data = await response.json()

      console.log('form submit', values, data);
      if (data.access_token) {
        localStorage.setItem('token', data.access_token);
        window.location.href = "/calendar";
      } else {
        alert('Error : ' + data.error)
      }


    })
  </script>
</body>

</html>
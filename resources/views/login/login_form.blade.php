<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="{{ asset('js/app.js') }}" defer></script>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/signin.css') }}">
  <title>Login Form</title>
</head>

<body>
  <form method="POST" action="{{ route('login') }}" class="form-signin">
    @csrf
    <h1 class="h3 mb-3 font-weight-normal">Login Form</h1>
    @foreach ($errors->all() as $error)
      <ul class="alert alert-danger">
        <li>{{ $error }}</li>
      </ul>
    @endforeach
    @if (session('login_error'))
      <div class="alert alert-danger">
        {{ session('login_error') }}
      </div>
    @endif

    <label for="inputEmail" class="sr-only">Email address</label>
    <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required
      autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
  </form>
</body>

</html>

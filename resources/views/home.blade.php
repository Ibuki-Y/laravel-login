<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <title>Home</title>
</head>

<body>
  <div class="container">
    <div class="mt-5">
      <x-alert type="success" :session="session('success')" />
      <h3>Profile</h3>
      <ul>
        <li>name: {{ Auth::user()->name }}</li>
        <li>mail: {{ Auth::user()->email }}</li>
      </ul>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-primary">Logout</button>
      </form>
    </div>
  </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Chatroom - VideoMe</title>

  <!-- Bootstrap Core CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- Custom Fonts -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
  <script src="https://static.opentok.com/v2/js/opentok.min.js"></script>

  <!-- Custom CSS -->
  <link href="css/stylish-portfolio.css" rel="stylesheet">
  <link href="css/app.css" rel="stylesheet" type="text/css">

</head>

<body id="page-top">

  <!-- Navigation -->
  <a class="menu-toggle rounded" href="#">
    <i class="fas fa-bars"></i>
  </a>
  <nav id="sidebar-wrapper">
    <ul class="sidebar-nav">
      <li class="sidebar-brand">
        <a class="js-scroll-trigger" href="#page-top"><i class="fa fa-dot-circle" style="color: lime"></i> Online</a>
      </li>
      @foreach ($o_users as $o_user)
        <li class="sidebar-nav-item">
            <a class="js-scroll-trigger" href="#page-top" onclick="call('{{ $o_user->session_id }}','{{ $o_user->session_token }}');">{{ $o_user->username }}</a>
        </li>
      @endforeach
    </ul>
  </nav>


  <!-- Header -->
  <header class="masthead chatroom d-flex">
    <div class="container text-center my-auto">
      <h2 class="mb-1" id="notice">You are Online. <br /> Click on menu to make a video call to a user.</h2>
      <input id="api_key" value="{{ $api_key }}" hidden>
      <input id="session_id" value="{{ $user->session_id }}" hidden>
      <input id="token" value="{{ $user->session_token }}" hidden>
      <input id="username" value="{{ $user->username }}" hidden>

      <div id="videos">
        <div id="publisher"></div>
        <div id="subscriber"></div>
      </div>
      <div>
        <button class="btn btn-danger btn-xl" id="end_btn" style="display: none">End Call</button>
      </div>

      {{-- call modal --}}
      <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal body -->
            <div class="modal-body" style="color: black">
                <h5 id="call_msg">Someone is calling... </h5>
                <button class="btn btn-success btn-sm" id="answer">Answer</button>
                <button class="btn btn-sm btn-danger" id="reject">Reject</button>
            </div>

            </div>
        </div>
      </div>
      {{-- <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Find Out More</a> --}}
    </div>
    <div class="overlay"></div>
  </header>

  <!-- Footer -->
  <footer class="footer text-center">
    <div class="container">
      <ul class="list-inline mb-5">
        <li class="list-inline-item">
          <a class="social-link rounded-circle text-white mr-3" href="#">
            <i class="icon-social-facebook"></i>
          </a>
        </li>
        <li class="list-inline-item">
          <a class="social-link rounded-circle text-white mr-3" href="#">
            <i class="icon-social-twitter"></i>
          </a>
        </li>
        <li class="list-inline-item">
          <a class="social-link rounded-circle text-white" href="#">
            <i class="icon-social-github"></i>
          </a>
        </li>
      </ul>
      <p class="text-muted small mb-0">Copyright &copy; Joytek Motion {{ date('Y') }}</p>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/stylish-portfolio.min.js"></script>
  <script src="js/client.js"></script>

</body>

</html>

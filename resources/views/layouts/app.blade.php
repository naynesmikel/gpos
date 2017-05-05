<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="/gposlogo.png"/>
    <title>{{ config('app.name', 'Laravel') }}</title>

    {!! Charts::assets() !!}

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<style>
    html,body {
      width: 100%;
      height: 100%;
      margin: 0px;
      padding: 0px;
      overflow-x: hidden;
    }

    .navbar {
      background-color: #009587;
    }

    .nav.navbar-nav.navbar-right li a, .navbar-default .navbar-brand{
      color: #fefefe;
    }

    .dropdown-menu {
      background-color: #e7e7e7;
    }

    .navbar-default .navbar-nav .open .dropdown-menu>li>a, .navbar-default .navbar-nav .open .dropdown-menu {
      color: #202020;
    }

    #logo {
      width: 35px;
      height: 35px;
    }

    .navbar-brand {
      padding-top: 8px;
    }
</style>
<body>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#body').show();
      $('#msg').hide();
      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })
    });
  </script>
  <div id="msg" style="font-size:largest;">
    Loading, please wait...
  </div>

  <div id="body" style="display:none;">

    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}" title="GPOS">
                        <img id="logo" src="/gposlogo.png" alt="GPOS">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register Employee</a></li>
                        @else

              							@if(Auth::user()->admin)
                                <li><a href="/products/createBarcode" style="display: none;">Generate Barcodes</a></li>
                                <li><a href="/costs">Sales Report</a></li>
              							@endif
                            <li><a href="/orders">Orders Log</a></li>
                            <li><a href="/products">Inventory</a></li>
                            @if(Auth::user()->admin)
                            <li><a href="/users">Employees</a></li>
                            @endif
                            <li class="dropdown">
                                <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
    							                 <li><a href="/home">Home</a></li>
    							                 <li><a href="/profile/{{Auth::user()->username}}">Profile</a></li>
    							                 <li><a href="/company">Company Profile</a></li>

                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>

                        @endif
                    </ul>
                </div>
            </div>
        </nav>

		@yield('content')
    </div>

      @include('layouts/footer')

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script>
  		$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
  	</script>
  </div>
</body>
</html>

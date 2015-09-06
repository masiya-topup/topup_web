
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Topup</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li {{{ ($page == "home") ? "class=active" : '' }}}><a href="/">Home</a></li>
              <li {{{ ($page == "registration") ? "class=active" : '' }}}><a href="/registration">Registration</a></li>
              <li {{{ ($page == "topup") ? "class=active" : '' }}}><a href="/topup">Top'up</a></li>
            </ul>
            <ul class="list-unstyled navbar-right">
              <li><a href="/forgotpassword">Forgot Password</a></li>
              <li><a href="/registration">Register</a></li>
            </ul>
            <form id="frmAuth" class="navbar-form navbar-right" method="POST" action="/login">
                <div class="form-group form-group-sm">
                    <input type="text" id="username" name="username" placeholder="User Login" class="form-control input-sm" required/>
                </div>
                <div class="form-group form-group-sm">
                    <input type="password" id="password" name="password" placeholder="Password" class="form-control input-sm" required/>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <button type="submit" class="btn-sm btn-primary">Sign in</button>
            </form>

        </div><!--/.navbar-collapse -->
    </div>
</nav>

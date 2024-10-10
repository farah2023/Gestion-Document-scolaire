

        <!-- Start header -->
        <header id="header" class="site-header header-style-2">
            <div class="topbar">
                <div class="container">
                    <div class="row">
                        <div class="col col-md-9">

                        </div>

                    </div>
                </div>
            </div> <!-- end topbar -->
            <nav class="navigation navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="open-btn">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.html"><img src="/alloexpert/assets/images/logo1.png" alt></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse navbar-right navigation-holder">
                        <button class="close-navbar"><i class="ti-close"></i></button>
                        <ul class="nav navbar-nav">
                            <li >
                                <a href="{{ route('home') }}">Home</a>

                            </li>
                            <li >
                                <a href="#about">About</a>

                            </li>
                            <li >
                                <a href="#services">Services</a>

                            </li>


                            <li><a href="#contact">Contact</a></li>
                            <li><a href="{{ route('register') }}">Sign Up</a></li>
                            <li><a href="{{ route('login') }}">Log In</a></li>

                        </ul>
                    </div><!-- end of nav-collapse -->


                </div><!-- end of container -->
            </nav>
        </header>

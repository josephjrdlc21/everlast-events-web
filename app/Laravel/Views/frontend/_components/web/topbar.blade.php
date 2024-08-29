<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="" class="logo">
                        <div class="d-flex align-items-center">
                            <img src="{{asset('web/assets/images/logo/everlastlogo1.png')}}" alt="Logo" style="width: 45px; margin-right: 5px;">
                            <h1>Everlast</h1>
                        </div>
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                      <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                      <li class="scroll-to-section"><a href="#about">About Us</a></li>
                      <li class="scroll-to-section"><a href="#events">Events</a></li>
                      <li class="scroll-to-section"><a href="#courses">Sponsors</a></li>
                      <li class="scroll-to-section"><a href="{{route('frontend.auth.register')}}">Sign Up</a></li>
                      <li class="scroll-to-section"><a href="{{route('frontend.auth.login')}}">Sign In</a></li>
                  </ul>   
                    <a class="menu-trigger">
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
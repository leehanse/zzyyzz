<style>
    .navbar {
        margin: 0 !important;
        padding: 0 !important;
        min-height: 42px;
        border-radius: 0;
        border-right: none;
        border-left: none;
        border-top: none;
        background: none;
        border-color: #ffffff;
        background: #428BCA;
    }
    .header-default .navbar {
        position: relative !important;
    }
    .navbar > .container .navbar-brand, .logo {
        padding: 14px 10px 12px;
        margin-left: 0;
        font-family: 'Raleway', sans-serif;
        font-size: 25px;
        min-width:210px;
    }
    .navbar > .container .navbar-brand i, .logo i {
        font-size: 20px;
    }
    .navbar-tools > ul {
        list-style: none;
    }
    .navbar-tools > ul > li > a {
        padding: 15px 15px 9px;
        font-size: 16px;
    }
    .navbar-tools li.view-all a {
        padding: 8px 8px 6px !important;
    }
    .navbar-tools > ul > li {
        float: left;
    }
    .navbar-tools .dropdown-menu {
        background: none repeat scroll 0 0 white;
        border-radius: 0 0 4px 4px;
        box-shadow: none;
        list-style: none outside none;
        margin: 0;
        max-width: 300px;
        min-width: 166px;
        padding: 0;
        position: absolute;
        text-shadow: none;
        top: 100%;
        z-index: 1000;
    }
    .navbar-tools .drop-down-wrapper {
        height: 250px;
        width: 270px;
        overflow: hidden;
        position: relative;
    }
    .navbar-tools .drop-down-wrapper ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    ul.notifications li, ul.todo li, ul.posts li {
        min-width: 260px;
    }
    .navbar-tools > ul > li.dropdown {
        margin-left: 2px;
        margin-right: 2px;
    }
    .navbar-tools .dropdown-menu > li > a:hover, .navbar-tools .dropdown-menu > li > a:focus, .navbar-tools .dropdown-submenu:hover > a, .navbar-tools .dropdown-submenu:focus > a, .navbar-tools .drop-down-wrapper li a:hover, .navbar-tools .drop-down-wrapper li a:focus {
        background-color: #F4F6F9 !important;
        background-image: none;
        filter: none;
        color: #000;
        text-decoration: none;
    }
    .drop-down-wrapper ul > li:last-child a {
    border-bottom: none;
    }
    .navbar-tools .dropdown-menu li .dropdown-menu-title {
        display: block;
        font-weight: bold;
        margin: -1px;
        padding: 5px 10px;
    }
    .navbar-tools .dropdown-menu li p, .navbar-tools .dropdown-menu li a, .navbar-tools .drop-down-wrapper li p, .navbar-tools .drop-down-wrapper li a {
        color: #333333;
        font-size: 12px;
        font-weight: 300;
        margin: 0;
        padding: 8px 8px 6px;
        border-bottom: 1px solid rgba(100, 100, 100, 0.22);
        white-space: normal !important;
        display: block;
    }
    .navbar-tools .dropdown-menu > li:last-child a {
        border-bottom: none !important;
        border-radius: 0 0 6px 6px;
    }
    li.dropdown.current-user .dropdown-toggle {
        padding: 10px 4px 7px 9px;
    }
    li.dropdown.current-user .dropdown-menu li a {
        border-bottom: none !important;
    }
    .navbar-tools .dropdown-menu li p {
        font-weight: bold;
    }
    .navbar-tools .dropdown-menu li a .author {
        color: #0362FD;
        display: block;
    }
    .navbar-tools .dropdown-menu li a .preview {
        display: block;
    }
    .navbar-tools .dropdown-menu li a .time {
        font-size: 12px;
        font-style: italic;
        font-weight: 600;
        display: block;
        float: right;
    }
    .navbar-tools .dropdown-menu li.view-all a i {
        float: right;
        margin-top: 4px;
    }
    .navbar-tools .dropdown-menu.notifications li > a > .label {
        margin-right: 2px;
        padding: 2px 4px;
        text-align: center !important;
    }
    .navbar-tools .thread-image {
        margin-right: 8px;
        float: left;
        height: 50px;
        width: 50px;
    }
    .navbar-tools > ul > li.dropdown .dropdown-toggle .badge {
        border-radius: 12px 12px 12px 12px !important;
        font-size: 11px !important;
        font-weight: 300;
        padding: 3px 6px;
        position: absolute;
        right: 24px;
        text-align: center;
        text-shadow: none !important;
        top: 8px;
    }
    .navbar-toggle {
        border: none;
        border-radius: 0;
        margin-top: 5px;
        margin-bottom: 4px;
    }
    .navbar-toggle span {
    font-size: 16px;
    }
    .navbar-inverse .navbar-brand, .navbar-inverse .navbar-brand:hover, .navbar-inverse .nav > li > a {
            color: #FFFFFF;
    }
    .navbar-inverse .navbar-brand i, .navbar-inverse .navbar-brand:hover i {
            color: #007AFF;
    }

    .navbar-inverse .nav > li > a {
            color: #FFFFFF;
            text-transform: uppercase;
    }
    .navbar-inverse .nav > li.current-user > a {
            color: #FFFFFF !important;
    }
    .navbar-inverse .nav > li.current-user > a .username{
        font-size: 13px;
    }
    .navbar-inverse .nav > li.current-user > a i {
            display: inline-block;
            text-align: center;
            width: 1.25em;
            color: #FFFFFF !important;
            font-size: 12px;
    }
    .navbar-inverse .nav > li:hover > a, .navbar-inverse .nav > li:active > a {
            color: #555555;
            background: #6192AC;
    }
    .navbar-inverse .nav li.dropdown.open > .dropdown-toggle, .navbar-inverse .nav li.dropdown.active > .dropdown-toggle, .navbar-inverse .nav li.dropdown.open.active > .dropdown-toggle {
            background: #6192AC;
            color: #555555;
    }

    .navbar-tools .dropdown-menu li .dropdown-menu-title {
            background: #D9D9D9;
            color: #555555;
    }
    .navbar-inverse .btn-navbar {
            background-color: #D9D9D9;
            background: -moz-linear-gradient(top, #34485e 0%, #283b52 100%); /* firefox */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#34485e), color-stop(100%,#283b52)); /* webkit */
    }

    .nav > li.dropdown .dropdown-toggle .badge {
            background-color: #F6700E;
            border: none;
    }
    .navbar-toggle {
            background-color: #ffffff;
    }
    .navbar-inverse .navbar-toggle:hover, .navbar-inverse .navbar-toggle:focus {
            background-color: #D9D9D9;
            -moz-box-shadow: 0 0 15px #fff;
            -webkit-box-shadow: 0 0 15px #fff;
            box-shadow: 0px 0px 15px #fff;
    }
    .navbar-toggle span {
            color: #999999;
    }
    .todo li .label {
        padding: 6px;
        position: absolute;
        right: 10px;
    }
    .nav > li > a > img {
        max-width: none;
    }
    .circle-img {
        border-radius: 100%;
    }    
    .dropdown-menu{
        background: #6192AC !important;
    }
    .fhmm .fhmm-content.withdesc a{
    }
    .fhmm .dropdown-menu{
        border-style: solid;
        border-width: 2px;
        border-color: #6192AC;
        border-top-width: 0px;
    }
</style>
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top fhmm" role="navigation">
    <div class="menudrop container">
        <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target="#defaultmenu" class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>
        <!-- end navbar-header -->
        <div id="defaultmenu">
            <ul class="nav navbar-nav">
                <!-- Mega Menu -->
                <li class="dropdown fhmm-fw active"><a href="#"><i class="fa fa-home"></i> HOME</a></li><!-- mega menu -->
                <!-- list elements -->
                <li class="dropdown fhmm-fw"><a href="#" data-toggle="dropdown" class="dropdown-toggle">FEATURES <b class="caret"></b></a>
                    <ul class="dropdown-menu fullwidth">
                        <li class="fhmm-content withdesc">
                            <div class="row">
                                <div class="col-sm-2">
                                    <h3 class="title">SPECIAL STYLES</h3>
                                    <ul>
                                        <li><a href="index.html">Home Slider Style</a></li>
                                        <li><a href="index-2.html">Home Map Style</a></li>
                                        <li><a href="index-3.html">Home Blog Style</a></li>
                                        <li><a href="list-property.html">List A Property</a></li>
                                        <li><a href="advanced-search.html">Advanced Search</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-2">
                                    <h3 class="title">PAGE STYLES</h3>
                                    <ul>
                                        <li><a href="page.html">Page Sidebar</a></li>
                                        <li><a href="fullwidth.html">Page Full Width</a></li>
                                        <li><a href="404.html">404 - Not Found</a></li>
                                        <li><a href="sitemap.html">Sitemap</a></li>
                                        <li><a href="login.html">Login / Register</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-2">
                                    <h3 class="title">LISTING VIEWS</h3>
                                    <ul>
                                        <li><a href="list-view.html">List view</a></li>
                                        <li><a href="grid-view.html">Grid view</a></li>
                                        <li><a href="with-google-map.html">With Google Map</a></li>
                                        <li><a href="single-property.html">Single Property Page</a></li>
                                        <li><a href="property-category.html">Property Category Page</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-2">
                                    <h3 class="title">AGENTS VIEWS</h3>
                                    <ul>
                                        <li><a href="about.html">About Us</a></li>
                                        <li><a href="agencies.html">Agencies Page</a></li>
                                        <li><a href="single-agency.html">Single Agency</a></li>
                                        <li><a href="agents.html">Agents Page</a></li>
                                        <li><a href="single-agent.html">Single Agent</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-2">
                                    <h3 class="title">GALLERY STYLES</h3>
                                    <ul>
                                        <li><a href="two-columns-gallery.html">Two Columns Gallery</a></li>
                                        <li><a href="three-columns-gallery.html">Three Columns Gallery</a></li>
                                        <li><a href="four-columns-gallery.html">Four Columns Gallery</a></li>
                                        <li><a href="single-gallery.html">Single Gallery Page</a></li>
                                        <li><a href="gallery-category.html">Gallery Category</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-2">
                                    <h3 class="title">BLOG STYLES</h3>
                                    <ul>
                                        <li><a href="blog.html">Standard Blog</a></li>
                                        <li><a href="two-blog.html">Two Columns Blog</a></li>
                                        <li><a href="grid-blog.html">Grid Style Blog</a></li>
                                        <li><a href="single-blog.html">Single Blog Page</a></li>
                                        <li><a href="blog-category.html">Blog Category</a></li>
                                    </ul>
                                </div>
                            </div><!-- end row -->
                        </li><!-- end grid demo -->
                    </ul><!-- end drop down menu -->
                </li><!-- end list elements -->
                <!-- list elements -->
                <li><a href="list-property.html">Menu Item 1</a></li>
                <!-- list elements -->
                <li><a href="list-property.html">Menu Item 2</a></li>
                <!-- standard drop down -->
                <li><a href="list-property.html">Menu Item 3</a></li>
                <li><a href="list-property.html">Menu Item 4</a></li>
            </ul>            
            <!-- end nav navbar-nav -->
        </div>
        <div class="navbar-tools">
            <!-- start: TOP NAVIGATION MENU -->
            <ul class="nav navbar-right">
                <!-- start: TO-DO DROPDOWN -->
                <li class="dropdown">
                    <a href="#" data-close-others="true" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                    <i class="clip-list-5"></i>
                    <span class="badge"> 12</span>
                    </a>
                    <ul class="dropdown-menu todo">
                        <li>
                            <span class="dropdown-menu-title"> You have 12 pending tasks</span>
                        </li>
                        <li>
                            <div class="drop-down-wrapper ps-container">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)" class="todo-actions">
                                        <i class="fa fa-square-o"></i>
                                        <span style="opacity: 1; text-decoration: none;" class="desc">Staff Meeting</span>
                                        <span style="opacity: 1;" class="label label-danger"> today</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="todo-actions">
                                        <i class="fa fa-square-o"></i>
                                        <span style="opacity: 1; text-decoration: none;" class="desc"> New frontend layout</span>
                                        <span style="opacity: 1;" class="label label-danger"> today</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="todo-actions">
                                        <i class="fa fa-square-o"></i>
                                        <span class="desc"> Hire developers</span>
                                        <span class="label label-warning"> tommorow</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="todo-actions">
                                        <i class="fa fa-square-o"></i>
                                        <span class="desc">Staff Meeting</span>
                                        <span class="label label-warning"> tommorow</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="todo-actions">
                                        <i class="fa fa-square-o"></i>
                                        <span class="desc"> New frontend layout</span>
                                        <span class="label label-success"> this week</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="todo-actions">
                                        <i class="fa fa-square-o"></i>
                                        <span class="desc"> Hire developers</span>
                                        <span class="label label-success"> this week</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="todo-actions">
                                        <i class="fa fa-square-o"></i>
                                        <span class="desc"> New frontend layout</span>
                                        <span class="label label-info"> this month</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="todo-actions">
                                        <i class="fa fa-square-o"></i>
                                        <span class="desc"> Hire developers</span>
                                        <span class="label label-info"> this month</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="todo-actions">
                                        <i class="fa fa-square-o"></i>
                                        <span style="opacity: 1; text-decoration: none;" class="desc">Staff Meeting</span>
                                        <span style="opacity: 1;" class="label label-danger"> today</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="todo-actions">
                                        <i class="fa fa-square-o"></i>
                                        <span style="opacity: 1; text-decoration: none;" class="desc"> New frontend layout</span>
                                        <span style="opacity: 1;" class="label label-danger"> today</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="todo-actions">
                                        <i class="fa fa-square-o"></i>
                                        <span class="desc"> Hire developers</span>
                                        <span class="label label-warning"> tommorow</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px; width: 270px; display: none;">
                                    <div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px; height: 250px; display: inherit;">
                                    <div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </li>
                        <li class="view-all">
                            <a href="javascript:void(0)">
                            See all tasks <i class="fa fa-arrow-circle-o-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- end: TO-DO DROPDOWN-->
                <!-- start: NOTIFICATION DROPDOWN -->
                <li class="dropdown">
                    <a href="#" data-close-others="true" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                    <i class="clip-notification-2"></i>
                    <span class="badge"> 11</span>
                    </a>
                    <ul class="dropdown-menu notifications">
                        <li>
                            <span class="dropdown-menu-title"> You have 11 notifications</span>
                        </li>
                        <li>
                            <div class="drop-down-wrapper ps-container">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)">
                                        <span class="label label-primary"><i class="fa fa-user"></i></span>
                                        <span class="message"> New user registration</span>
                                        <span class="time"> 1 min</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                        <span class="label label-success"><i class="fa fa-comment"></i></span>
                                        <span class="message"> New comment</span>
                                        <span class="time"> 7 min</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                        <span class="label label-success"><i class="fa fa-comment"></i></span>
                                        <span class="message"> New comment</span>
                                        <span class="time"> 8 min</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                        <span class="label label-success"><i class="fa fa-comment"></i></span>
                                        <span class="message"> New comment</span>
                                        <span class="time"> 16 min</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                        <span class="label label-primary"><i class="fa fa-user"></i></span>
                                        <span class="message"> New user registration</span>
                                        <span class="time"> 36 min</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                        <span class="label label-warning"><i class="fa fa-shopping-cart"></i></span>
                                        <span class="message"> 2 items sold</span>
                                        <span class="time"> 1 hour</span>
                                        </a>
                                    </li>
                                    <li class="warning">
                                        <a href="javascript:void(0)">
                                        <span class="label label-danger"><i class="fa fa-user"></i></span>
                                        <span class="message"> User deleted account</span>
                                        <span class="time"> 2 hour</span>
                                        </a>
                                    </li>
                                    <li class="warning">
                                        <a href="javascript:void(0)">
                                        <span class="label label-danger"><i class="fa fa-shopping-cart"></i></span>
                                        <span class="message"> Transaction was canceled</span>
                                        <span class="time"> 6 hour</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                        <span class="label label-success"><i class="fa fa-comment"></i></span>
                                        <span class="message"> New comment</span>
                                        <span class="time"> yesterday</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                        <span class="label label-primary"><i class="fa fa-user"></i></span>
                                        <span class="message"> New user registration</span>
                                        <span class="time"> yesterday</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                        <span class="label label-primary"><i class="fa fa-user"></i></span>
                                        <span class="message"> New user registration</span>
                                        <span class="time"> yesterday</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                        <span class="label label-success"><i class="fa fa-comment"></i></span>
                                        <span class="message"> New comment</span>
                                        <span class="time"> yesterday</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                        <span class="label label-success"><i class="fa fa-comment"></i></span>
                                        <span class="message"> New comment</span>
                                        <span class="time"> yesterday</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px; width: 270px; display: none;">
                                    <div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px; height: 250px; display: inherit;">
                                    <div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </li>
                        <li class="view-all">
                            <a href="javascript:void(0)">
                            See all notifications <i class="fa fa-arrow-circle-o-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- end: NOTIFICATION DROPDOWN -->
                <!-- start: MESSAGE DROPDOWN -->
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" class="dropdown-toggle">
                    <i class="clip-bubble-3"></i>
                    <span class="badge"> 9</span>
                    </a>
                    <ul class="dropdown-menu posts">
                        <li>
                            <span class="dropdown-menu-title"> You have 9 messages</span>
                        </li>
                        <li>
                            <div class="drop-down-wrapper ps-container">
                                <ul>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="clearfix">
                                                <div class="thread-image">
                                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/avatar-2.jpg" alt="">
                                                </div>
                                                <div class="thread-content">
                                                    <span class="author">Nicole Bell</span>
                                                    <span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</span>
                                                    <span class="time"> Just Now</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="clearfix">
                                                <div class="thread-image">
                                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/avatar-1.jpg" alt="">
                                                </div>
                                                <div class="thread-content">
                                                    <span class="author">Peter Clark</span>
                                                    <span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</span>
                                                    <span class="time">2 mins</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="clearfix">
                                                <div class="thread-image">
                                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/avatar-3.jpg" alt="">
                                                </div>
                                                <div class="thread-content">
                                                    <span class="author">Steven Thompson</span>
                                                    <span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</span>
                                                    <span class="time">8 hrs</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="clearfix">
                                                <div class="thread-image">
                                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/avatar-1.jpg" alt="">
                                                </div>
                                                <div class="thread-content">
                                                    <span class="author">Peter Clark</span>
                                                    <span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</span>
                                                    <span class="time">9 hrs</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="clearfix">
                                                <div class="thread-image">
                                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/avatar-5.jpg" alt="">
                                                </div>
                                                <div class="thread-content">
                                                    <span class="author">Kenneth Ross</span>
                                                    <span class="preview">Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</span>
                                                    <span class="time">14 hrs</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px; width: 270px; display: none;">
                                    <div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px; height: 250px; display: inherit;">
                                    <div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </li>
                        <li class="view-all">
                            <a href="pages_messages.html">
                            See all messages <i class="fa fa-arrow-circle-o-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- end: MESSAGE DROPDOWN -->
                <!-- start: USER DROPDOWN -->
                <li class="dropdown current-user">
                    <a href="#" data-close-others="true" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                    <img alt="" class="circle-img" src="<?php echo get_template_directory_uri();?>/assets/images/avatar-1-small.jpg">
                    <span class="username">Peter Clark</span>
                    <i class="clip-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="pages_user_profile.html">
                            <i class="clip-user-2"></i>
                            &nbsp;My Profile
                            </a>
                        </li>
                        <li>
                            <a href="pages_calendar.html">
                            <i class="clip-calendar"></i>
                            &nbsp;My Calendar
                            </a>
                        </li>
                        <li>
                            <a href="pages_messages.html">
                            <i class="clip-bubble-4"></i>
                            &nbsp;My Messages (3)
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="utility_lock_screen.html"><i class="clip-locked"></i>
                            &nbsp;Lock Screen </a>
                        </li>
                        <li>
                            <a href="login_example1.html">
                            <i class="clip-exit"></i>
                            &nbsp;Log Out
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- end: USER DROPDOWN -->
            </ul>
            <!-- end: TOP NAVIGATION MENU -->
        </div>
    </div>
</nav>
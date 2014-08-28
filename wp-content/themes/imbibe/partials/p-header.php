<div class="toolbar-wrapp">
    <div class="sticky-toolbar">
        <ul>
            <li id="support"><a title="Support Menu" title="" href="#" ><i class="fa fa-link"></i></a></li>
            <li id="help"><a href="#ContactFormModal" data-toggle="modal" title="Ask a question"><i class="fa fa-question"></i></a></li>
            <li id="accountlogin"><a title="Login account" href="#" ><i class="fa fa-lock"></i></a></li>
        </ul>
    </div>
    <!--/ sticky-toolbar-->
    <div class="popup">
        <ul>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="forum.html">Support</a></li>
            <li><a href="ticket.html">Open Ticket</a></li>
        </ul>
    </div>
    <!--/ popup-->
    <div class="loginpopup">
        <h3><i class="fa fa-key"></i> Agent Login Form</h3>
        <form id="loginform" method="post" name="loginform" action="http://designingmedia.com/html/estate-plus/login.php">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" placeholder="Username">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label><input type="checkbox"> Remember me</label>
                </div>
            </div>
            <div class="form-group">
                <a href="login.html" title="" class="btn btn-primary">Sign in</a> <a title="" href="login.html" class="btn btn-primary">Register</a>
            </div>
        </form>
    </div>
    <!--/ login-popup-->
</div>
<!--/ toolbar-wrapp-->
<div class="modal fade" id="ContactFormModal" tabindex="-1" role="dialog" aria-labelledby="ContactFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="big_title">Do you have questions?
                    <small>Dont worry! We're here to help you</small>
                </h3>
            </div>
            <div class="modal-body clearfix">
                <div class="text-left">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="ImageWrapper boxes_img">
                            <img src="<?php echo get_template_directory_uri(); ?>/demos/01_about.jpg" class="img-responsive" alt="">
                            <div class="ImageOverlayH"></div>
                            <div class="Buttons StyleSc">
                                <span class="WhiteSquare"><a href="#"><i class="fa fa-facebook"></i></a></span>
                                <span class="WhiteSquare"><a href="#"><i class="fa fa-twitter"></i></a></span>
                                <span class="WhiteSquare"><a href="#"><i class="fa fa-google-plus"></i></a></span>
                            </div>
                        </div>
                        <div class="servicetitle">
                            <h3>Contact Details</h3>
                        </div>
                        <ul>
                            <li><i class="fa fa-external-link"></i> www.yoursite.com</li>
                            <li><i class="fa fa-envelope"></i> info@yoursite.com</li>
                            <li><i class="fa fa-phone-square"></i> +90 333 444 55 66</li>
                            <li><i class="fa fa-phone-square"></i> +90 333 444 55 66</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <form id="contact" class="row" action="http://designingmedia.com/html/estate-plus/contact.php" name="contactform" method="post">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name"> 
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email"> 
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone">
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject"> 
                            <textarea class="form-control" name="comments" id="comments" rows="6" placeholder="Your Message ..."></textarea>
                            <button type="button" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php get_template_part('partials/p', 'top_nav'); ?>
<!-- end topbar -->
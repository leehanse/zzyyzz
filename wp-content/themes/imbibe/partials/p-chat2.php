<style>
.chats {
    margin: -15px 0 0;
    padding: 0;
}
.chats li {
    font-size: 12px;
    list-style: none outside none;
    margin: 10px auto;
    padding: 5px 0;
}
.chats li img.avatar {
    border-radius: 50% !important;
    height: 45px;
    width: 45px;
}
.chats li.in img.avatar {
    float: left;
    margin-right: 10px;
}
.chats li .name {
    color: #3590c1;
    font-size: 13px;
    font-weight: 400;
}
.chats li .datetime {
    color: #333;
    font-size: 13px;
    font-weight: 400;
}
.chats li.out img.avatar {
    float: right;
    margin-left: 10px;
}
.chats li .message {
    display: block;
    padding: 5px;
    position: relative;
}
.chats li.in .message {
    background: none repeat scroll 0 0 #fafafa;
    border-left: 2px solid #35aa47;
    margin-left: 65px;
    text-align: left;
}
.chats li.in .message .arrow {
    border-bottom: 8px solid transparent;
    border-right: 8px solid #35aa47;
    border-top: 8px solid transparent;
    display: block;
    height: 0;
    left: -8px;
    position: absolute;
    top: 5px;
    width: 0;
}
.chats li.out .message .arrow {
    border-bottom: 8px solid transparent;
    border-left: 8px solid #da4a38;
    border-top: 8px solid transparent;
    display: block;
    position: absolute;
    right: -8px;
    top: 5px;
}
.chats li.out .message {
    background: none repeat scroll 0 0 #fafafa;
    border-right: 2px solid #da4a38;
    margin-right: 65px;
    text-align: right;
}
.chats li.out .name, .chats li.out .datetime {
    text-align: right;
}
.chats li .message .body {
    display: block;
}
.chat-form {
    background-color: #e9eff3;
    clear: both;
    margin-top: 15px;
    overflow: hidden;
    padding: 10px;
}
.chat-form .input-cont {
    margin-right: 40px;
}
.chat-form .input-cont .form-control {
    margin-bottom: 0;
    width: 100% !important;
}
.chat-form .input-cont input {
    border: 1px solid #ddd;
    margin-top: 0;
    width: 100% !important;
}
.chat-form .input-cont input {
    background-color: #fff !important;
}
.chat-form .input-cont input:focus {
    border: 1px solid #4b8df9 !important;
}
.chat-form .btn-cont {
    float: right;
    margin-top: -42px;
    position: relative;
    width: 44px;
}
.chat-form .btn-cont .arrow {
    border-bottom: 8px solid transparent;
    border-right: 8px solid #4d90fe;
    border-top: 8px solid transparent;
    box-sizing: border-box;
    position: absolute;
    right: 43px;
    top: 17px;
}
.chat-form .btn-cont:hover .arrow {
    border-right-color: #0362fd;
}
.chat-form .btn-cont:hover .btn {
    background-color: #0362fd;
}
.chat-form .btn-cont .btn {
    margin-top: 8px;
}    
</style>    
<ul class="chats">
    <li class="in">
            <img src="assets/img/avatar1.jpg" alt="" class="avatar img-responsive">
            <div class="message">
                    <span class="arrow">
                    </span>
                    <a class="name" href="#">
                             Bob Nilson
                    </a>
                    <span class="datetime">
                             at Jul 25, 2012 11:09
                    </span>
                    <span class="body">
                             Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                    </span>
            </div>
    </li>
    <li class="out">
            <img src="assets/img/avatar2.jpg" alt="" class="avatar img-responsive">
            <div class="message">
                    <span class="arrow">
                    </span>
                    <a class="name" href="#">
                             Lisa Wong
                    </a>
                    <span class="datetime">
                             at Jul 25, 2012 11:09
                    </span>
                    <span class="body">
                             Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                    </span>
            </div>
    </li>
    <li class="in">
            <img src="assets/img/avatar1.jpg" alt="" class="avatar img-responsive">
            <div class="message">
                    <span class="arrow">
                    </span>
                    <a class="name" href="#">
                             Bob Nilson
                    </a>
                    <span class="datetime">
                             at Jul 25, 2012 11:09
                    </span>
                    <span class="body">
                             Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                    </span>
            </div>
    </li>
    <li class="out">
            <img src="assets/img/avatar3.jpg" alt="" class="avatar img-responsive">
            <div class="message">
                    <span class="arrow">
                    </span>
                    <a class="name" href="#">
                             Richard Doe
                    </a>
                    <span class="datetime">
                             at Jul 25, 2012 11:09
                    </span>
                    <span class="body">
                             Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                    </span>
            </div>
    </li>
    <li class="in">
            <img src="assets/img/avatar3.jpg" alt="" class="avatar img-responsive">
            <div class="message">
                    <span class="arrow">
                    </span>
                    <a class="name" href="#">
                             Richard Doe
                    </a>
                    <span class="datetime">
                             at Jul 25, 2012 11:09
                    </span>
                    <span class="body">
                             Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                    </span>
            </div>
    </li>
    <li class="out">
            <img src="assets/img/avatar1.jpg" alt="" class="avatar img-responsive">
            <div class="message">
                    <span class="arrow">
                    </span>
                    <a class="name" href="#">
                             Bob Nilson
                    </a>
                    <span class="datetime">
                             at Jul 25, 2012 11:09
                    </span>
                    <span class="body">
                             Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                    </span>
            </div>
    </li>
    <li class="in">
            <img src="assets/img/avatar3.jpg" alt="" class="avatar img-responsive">
            <div class="message">
                    <span class="arrow">
                    </span>
                    <a class="name" href="#">
                             Richard Doe
                    </a>
                    <span class="datetime">
                             at Jul 25, 2012 11:09
                    </span>
                    <span class="body">
                             Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                    </span>
            </div>
    </li>
    <li class="out">
            <img src="assets/img/avatar1.jpg" alt="" class="avatar img-responsive">
            <div class="message">
                    <span class="arrow">
                    </span>
                    <a class="name" href="#">
                             Bob Nilson
                    </a>
                    <span class="datetime">
                             at Jul 25, 2012 11:09
                    </span>
                    <span class="body">
                             Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. sed diam nonummy nibh euismod tincidunt ut laoreet.
                    </span>
            </div>
    </li>
</ul>
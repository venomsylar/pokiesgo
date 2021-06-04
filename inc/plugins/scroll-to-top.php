<?php
add_action( 'admin_head-post.php', 'scroll_to_top' );

function scroll_to_top()
{
    ?>
    <style>

        #submitdiv {
            position: sticky;
            top: 52px;
            z-index: 9999;
        }

        #postbox-container-1 {
            position: absolute;
            right: 20px;
            margin-right: 0 !important;
            height: 100%;
        }

        #side-sortables {
            min-height: 100%!important;
        }

        #box {
            position: fixed;
            right: 20px;
            bottom: 35px;
            visibility: hidden;
            opacity: 0;
            z-index: -100;
            transition: all ease 0.35s;
        }
        #box.active {
            visibility: visible;
            opacity: 1;
            z-index: 250;
        }
        #box a {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #00b9eb;;
            color: #fff;
            display: inline-block;
            position: relative;
            outline: none;
        }
        #box a:before {
            content: "\f342";
            font-family: dashicons;
            font-size: 20px;
            display: inline-block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
        }
    </style>

    <script type="text/javascript">

        /*Scroll top*/
        function showScrollTop() {
            if (jQuery(window).scrollTop() > 100) {
                jQuery("#box").addClass('active');
            }
            else {
                jQuery("#box").removeClass('active');
            }
        }
        jQuery(window).load( function() {
            showScrollTop();
            jQuery(window).scroll(function () {
                showScrollTop();
            });
            jQuery('<div id="box"><a href="#wpwrap"></a></div>').appendTo("#wpbody-content");
            jQuery('<a name="top" id="top"></a>').appendTo("#visibility");
            /*Scroll top Click*/
	        jQuery("#box").on("click","a", function (event) {
                event.preventDefault();
                let id  = jQuery(this).attr('href'),
                    top = jQuery(id).offset().top - 32;
                jQuery('html, body').animate({scrollTop: top}, 500);
            });

        });

    </script>
    <?php
}
<?php /*Template Name: Redirection*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow" />
    <title>Redirection</title>
    <style>
        h1 {
            margin-top: 0;
            margin-bottom: 0;
        }
        .container {
            margin: 0 auto;
            width: 12000px;
            max-width: 94%;
            position: relative;
        }

        .redirection_block {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        img {
            margin: 0 auto;
        }

    </style>
</head>
<body>
<div class="redirection_block">
    <?php
    $url_params = $_GET;
    unset($url_params['id']);
    ?>
    <?php if(isset($_GET['id'])){
        $url = get_field('referral_link_casino',$_GET['id']);
        $logo = get_the_post_thumbnail_url($_GET['id']);
    if($logo){ ?>
        <div class="container">
            <h1><?php echo 'Redirect to '.get_the_title($_GET['id']).''; ?></h1>
            <img src="<?php echo $logo; ?>" alt="<?php echo get_the_title($_GET['id']); ?>">
        </div>
    <?php } ?>
        <script>
            window.opener=null;setTimeout(function(){encodeURIComponent(window.location.href='<?php echo $url; ?>')}, 400)
        </script>
    <?php } else {
        exit();
    } ?>
</div>
</body>
</html>
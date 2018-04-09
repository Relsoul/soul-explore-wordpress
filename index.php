<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php
        wp_head();

    ?>

    <?php
//    echo "<pre>";
//    print_r($res);
//    echo "</pre>";


    ?>

    <link href="https://cdn.bootcss.com/material-design-icons/3.0.1/iconfont/material-icons.min.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri() ?>/assets/css/main.css" rel="stylesheet">
</head>
<body>

<div id="app"><router-view></router-view></div>

<script src="<?php echo get_template_directory_uri()?>/assets/js/main.js"></script>
<?php
wp_footer()
?>
</body>
</html>







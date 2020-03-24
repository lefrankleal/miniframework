<?php
$min = ENV == 'prod' ? '.min' : '';
?>
<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="<?php echo LANG; ?>">
    <!--<![endif]-->

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no" />

        <link rel="icon" type="image/png" href="/assets/img/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="/assets/img/favicon-32x32.png" sizes="32x32">

        <title>
            <?php echo mb_convert_case(SYSTEMNAME, MB_CASE_TITLE); ?>
        </title>

        <!-- Here goes you global styles -->

        <!-- site custom css -->
        <link rel="stylesheet" href="/assets/css/custom<?php echo $min ?>.css" media="all">

        <?php
        if (file_exists("assets/css/pages/" . PAGE . $min. ".css") && is_readable("assets/css/pages/" . PAGE . $min. ".css")) {
            echo '<link rel="stylesheet" href="/assets/css/pages/' . PAGE . $min. '.css" media="all">';
        } ?>

    </head>

    <body class="sidebar_main_swipe">
<?php
$baseUrl = $context->getBaseUrl();
$context->setBaseUrl('');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $seo['title'] ?></title>
    <meta name="description" content="<?php echo $seo['description'] ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/assets/components/bootstrap/css/bootstrap.css?minify=true" type="text/css">
    <link rel="stylesheet" href="/assets/components/bootstrap/css/bootstrap-responsive.css?minify=true" type="text/css">
    <link rel="stylesheet" href="/assets/application/css/strip.css?minify=true" type="text/css">
    <link rel="stylesheet" href="/assets/application/css/strip-responsive.css?minify=true" type="text/css">
    <!-- Le HTML5 shiv, for IE6-9 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="/assets/components/html5shiv/dist/html5shiv.js?minify=true"></script>
        <![endif]-->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,700' rel='stylesheet' type='text/css'>

    <script type="text/javascript" src="/assets/components/jquery/js/jquery.js?minify=true"></script>
    <script type="text/javascript" src="/assets/components/bootstrap/js/bootstrap.js?minify=true"></script>
    <script type="text/javascript" src="/assets/application/js/application-promo.js?minify=true"></script>

</head>
<body>

<section class="container">
    <nav class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <a href="/" class="brand">SoCool Framework</a>

            <ul class="nav">
                <li class="active"><a href="#">Home </a></li>
                <li><a href="#">Blog</a></li>
            </ul>
            </div>
        </div>
    </nav>
</section>
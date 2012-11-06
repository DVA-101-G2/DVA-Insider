<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/main.css">
        <script src="/js/vendor/modernizr-2.6.1.min.js"></script>
    </head>
    <body>
		<div id="popup" style="display:none;">
			<div class="container">
				<div class="header"><span></span><div class="close"></div></div>
				<div class="content"><img src="<?php echo base_url(); ?>img/loading.gif" alt="loading" /></div>
			</div>
		</div>

        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class="wrapper">

            <header>
                <div class="inner-header">
                    <div class="logotype">
                    </div>
                    <div class="links">
                        <ul>
                            <li onclick="location.href='/'" class="active">
                                <i class="icon-home"></i>
                                Start
                            </li>

                            <li onclick="location.href='/user'">
                                <i class="icon-users"></i>
                                Användare
                            </li>

                            <li onclick="location.href='#'">
                                <i class="icon-projects"></i>
                                Projekt
                            </li>

                            <li onclick="location.href='#'">
                                <i class="icon-search"></i>
                                Sök
                            </li>
							<li class="login" onclick="openPopup('Logga in', '<?php echo site_url('/user/login'); ?>');">
								<?php if($user = $this->usermodel->get_user()): ?>
								<div class="header"><img src="<?php echo site_url('/user/image/'.$user->user_id); ?>" class="image" /> <?php echo $user->user_firstname; ?> <?php echo $user->user_surname; ?></div>
								<?php else: ?>
                                <i class="icon-login"></i>
								<span>Logga in</span>
								<?php endif; ?>
                            </li>
                        </ul>
                    </div> <!-- end of links -->
                </div> <!-- end of inner-header -->
            </header>

            <div class="fixedheader">
                <div class="inner-fixed">
                    <div class="logotype">
                        mini-logo goes here :)
                    </div>
                    <div class="links">
                        <ul>
                            <li onclick="location.href='#'">
                                Start
                            </li>
                            <li onclick="location.href='#'">
                                Användare
                            </li>
                            <li onclick="location.href='#'">
                                Projekt
                            </li>
                            <li onclick="location.href='#'">
                                Sök
                            </li>
                        </ul>
                    </div> <!-- end of links -->
                </div> <!-- end of inner-fixed -->
            </div> <!-- end of fixedheader -->

            <div class="main">
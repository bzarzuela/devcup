<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nous - Connecting Brands With Their Movers</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/custom.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css" media="screen">
        .positive {
            padding: 10px;
            margin-bottom: 30px;
            font-size: 18px;
            font-weight: 200;
            line-height: 30px;
            color: white;
            background-color: #2DD00B;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
              border-radius: 6px;
        }

        .neutral {
            padding: 10px;
            margin-bottom: 30px;
            font-size: 18px;
            font-weight: 200;
            line-height: 30px;
            color: #000000;
            background-color: #FAF4E3;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
              border-radius: 6px;
        }

        .negative {
            padding: 10px;
            margin-bottom: 30px;
            font-size: 18px;
            font-weight: 200;
            line-height: 30px;
            color: white;
            background-color: #F02311;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
              border-radius: 6px;

        }
    </style>
</head>

<body id="page-top" data-target=".navbar-fixed-top">

    <!-- Navigation -->
<?php include('header.php'); ?>

    <!-- Content Area -->
    <header class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div>
                            <span id="progress"><?php echo $job->progress ?></span> out of <span id="target"><?php echo $job->target ?></span> complete.
                        </div>

                        <div id="tweet">
                            Please wait...
                        </div>

                        <div id="sentiment"></div>

                        <div id="mover"></div>

                        <div style="display: none" id="pay">
                            <p>You're done!</p>
                            <a href="<?php echo url('pay') ?>">Pay here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Footer -->
<?php include('footer.php'); ?>

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>

    <script src="/js/sock.js"></script>
    <script src="/js/chat.js"></script>

    <script>
    var channel = 'job-<?php echo $job->id ?>';
    </script>
    <script src="/js/live.js"></script>
</body>

</html>

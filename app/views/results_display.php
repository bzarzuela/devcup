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

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="away">
                <h1>Thank you for using NOUS. Here are your <?php echo $job->target ?> most influential movers for <?php echo $job->keyword?>:</h1>
                <br>
                <?php foreach ($influencers as $influencer): ?>
                    <div class="row col-md-6 mover">
                    <img src="images/twitterpic.jpg" height="150px">
                    <p class="twit-excerpt">"<?php echo $influencer->excerpt ?>"</p></a>
                    <p><a href="https://twitter.com/<?php echo $influencer->screen_name ?>">@<?php echo $influencer->screen_name ?></a>
                    <br>No of Followers
                    <br>No of Retweets
                    </p>
                </div>
            <?php endforeach; ?>


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

</body>

</html>

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

<body id="page-top" data-target=".navbar-fixed-top">

    <!-- Navigation -->
<?php include('header.php'); ?>

    <!-- Content Area -->
    <header class="intro">
        <div class="intro-body">
            <div class="container">
              <form action="" method="post">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1>Connect with your movers</h1>
                        <div class="input-group">
                          <span class="input-group-addon">Brand</span>
                          <input name="keyword" type="text" class="form-control" placeholder="Enter one only. For example: 'Coca-Cola'">
                        </div>
                        <br>
                        <div class="input-group">
                          <span class="input-group-addon">How many movers do you want us to find for you?</span>
                          <select name="target" class="form-control">
                            <option value="5">5</option>}
                            <option value="10">10</option>}
                            <option value="50">50</option>}
                            <option value="100">100</option>}
                          </select>
                        </div>
                        <br>
                        <br>
                      <input type="submit" value="Submit" class="btn btn-default">
                    </div>
                </div>
              </form>
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

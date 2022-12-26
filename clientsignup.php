<html>

<head>
    <title> Personel Kayıt | Araba Kiralama  </title>
</head>
<link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/clientlogin.css">
<body>
     <!-- Navigation -->
     <nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand page-scroll" href="index.php">
                   Araba kirala </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <?php
                if(isset($_SESSION['login_client'])){
            ?>
                <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="index.php">Anasayfa</a>
                        </li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-user"></span> Hoşgeldin <?php echo $_SESSION['login_client']; ?></a>
                        </li>
                        <li>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Kontrol Paneli <span class="caret"></span> </a>
                                    <ul class="dropdown-menu">
                                        <li> <a href="entercar.php">Araba ekle</a></li>
                                        <li> <a href="enterdriver.php"> Sürücü ekle</a></li>
                                        <li> <a href="clientview.php">Görüntüle</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Çıkış yap</a>
                        </li>
                    </ul>
                </div>
                <?php
                }
                else if (isset($_SESSION['login_customer'])){
            ?>
                    <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="index.php">Anasayfa</a>
                            </li>
                            <li>
                                <a href="#"><span class="glyphicon glyphicon-user"></span> Hoşgeldin <?php echo $_SESSION['login_customer']; ?></a>
                            </li>
                            <li>
                                <a href="#">Tarih</a>
                            </li>
                            <li>
                                <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Çıkış yap</a>
                            </li>
                        </ul>
                    </div>

                    <?php
            }
                else {
            ?>

                        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="index.php">Anasayfa</a>
                                </li>
                                <li>
                                    <a href="clientlogin.php">Personel</a>
                                </li>
                                <li>
                                    <a href="customerlogin.php">Müşteri</a>
                                </li>
                                <li>
                                    <a href="#"> SSS </a>
                                </li>
                            </ul>
                        </div>
                        <?php   }
                ?>
                        <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div class="container">
        <div class="jumbotron">
            <h1 class="text-center">Araba Kiralama - Kayıt olma</h1>
            <br>
            <p class="text-center">Bir Personel hesabı oluşturarak başlayın</p>
        </div>
    </div>

    <div class="container" style="margin-top: -1%; margin-bottom: 2%;">
        <div class="col-md-5 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading"> Hesap oluştur </div>
                <div class="panel-body">

                    <form role="form" action="client_registered_success.php" method="POST">

                        <div class="row">
                            <div class="form-group col-xs-12">
                                <label for="client_name"><span class="text-danger" style="margin-right: 5px;">*</span> Ad soyad: </label>
                                <div class="input-group">
                                    <input class="form-control" id="client_name" type="text" name="client_name" placeholder="Ad soyad" required="" autofocus="">
                                    <span class="input-group-btn">
                  <label class="btn btn-primary"><span class="glyphicon glyphicon-user" aria-hidden="true"></label>
              </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-xs-12">
                                <label for="client_username"><span class="text-danger" style="margin-right: 5px;">*</span> Kullanıcı adı: </label>
                                <div class="input-group">
                                    <input class="form-control" id="client_username" type="text" name="client_username" placeholder="Kullanıcı adı" required="">
                                    <span class="input-group-btn">
                  <label class="btn btn-primary"><span class="glyphicon glyphicon-user" aria-hidden="true"></label>
              </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-xs-12">
                                <label for="client_email"><span class="text-danger" style="margin-right: 5px;">*</span> Email: </label>
                                <div class="input-group">
                                    <input class="form-control" id="client_email" type="email" name="client_email" placeholder="Email" required="">
                                    <span class="input-group-btn">
                  <label class="btn btn-primary"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></label>
              </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-xs-12">
                                <label for="client_phone"><span class="text-danger" style="margin-right: 5px;">*</span> Telefon numarası: </label>
                                <div class="input-group">
                                    <input class="form-control" id="client_phone" type="text" name="client_phone" placeholder="Telefon numarası" required="">
                                    <span class="input-group-btn">
                  <label class="btn btn-primary"><span class="glyphicon glyphicon-contact" aria-hidden="true"></span></label>
                                    </span>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-xs-12">
                                <label for="client_address"><span class="text-danger" style="margin-right: 5px;">*</span> Adres: </label>
                                <div class="input-group">
                                    <input class="form-control" id="client_address" type="text" name="client_address" placeholder="Adres" required="">
                                    <span class="input-group-btn">
                  <label class="btn btn-primary"><span class="glyphicon glyphicon-home" aria-hidden="true"></label>
              </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-xs-12">
                                <label for="client_password"><span class="text-danger" style="margin-right: 5px;">*</span> Şifre: </label>
                                <div class="input-group">
                                    <input class="form-control" id="client_password" type="password" name="client_password" placeholder="Şifren" required="">
                                    <span class="input-group-btn">
                  <label class="btn btn-primary"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></label>
                                    </span>

                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="form-group col-xs-4">
                                <button class="btn btn-primary" type="submit">Onayla</button>
                            </div>

                        </div>
                        <label style="margin-left: 5px;">Veya</label> <br>
                        <label style="margin-left: 5px;"><a href="clientlogin.php">Hesabınız var mı? Giriş yap.</a></label>

                    </form>

                </div>

            </div>

        </div>
    </div>
</body>
<footer class="site-footer">
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-6">
                <h5>© <?php echo date("Y"); ?> Kiralık araba</h5>
            </div>
        </div>
    </div>
</footer>

</html>
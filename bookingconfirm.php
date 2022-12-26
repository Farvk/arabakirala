<!DOCTYPE html>
<html>

<?php 
 include('session_customer.php');
if(!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customerlogin.php");
}
?>

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/png" href="assets/img/P.png.png">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/w3css/w3.css">
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/bookingconfirm.css" />
</head>

<body>

<?php


    $type = $_POST['radio'];
    $charge_type = $_POST['radio1'];
    $driver_id = $_POST['driver_id_from_dropdown'];
    $customer_username = $_SESSION["login_customer"];
    $car_id = $conn->real_escape_string($_POST['hidden_carid']);
    $rent_start_date = date('Y-m-d', strtotime($_POST['rent_start_date']));
    $rent_end_date = date('Y-m-d', strtotime($_POST['rent_end_date']));
    $return_status = "NR"; // not returned
    $fare = "NA";


    function dateDiff($start, $end) {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }
    
    $err_date = dateDiff("$rent_start_date", "$rent_end_date");

    $sql0 = "SELECT * FROM cars WHERE car_id = '$car_id'";
    $result0 = $conn->query($sql0);

    if (mysqli_num_rows($result0) > 0) {
        while($row0 = mysqli_fetch_assoc($result0)) {

            if($type == "ac" && $charge_type == "km"){
                $fare = $row0["ac_price"];
            } else if ($type == "ac" && $charge_type == "days"){
                $fare = $row0["ac_price_per_day"];
            } else if ($type == "non_ac" && $charge_type == "km"){
                $fare = $row0["non_ac_price"];
            } else if ($type == "non_ac" && $charge_type == "days"){
                $fare = $row0["non_ac_price_per_day"];
            } else {
                $fare = "NA";
            }
        }
    }
    if($err_date >= 0) { 
    $sql1 = "INSERT into rentedcars(customer_username,car_id,driver_id,booking_date,rent_start_date,rent_end_date,fare,charge_type,return_status) 
    VALUES('" . $customer_username . "','" . $car_id . "','" . $driver_id . "','" . date("Y-m-d") ."','" . $rent_start_date ."','" . $rent_end_date . "','" . $fare . "','" . $charge_type . "','" . $return_status . "')";
    $result1 = $conn->query($sql1);

    $sql2 = "UPDATE cars SET car_availability = 'no' WHERE car_id = '$car_id'";
    $result2 = $conn->query($sql2);

    $sql3 = "UPDATE driver SET driver_availability = 'no' WHERE driver_id = '$driver_id'";
    $result3 = $conn->query($sql3);

    $sql4 = "SELECT * FROM  cars c, clients cl, driver d, rentedcars rc WHERE c.car_id = '$car_id' AND d.driver_id = '$driver_id' AND cl.client_username = d.client_username";
    $result4 = $conn->query($sql4);


    if (mysqli_num_rows($result4) > 0) {
        while($row = mysqli_fetch_assoc($result4)) {
            $id = $row["id"];
            $car_name = $row["car_name"];
            $car_nameplate = $row["car_nameplate"];
            $driver_name = $row["driver_name"];
            $driver_gender = $row["driver_gender"];
            $dl_number = $row["dl_number"];
            $driver_phone = $row["driver_phone"];
            $client_name = $row["client_name"];
            $client_phone = $row["client_phone"];
        }
    }

    if (!$result1 | !$result2 | !$result3){
        die("Couldnt enter data: ".$conn->error);
    }

?>
<!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand page-scroll" href="index.php">
                   Kiralık araba </a>
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
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Kontrol paneli <span class="caret"></span> </a>
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
                    <ul class="nav navbar-nav">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Garagge <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="prereturncar.php">Şimdi dön</a></li>
              <li> <a href="mybookings.php"> Rezarvasyonlarım</a></li>
            </ul>
            </li>
          </ul>
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
            <h1 class="text-center" style="color: green;"><span class="glyphicon glyphicon-ok-circle"></span> Rezervasyon onaylandı.</h1>
        </div>
    </div>
    <br>

    <h2 class="text-center"> Araç Kiralama Sistemini kullandığınız için teşekkür ederiz! Güvenli sürüşler dileriz. </h2>

 

    <h3 class="text-center"> <strong>Sipariş numaranız:</strong> <span style="color: blue;"><?php echo "$id"; ?></span> </h3>


    <div class="container">
        <h5 class="text-center">Lütfen siparişinizle ilgili aşağıdaki bilgileri okuyunuz.</h5>
        <div class="box">
            <div class="col-md-10" style="float: none; margin: 0 auto; text-align: center;">
                <h3 style="color: orange;">Rezervasyonunuz alındı ve sipariş dışı işleme sistemine yerleştirildi.</h3>
                <br>
                <h4>Numaranızı <strong>order number</strong> Bizimle iletişime geçmeniz gerekirse diye kaydedin.</h4>
                <br>
                <h3 style="color: orange;">Fatura</h3>
                <br>
            </div>
            <div class="col-md-10" style="float: none; margin: 0 auto; ">
                <h4> <strong>Araç adı: </strong> <?php echo $car_name; ?></h4>
                <br>
                <h4> <strong>Araç numarası:</strong> <?php echo $car_nameplate; ?></h4>
                <br>
                
                <?php     
                if($charge_type == "days"){
                ?>
                     <h4> <strong>Fare:</strong> Rs. <?php echo $fare; ?>/day</h4>
                <?php } else {
                    ?>
                    <h4> <strong>Fare:</strong> Rs. <?php echo $fare; ?>/km</h4>

                <?php } ?>

                <br>
                <h4> <strong>Booking Date: </strong> <?php echo date("Y-m-d"); ?> </h4>
                <br>
                <h4> <strong>Başlama tarihi: </strong> <?php echo $rent_start_date; ?></h4>
                <br>
                <h4> <strong>Bırakma tarihi: </strong> <?php echo $rent_end_date; ?></h4>
                <br>
                <h4> <strong>Sürücü adı: </strong> <?php echo $driver_name; ?> </h4>
                <br>
                <h4> <strong>Sürücü cinsiyeti: </strong> <?php echo $driver_gender; ?> </h4>
                <br>
                <h4> <strong>Sürücü lisans numarası: </strong>  <?php echo $dl_number; ?> </h4>
                <br>
                <h4> <strong>Sürücü iletişim numarası:</strong>  <?php echo $driver_phone; ?></h4>
                <br>
                <h4> <strong>Personel adı:</strong>  <?php echo $client_name; ?></h4>
                <br>
                <h4> <strong>Personel iletişim numarsı: </strong> <?php echo $client_phone; ?></h4>
                <br>
            </div>
        </div>
        <div class="col-md-12" style="float: none; margin: 0 auto; text-align: center;">
            <h6>Dikkat! <strong>Bu sayfayı yeniden yüklemeyin</strong> aksi takdirde yukarıdaki ekran kaybolacaktır. Bu sayfanın basılı bir kopyasını istiyorsanız, lütfen şimdi yazdırın.</h6>
        </div>
    </div>
</body>
<?php } else { ?>
    <!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand page-scroll" href="index.php">
                   Kiralık araba </a>
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
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Kontrol paneli <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="entercar.php">Araba ekle</a></li>
              <li> <a href="enterdriver.php"> sürücü ekle</a></li>
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
                    <ul class="nav navbar-nav">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Garaj <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="prereturncar.php">Şimdi dön</a></li>
              <li> <a href="mybookings.php"> Rezervasyonlarım</a></li>
            </ul>
            </li>
          </ul>
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
	<div class="jumbotron" style="text-align: center;">
        Yanlış bir tarih seçtiniz.
        <br><br>
</div>
                <?php } ?>
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
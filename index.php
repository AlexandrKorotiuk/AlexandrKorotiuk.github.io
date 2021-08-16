<?php
if (isset($_POST["submit"])) {
    $hostname = "localhost";
    $dbname = "test";
    $dbUser = "root";
    $dbPassword = "";
    $email = $_POST["email"];
    $lastname = $_POST["lastname"];
    $firstname = $_POST["firstname"];
    $messsage = $_POST["message"];
    $rating  = intval($_POST['rating']);
    $errors = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        $errors["errorEmail"] =  "Недопустимый емайл";
    }
    if (mb_strlen($lastname) < 3 || empty($lastname)) {
        $errors["errorLastname"] = "Недопустимая фамилия";
    }
    if (mb_strlen($firstname) < 3 || empty($firstname) ) {
        $errors["errorFirstname"] = "Недопустим имя";
    }
    if (empty($rating)) {
        $errors["errorRating"] = "Оцените товар!"; 
    }
    if (mb_strlen($message) > 1000) {
        $errors["errorMessage"] = "Недопустимое количество символов";
    }
    if(empty($errors)){
        $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $dbUser, $dbPassword);
        $sth = $dbh->prepare(
            "INSERT INTO comments (email, firstname, lastname, message,rating) 
                VALUES (:email,:firstname, :lastname, :message, :rating)"
        );
        $sth->bindParam(":rating", $rating);
        $sth->bindParam(":email", $email);
        $sth->bindParam(":firstname", $firstname);
        $sth->bindParam(":lastname", $lastname);
        $sth->bindParam(":message", $messsage);
        $sth->execute();
    } else  {
        $_SESSION["errors"] = $errors;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Products</title>
</head>
<body>
<header class="header">
                <div class="container">
                    <div class="header_iner">
                        <div class="header_logo">Products</div>
                            <nav class="nav">
                                <a class="nav__link" href="#">Home</a> 
                                <a class="nav__link" href="#">Servis</a>
                                <a class="nav__link" href="#">Work</a>
                                <a class="nav__link" href="#">Block</a>
                                <a class="nav__link" href="#">Contact</a>
                            </nav>
                    </div>
                </div>
</header>
    <section class= "section">
        <div class="container">
            <hr>
            <div class="products">
                <div class="products-item">
                    <div class="img-mod">
                        <img src="/img/iphone-white.jpg" class="product-img">
                    </div>
                </div>
                <div class="products-item">
                    <h2 class="title-products">Apple iPhone 13 64 Gb White </h2>
                    <div class="description">
                        <ul>
                            <li>Модель процесора: Apple A13 Bionic</li>
                            <li>Кількість ядер: 6 ядер</li>
                            <li>Вбудована пам'ять: 128 ГБ</li>
                            <li>Діагональ дисплея: 6,1''</li>
                            <li>Частота оновлення екрану: 60 Гц</li>
                            <li>Bluetooth: Версія 5.0</li>
                            <li>Ємність акумулятора: 3110 мАг</li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-reply">
                <form method="post" action="" id="coments-form">

                <div class="rating-area">
                    <?php   $star5 = 5;
                            $star4 = 4;
                            $star3 = 3;
                            $star2 = 2;
                            $star1 = 1;
                    ?>
                        <input class="ratingmodestar" data-star = "<?php echo $star5?>"  type ="radio" id="star-5" name="rating" value="5">  
                        <label for="star-5" title="Оценка «5»"></label>	
                        <input class="ratingmodestar" data-star = "<?php echo $star4?>" type="radio" id="star-4" name="rating" value="4">
                        <label  for="star-4" title="Оценка «4»"></label>    
                        <input class="ratingmodestar" data-star = "<?php echo $star3?>" type="radio" id="star-3" name="rating" value="3">
                        <label for="star-3" title="Оценка «3»"></label>  
                        <input class="ratingmodestar" data-star = "<?php echo $star2?>" type="radio" id="star-2" name="rating" value="2">
                        <label for="star-2" title="Оценка «2»"></label>    
                        <input class="ratingmodestar" data-star = "<?php echo $star1?>" type="radio" id="star-1" name="rating" value="1">
                        <label for="star-1" title="Оценка «1»"></label>
                        <?php if(isset($_SESSION["errors"])){
                            echo '<p class = "error">'.$_SESSION["errors"]["errorRating"].'</p>';
                            } ?>
                </div>
                       
                    <input  class="input-reply" type="email" name="email" placeholder="email" id="email-comment-id"><br>
                    <?php if(isset($_SESSION["errors"])){
                        echo '<p class = "error">'.$_SESSION["errors"]["errorEmail"].'</p>';
                        } ?>
                    <input  class="input-reply" type="text" name="firstname" placeholder="Имя" id="firstname-comment-id"><br>
                    <?php if(isset($_SESSION["errors"])){
                        echo '<p class = "error">'.$_SESSION["errors"]["errorFirstname"].'</p>';
                        } ?>

                    <input  class="input-reply" type="text" name="lastname" placeholder="Фамилия" id ="lastname-comment-id"><br>
                    <?php if(isset($_SESSION["errors"])){
                        echo '<p class = "error">'.$_SESSION["errors"]["errorLastname"].'</p>';
                        } ?>

                    <textarea  cols="100" rows="10" name="message" id="text-comment" ></textarea><br>
                    <?php if(isset($_SESSION["errors"])){
                        echo '<p class = "error">'.$_SESSION["errors"]["errorMessage"].'</p>';
                        } ?>
                    <input class="btn-register" type="button"  name="submit" value="Отправить" id="btn-comment"><br><br>
                </form>
            </div>
            <div class="answer" id="comments">

                <h1 class="comment-answer">Отзывы</h1>
                <?php
                $hostname = "localhost";
                $dbname = "test";
                $dbUser = "root";
                $dbPassword = "";
                $dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $dbUser, $dbPassword);
                $sth = $dbh->prepare("SELECT * FROM  comments");
                $sth->execute();
                foreach ($sth as $message) {
                    echo '<div class = "comment-block">';
                        echo '<p class = "username-comment">'.$message["firstname"]." ".$message["lastname"].":".'</p>';
                        echo '<p class = "message-comment">'.$message["message"].'</p>';
                        echo '<p class = "comment-rating">'."Оценка:".$message["rating"].'</p>';
                        echo '<p class = "created-comment">'.$message["created"].'</p>';
                        echo '<hr>';
                    echo '</div>';
                }
                ?>
            </div>
    
        </div>
    </section>
<script src ="js/jquery-3.6.0.min.js"></script>
<script src="js/common.js"></script>
</body>
</html>

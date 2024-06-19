<?php
$error ="";

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['email']) || empty($_POST['login']) || empty($_POST['password']) || empty($_POST['month']) || empty($_POST['day']) || empty($_POST['year'])) {
        $error = "Wypełnij wszystkie pola";
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error = "Niepoprawny adres email.";
        } else {
            $year = $_POST['year'];
            $day = $_POST['day'];
            $month = $_POST['month'];
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            if ($day < 1 || $day > $days_in_month) {
                $error = "Niepoprawny dzień dla wybranego miesiąca.";

            } else {

                $current_year = date("Y");
                if ($year < 1900 || $year > $current_year) {
                    $error = "Niepoprawny rok.";

                } else {

                    $email = $_POST['email'];
                    $login = $_POST['login'];
                    $password = $_POST['password'];
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


                    try {
                        require_once 'db.inc.php';


                        $query = "INSERT INTO spotifydatabase (email,login,password,month,day,year) VALUES (:email,:login,:password,:month,:day,:year)";

                        $stmt = $pdo->prepare($query);

                        $stmt->bindParam(":email", $email);
                        $stmt->bindParam(":login", $login);
                        $stmt->bindParam(":password", $hashedPassword);
                        $stmt->bindParam(":month", $month);
                        $stmt->bindParam(":day", $day);
                        $stmt->bindParam(":year", $year);


                        $stmt->execute();

                        $pdo = null;
                        $stmt = null;


                        header("Location: zaloguj.php");
                        exit();

                    } catch (PDOException $e) {
                        die("Query failed: " . $e->getMessage());
                    }

                }
            }
        }
    }

}

?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/841f4f2efe.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="rejestracja1.css">
    <title>Rejestracja</title>
</head>
<body class="all">
<div class="container">
    <div class="mini-logo">
        <img src="mini.png" alt="logo">
    </div>
    <h1>Zarejestruj się, aby zacząć słuchać</h1>



    <form action="rejestracja.php" method="post">
        <p>Adres e-mail</p>
        <div class="formularz">
            <input type="text" name="email" placeholder="nazwa@domena.com" class="text">
            <p>Login</p>
            <input type="text" name="login" placeholder="Jak chcesz się nazywać?" class="text">
            <p>Hasło</p>
            <input type="password" name="password" placeholder="Hasło" class="text">
            <p>Miesiąc</p>
            <select id="month" name="month" class="text wiecej "  >
                <option value="">Wybierz miesiąc</option>
                <option value="01">Styczeń</option>
                <option value="02">Luty</option>
                <option value="03">Marzec</option>
                <option value="04">Kwiecień</option>
                <option value="05">Maj</option>
                <option value="06">Czerwiec</option>
                <option value="07">Lipiec</option>
                <option value="08">Sierpień</option>
                <option value="09">Wrzesień</option>
                <option value="10">Październik</option>
                <option value="11">Listopad</option>
                <option value="12">Grudzień</option>
            </select>

            <p>Dzień</p>
            <input type="text" class="text" name="day" placeholder="dd" >

            <p>Rok</p>
            <input type="text" class="text" name="year" placeholder="rrrr"  >

            <input type="submit" value="Zarejestruj" class="dalej">

            <?php if(!empty($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <a href="https://accounts.google.com/o/oauth2/v2/auth?scope=email%20profile&response_type=code&redirect_uri=http://localhost/Spotify-clone/&client_id=912308012371-a52rm5bdomoginnor0g8iea8e6m15h71.apps.googleusercontent.com&access_type=offline">
                <button type="button">
                    <i class="fa-brands fa-google"></i> Zarejestruj się przez Google
                </button>
            </a>




        </div>
    </form>



    <div class="end">
        <hr>
        <p>Masz już konto? <a href="zaloguj.php">Zaloguj się tutaj</a></p>
    </div>
</div>



<div class="dol">
    <p>This site is protected by reCAPTCHA and the Google  <br> <a href="https://policies.google.com/privacy">Privacy Policy</a> oraz <a href="https://policies.google.com/terms">  Terms of Service</a> apply.  </p>

</div>

</body>
</html>


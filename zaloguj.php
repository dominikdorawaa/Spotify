<?php
session_start();

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Wypełnij wszystkie pola";
    } else {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        try {
            require_once 'db.inc.php';
            $stmt = $pdo->prepare("SELECT id, password FROM spotifydatabase WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: zalogowanyindex.php");
                exit();
            } else {
                $error = "Nieprawidłowy adres e-mail lub hasło.";
            }
        } catch (PDOException $e) {
            $error = "Błąd połączenia z bazą danych: " . $e->getMessage();
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
    <link rel="stylesheet" href="styles-logowanie.css">
    <title>Logowanie</title>
</head>
<body class="all">

<div class="container">


    <div class="mini-logo">
        <img src="mini.png" alt="logo">
    </div>

    <h1>Zaloguj się w Spotify</h1>

    <form action="zaloguj.php" method="post">
        <button>  <a  href="https://accounts.google.com/o/oauth2/v2/auth?scope=email%20profile&response_type=code&redirect_uri=http://localhost/Spotify-clone/&client_id=912308012371-a52rm5bdomoginnor0g8iea8e6m15h71.apps.googleusercontent.com&access_type=offline"><i class="fa-brands fa-google"></i>Kontynuuj z Google</a></button>


        <hr>
        <div class="formularz">
            <label for="email">Adres e-mail lub nazwa użytkownika</label>
            <input type="text" name="email" placeholder="Adres e-mail lub nazwa użytkownika" class="text">
            <label for="haslo">Hasło</label>
            <input type="password" name="haslo" placeholder="Hasło"  class="text">

            <input type="checkbox" name="zapamietaj" class="check">
            <label for="checkbox" class="box"> Zapamiętaj mnie</label>

            <input type="submit" name="zaloguj" value="Zaloguj się" class="text zaloguj">

            <?php if(!empty($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <a href="#" >Nie pamiętasz hasła?</a>
        </div>

        <hr>

    </form>
    <div class="end">
        <p> Nie masz jeszcze konta? <a href="http://szuflandia.pjwstk.edu.pl/~s30574/Spotify-clone/rejestracja.php?forward_url=https%3A%2F%2Fszuflandia.pjwstk.edu.pl%2F%7Es30574%2FSpotify-clone%2F">Zarejestruj się w Spotify</a></p>
    </div>

</div>


<div class="dol">
    <p>Ta strona jest chroniona przez reCAPTCHA i mają do niej zastosowanie <a href="https://policies.google.com/privacy">Polityka prywatności</a> oraz <a href="https://policies.google.com/terms"> Warunki korzystania z usługi Google.</a>  </p>
</div>







</body>
</html>


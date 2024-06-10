<!DOCTYPE html>
<html lang="pl" xmlns="http://www.w3.org/1999/html">
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
        <button><i class="fa-brands fa-google"></i>Kontynuuj z Google</button>
        <button><i class="fa-brands fa-facebook"></i>Kontynuuj z Facebookiem</button>

        <hr>
        <div class="formularz">
            <label for="email">Adres e-mail lub nazwa użytkownika</label>
            <input type="text" name="email" placeholder="Adres e-mail lub nazwa użytkownika" value="$" class="text">
            <label for="haslo">Hasło</label>
            <input type="text" name="haslo" placeholder="Hasło" value="$" class="text">

            <input type="checkbox" name="zapamietaj" class="check">
            <label for="checkbox" class="box"> Zapamiętaj mnie</label>

            <input type="submit" name="zaloguj" value="Zaloguj się" class="text zaloguj">
            <a href="#" >Nie pamiętasz hasła?</a>
        </div>

        <hr>

    </form>
    <div class="end">
        <p> Nie masz jeszcze konta? <a href="#">Zarejestruj się w Spotify</a></p>
    </div>

</div>


<div class="dol">
    <p>Ta strona jest chroniona przez reCAPTCHA i mają do niej zastosowanie <a href="https://policies.google.com/privacy">Polityka prywatności</a> oraz <a href="https://policies.google.com/terms"> Warunki korzystania z usługi Google.</a>  </p>
</div>







</body>
</html>


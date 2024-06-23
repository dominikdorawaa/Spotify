<?php
session_start();
require_once 'db.inc.php';



if (isset($_SESSION['user_id'])) {

    header("Location: zalogowanyindex.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['akceptuj-ciasteczka'])) {
    setcookie('cookiesAccepted', 'true', time() + (86400 * 30), "/");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if (!isset($_COOKIE['cookiesAccepted']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['akceptuj-ciasteczka'])) {
    setcookie('cookiesAccepted', 'true', time() + (86400 * 30), "/");
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}


$stmt = $pdo->query("SELECT * FROM songs");
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/841f4f2efe.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles5.css">
    <title>Spotify_clone</title>
</head>
<body>


<div class="menu">
    <div class="gora-menu">
        <div class="logo">
            <a href="index.php" target="_blank">
                <img src="https://storage.googleapis.com/pr-newsroom-wp/1/2018/11/Spotify_Logo_CMYK_Green.png" alt="logo">
            </a>
        </div>
        <div class="nawigacja">
            <ul>
                <li>
                    <a href="index.php">
                        <span class="fa fa-home"></span>
                        <span class="ikony">Home</span>
                    </a>
                </li>
                <li>
                    <a href="zaloguj.php">
                        <span class="fa fa-search"></span>
                        <span class="ikony">Szukaj</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>


    <div class="dol-menu">
        <div class="nawigacja">
            <ul>
                <li>
                    <a href="#">
                        <span class="fa-solid fa-book"></span>
                        <span class="ikony">Biblioteka</span>
                    </a>
                    <a href="zaloguj.php">
                        <span class="fa-solid fa-plus"></span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="nawigacja">
            <div class="utworz_playliste">
                <p class="duzy_tekst">Utwórz swoją pierwszą playlistę</p>
                <p class="maly_tekst">To proste, pomożemy Ci</p>
                <ul>

                    <li>
                        <a href="zaloguj.php">
                            <button class="btn">Utwórz playlistę</button>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="regulaminy">
            <ul>
                <li>
                    <a href="https://www.spotify.com/pl/legal/end-user-agreement/">Kwestie prawne</a>
                </li>
                <li>
                    <a href="https://www.spotify.com/pl/safetyandprivacy/reporting-content">Centrum ochrony prywatności i bezpieczeństwa</a>
                </li>
                <li>
                    <a href="https://www.spotify.com/pl/legal/privacy-policy/">Polityka prywatności</a>
                </li>
                <li>
                    <a href="">Ustawienie plików cookie</a>
                </li>
                <li>
                    <a href="https://www.spotify.com/pl/legal/privacy-policy/#s3">O reklamach</a>
                </li>
                <li>
                    <a href="https://www.spotify.com/pl/accessibility">Dostępność</a>
                </li>
                <li>
                    <a href="https://www.spotify.com/pl/legal/cookies-policy/">Pliki cookies</a>
                </li>
            </ul>
        </div>

        <div class="jezyk">
            <button type="button"  class="jezyk_btn">
                <span class="fa-solid fa-globe"></span>
                Polski
            </button>
        </div>
    </div>

</div>

<div class="container">
    <div class="topbar">
        <div class="strzalki-btn">
            <button type="button" class="fa-solid fa-chevron-left" onclick="goBack()" ></button>
            <button type="button" class="fa-solid fa-chevron-right" onclick="goForward()"></button>
        </div>

        <script>
            function goBack() {
                window.history.back();
            }

            function goForward() {
                window.history.forward();
            }
        </script>

        <div class="navbar">
            <ul>
                <li>
                    <a href="rejestracja.php?forward_url=<?php echo urlencode("https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">Zarejestruj się</a>
                </li>
            </ul>
            <button type="button"><a href="zaloguj.php?forward_url=<?php echo urlencode("https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">Zaloguj się</a></button>
        </div>
    </div>





    <div class="content">
        <div class="playlisty">
            <h2>Popularni wykonawcy</h2>


            <div class="lista">
                <div class="itemy wykonawca">

                    <img src="images/chivas.jpg" alt="obrazek" onclick="location.href='zaloguj.php'">
                    <div class="play" onclick="location.href='zaloguj.php'">
                        <span class="fa-solid fa-play"></span>
                    </div>
                    <h4>Chivas</h4>
                    <p>Wykonawca</p>
                </div>





                <div class="itemy wykonawca">

                    <img src="images/David.jpg" alt="obrazek" onclick="location.href='zaloguj.php'">
                    <div class="play" onclick="location.href='zaloguj.php'">
                        <span class="fa-solid fa-play"></span>
                    </div>
                    <h4>David</h4>
                    <p>Wykonawca</p>
                </div>

                <div class="itemy wykonawca">

                    <img src="images/Blanka.jpg" alt="obrazek" onclick="location.href='zaloguj.php'">
                    <div class="play" onclick="location.href='zaloguj.php'">
                        <span class="fa-solid fa-play"></span>
                    </div>
                    <h4>Blanka</h4>
                    <p>Wykonawca</p>
                </div>

            </div>


            <div class="playlisty">
                <h2>Popularne utwory</h2>

                <div class="lista">
                    <?php $count = 0; ?>
                    <?php foreach ($songs as $song): ?>
                        <?php if ($count < 7): ?>
                            <div class="itemy">
                                <img src="<?php echo $song['image_path']; ?>" alt="obrazek"onclick="location.href='zaloguj.php'">
                                <div class="play" onclick="location.href='zaloguj.php'">
                                    <span class="fa-solid fa-play"></span>
                                </div>
                                <h4><?php echo $song['artist']; ?> - <?php echo $song['name']; ?></h4>
                                <p><?php echo $song['description']; ?></p>
                            </div>
                            <?php $count++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>




        </div>


        <div class="playlisty">
            <h2>Losowe Utwory</h2>

            <div class="lista">
                <?php
                $random_indexes = array_rand($songs, min(4, count($songs)));
                foreach ($random_indexes as $index):
                    $song = $songs[$index]; ?>
                    <div class="itemy">
                        <img src="<?php echo $song['image_path']; ?>" alt="obrazek" onclick="location.href='zaloguj.php'">
                        <div class="play" onclick="location.href='zaloguj.php'">
                            <span class="fa-solid fa-play"></span>
                        </div>
                        <h4><?php echo $song['artist']; ?> - <?php echo $song['name']; ?></h4>
                        <p><?php echo $song['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


        <div class="stopka">
            <div class="columna">
                <h4>Firma</h4>
                <ul>
                    <li>
                        <a href="https://www.spotify.com/pl/about-us/contact/">Informacje</a>
                    </li>
                    <li>
                        <a href="https://www.lifeatspotify.com/">Praca</a>
                    </li>
                    <li>
                        <a href="https://newsroom.spotify.com/">For the Record</a>
                    </li>
                </ul>
            </div>


            <div class="columna">
                <h4>Społeczności</h4>
                <ul>
                    <li>
                        <a href="https://artists.spotify.com/home">Dla artystów</a>
                    </li>
                    <li>
                        <a href="https://developer.spotify.com/">Deweloperzy</a>
                    </li>
                    <li>
                        <a href="https://ads.spotify.com/en-US/">Reklama</a>
                    </li>
                    <li>
                        <a href="https://investors.spotify.com/home/default.aspx">Inwestorzy</a>
                    </li>
                    <li>
                        <a href="https://spotifyforvendors.com/">Dostawcy</a>
                    </li>
                </ul>
            </div>

            <div class="columna">
                <h4>Przydatne linki</h4>
                <ul>
                    <li>
                        <a href="https://support.spotify.com/pl/">Pomoc</a>
                    </li>
                    <li>
                        <a href="https://www.spotify.com/pl/free/">Bezpłatna aplikacja moblina</a>
                    </li>
                </ul>
            </div>

            <div class="columna">
                <h4>Plany Spotify</h4>
                <ul>
                    <li>
                        <a href="https://www.spotify.com/pl/premium/?ref=spotifycom_footer_premium_individual">Premium Individual</a>
                    </li>
                    <li>
                        <a href="https://www.spotify.com/pl/duo/?ref=spotifycom_footer_premium_duo">Premium Duo</a>
                    </li>
                    <li>
                        <a href="https://www.spotify.com/pl/family/?ref=spotifycom_footer_premium_family">Premium Family</a>
                    </li>
                    <li>
                        <a href="https://www.spotify.com/pl/student/?ref=spotifycom_footer_premium_student">Premium Student</a>
                    </li>
                    <li>
                        <a href="https://www.spotify.com/pl/free/?ref=spotifycom_footer_free">Spotify Free</a>
                    </li>
                </ul>
            </div>

            <div class="columna">
                <ul>
                    <li>
                        <button class="sociale"><a href="https://www.instagram.com/spotify/"><i class="fa-brands fa-instagram"></a></i></button>
                        <button class="sociale"><a href="https://x.com/spotify"><i class="fa-brands fa-twitter"></a></i></button>
                        <button class="sociale"><a href="https://www.facebook.com/spotifypl/?brand_redir=6243987495#"><i class="fa-brands fa-facebook"></a></i></button>
                    </li>
                </ul>

            </div>


        </div>


    </div>
    <p class="prawa"> &reg; 2024 Dominik Music </p>

    <div class="podglad">
        <div class="text">
            <h5>Podgląd Spotify</h5>
            <p>Zarejestruj się, aby słuchać utworów i podcastów przetywanych sporadycznie reklamami. Nie wymagamy podania numeru karty kredytowej.</p>
        </div>
        <div class="button">
            <button type="button"><a href="rejestracja.php?forward_url=<?php echo urlencode("https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">Zarejestruj się za darmo</a></button>
        </div>
    </div>
</div>

<?php if (!isset($_COOKIE['cookiesAccepted'])): ?>
    <div class="ciasteczka-banner">
        <p>Nasza strona używa ciasteczek. Kontynuując przeglądanie strony, zgadzasz się na ich użycie.</p>
        <form method="POST" action="">
            <button type="submit" name="akceptuj-ciasteczka">Akceptuj</button>
        </form>
    </div>
<?php endif; ?>

</body>
</html>

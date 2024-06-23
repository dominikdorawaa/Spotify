<?php
//session_start();
require_once 'db.inc.php';

//
//if (!isset($_SESSION['user_id'])) {
//    header("Location: zaloguj.php");
//    exit();
//}
//
//$user_id = $_SESSION['user_id'];


if (isset($_GET['wyszukiwanie']) && !empty(trim($_GET['wyszukiwanie']))) {
    $wyszukiwanie = $_GET['wyszukiwanie'];


    $stmt = $pdo->prepare("SELECT * FROM songs WHERE name LIKE :wyszukiwanie OR artist LIKE :wyszukiwanie");
    $stmt->execute(['wyszukiwanie' => "%$wyszukiwanie%"]);
    $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {

    $songs = [];
}



$stmt = $pdo->prepare("SELECT id, name FROM playlists WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->execute(['user_id' => $user_id]);
$playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

$playlistExists = count($playlists) > 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['utworz_playliste'])) {
    $name = "Moja playlista";

    $stmt = $pdo->prepare("INSERT INTO playlists (name, user_id) VALUES (:name, :user_id)");
    $stmt->execute(['name' => $name, 'user_id' => $user_id]);


    header('Location: zalogowanyindex.php');
    exit();
}




?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/841f4f2efe.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="zalogowanystyles.css">
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
                    <a href="zalogowanyindex.php">
                        <span class="fa fa-home"></span>
                        <span class="ikony">Home</span>
                    </a>
                </li>
                <li>
                    <a href="search.php">
                        <span class="fa fa-search"></span>
                        <span  class="ikony">Szukaj</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>


    <div class="dol-menu">
        <div class="nawigacja">
            <ul>
                <li>
                    <span class="fa-solid fa-book"></span>
                    <span class="ikony">Biblioteka</span>

                    <form action="zalogowanyindex.php" method="post">
                        <input type="hidden" name="utworz_playliste" value="1">
                        <button class="btn-plus" type="submit" ><span class="fa-solid fa-plus"></span></button>
                    </form>
                </li>
            </ul>
        </div>
        <?php if (!$playlistExists): ?>
            <div class="nawigacja">
                <div class="utworz_playliste">
                    <p class="duzy_tekst">Utwórz swoją pierwszą playlistę</p>
                    <p class="maly_tekst">To proste, pomożemy Ci</p>
                    <form action="zalogowanyindex.php" method="post">
                        <input type="hidden" name="utworz_playliste" value="1">
                        <ul>
                            <li>
                                <button type="submit" class="btn">Utwórz playlistę</button>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        <?php endif; ?>



        <div class="nowa-playlista">
            <?php
            foreach ($playlists as $playlist) {
                echo '<a href="nowa-playlista.php?id=' . urlencode($playlist['id']) . '">';
                echo '<div class="playlist-item">';
                echo '<div class="obrazek-playlisty"><i class="fa-solid fa-music"></i></div>';
                echo '<p>' . htmlspecialchars($playlist['name']) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>



<div class="container">
    <div class="topbar">
        <div class="strzalki-btn">

            <button type="button" class="fa-solid fa-chevron-left" onclick="goBack()">  </button>
            <button type="button" class="fa-solid fa-chevron-right" onclick="goForward()"> </button>

        </div>

        <form action="search.php" method="GET">
            <input type="text" class="wyszukaj" name="wyszukiwanie" placeholder="Szukaj piosenek po nazwie lub artyście">
        </form>

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
                    <button class="odkryj-premium"> <a href="https://open.spotify.com/download">Odkryj Premium</a></button>
                </li>

            </ul>

            <button class="account"><i class="fa-regular fa-bell"></i></button>

            <div class="dropdown">
                <label class="account-label" for="dropdown-toggle">
                    <i class="fa-solid fa-user"></i>
                </label>
                <input type="checkbox" id="dropdown-toggle">
                <div class="dropdown-content">
                    <a href="#konto">Moje Konto</a>
                    <a href="wyloguj.php">Wyloguj się</a>
                </div>
            </div>

        </div>
    </div>






    <div class="content">




        <div class="song-list">
            <div class="playlisty">
                <div class="lista">
                    <?php foreach ($songs as $song): ?>
                        <div class="itemy">
                            <img src="<?php echo $song['image_path']; ?>" alt="obrazek" onclick="location.href='playlist.php?song_id=<?php echo $song['id']; ?>'">
                            <div class="play" onclick="playSong('<?php echo $song['path']; ?>')">
                                <span class="fa-solid fa-play"></span>
                            </div>
                            <h4><?php echo htmlspecialchars($song['name']); ?></h4>
                            <p><?php echo htmlspecialchars($song['artist']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if (empty($songs) && isset($_GET['wyszukiwanie'])): ?>
            <?php endif; ?>
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


        <hr>



        <div class="regulaminy">
            <ul>
                <li>
                    <a href="https://www.spotify.com/pl/legal/end-user-agreement/">Kwestie prawne</a>
                </li>
                <li>
                    <a href="https://www.spotify.com/pl/privacy-policy/">Prywatność</a>
                </li>
                <li>
                    <a href="https://www.spotify.com/pl/legal/privacy-policy/#s3">Polityka plików cookies</a>
                </li>
                <li>
                    <a href="https://www.spotify.com/pl/legal/privacy-policy/#s3">Informacje o reklamach</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="odtwarzanie">
        <!--                    <div class="current-song">-->
        <!--                        <img src="" alt="obrazek" id="currentImage">-->
        <!--                        -->
        <!--                        <h4 id="currentTitle"></h4>-->
        <!--                    </div>-->


        <audio id="song">
            <source src="music/music1.mp3" >
        </audio>

        <div class="ikony">
            <div> <i class="fa-solid fa-backward-step"></i></div>
            <div onclick="playPause()">  <i class="fa-solid fa-play" id="ctrlIcon"></i></div>
            <div>  <i class="fa-solid fa-forward-step"></i></div>
        </div>

        <input type="range" id="progress" min="0" value="0" max="100">


        <div class="volume-ikony">
            <i class="fa-solid fa-volume-down"></i>
            <input type="range" class="dolny-zasieg" min="0" value="50" max="1000" onchange="changeVolume(this.value)">
        </div>

    </div>


    <script>
        let progress = document.getElementById("progress");
        let song = document.getElementById("song");
        let ctrlIcon = document.getElementById("ctrlIcon");
        let volumeRange = document.getElementById("volumeRange");





        function changeVolume(value) {
            song.volume = value / 1000;
            localStorage.setItem("volume", value);
        }


        function loadSavedVolume() {
            let savedVolume = localStorage.getItem("volume");
            if (savedVolume !== null) {
                volumeRange.value = savedVolume;
                song.volume = savedVolume / 1000;
            }
        }

        window.onload = function () {
            loadSavedVolume();
        };

        song.onloadedmetadata = function () {
            progress.max = song.duration;
            progress.value = song.currentTime;
        }




        function playPause() {
            if (song.paused) {
                song.play();
                ctrlIcon.classList.remove("fa-play");
                ctrlIcon.classList.add("fa-circle-pause");
            } else {
                song.pause();
                ctrlIcon.classList.remove("fa-circle-pause");
                ctrlIcon.classList.add("fa-play");
            }
        }

        setInterval(function () {
            progress.value = song.currentTime;
        }, 500);

        progress.onchange = function () {
            song.currentTime = progress.value;
        }




        function playSong(path) {
            song.src = path;
            song.play();
            ctrlIcon.classList.remove("fa-play");
            ctrlIcon.classList.add("fa-circle-pause");

        }





    </script>
</body>
</html

<?php

require_once 'db.inc.php';

if (isset($_GET['artist'])) {
    $artist = $_GET['artist'];


    $stmt = $pdo->prepare("SELECT * FROM songs WHERE artist = :artist");
    $stmt->execute(['artist' => $artist]);
    $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {

    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/841f4f2efe.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="playliststyles.css">
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
                    <a href="search.php?query">
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
                    <a href="#">
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
                        <button class="btn">Utwórz playlistę</button>
                    </li>
                </ul>
            </div>
        </div>



    </div>

</div>

<div class="container">
    <div class="topbar">
        <div class="strzalki-btn">
            <button type="button" class="fa-solid fa-chevron-left" onclick="goBack()" </button>
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
                    <button class="odkryj-premium"> <a href="https://open.spotify.com/download">Odkryj Premium</a></button>
                </li>

            </ul>

            <button class="account"><i class="fa-regular fa-bell"></i></button>
            <button type="button" class="account"></button>


        </div>
    </div>


    <div class="content">

        <div class="profil">
            <img src="images/chivas-duzy.jpg">
            <p>Nazwa Artysty</p>

        </div>

        <table class="song-table">


            <tr>
                <th></th>
                <th>#</th>
                <th>Tytuł</th>
                <th>Album</th>
            </tr>
            <?php foreach ($songs as $index => $song): ?>
                <tr>
                    <td><button class="play" onclick="playSong('<?php echo $song['path']; ?>')"><span class="fa-solid fa-play"></span></button></td>
                    <td><?php echo $index + 1; ?></td>
                    <td>
                        <img src="<?php echo $song['image_path']; ?>" alt="Okładka albumu">
                        <?php echo $song['name']; ?>
                    </td>
                    <td><?php echo $song['name']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>




        <hr>

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



</div>


<div class="odtwarzanie">



    <audio id="song">
        <source src="music/music1.mp3" >
    </audio>

    <div class="lool">

    </div>

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

    function changeVolume(value) {
        song.volume = value / 1000;
        localStorage.setItem("volume", value);
    }

    window.onload = function () {
        let savedVolume = localStorage.getItem("volume");
        if (savedVolume !== null) {
            volumeRange.value = savedVolume;
            changeVolume(savedVolume);
        }
    }

    function playSong(path) {
        song.src = path;
        song.play();
    }
</script>
</body>
</html>

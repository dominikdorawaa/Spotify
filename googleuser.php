<?php
session_start();



require_once 'vendor/autoload.php';


$client = new Google_Client();
$client->setClientId('912308012371-a52rm5bdomoginnor0g8iea8e6m15h71.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://szuflandia.pjwstk.edu.pl/~s30574/Spotify-clone/zalogowanyindex.php');
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    try {
        $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        $_SESSION['access_token'] = $accessToken;

        $db_host = 'localhost';
        $db_name = 's30574';
        $db_user = 's30574';
        $db_pass = 'Dom.Dora';
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



        $service = new Google_Service_People($client);
        $me = $service->people->get('people/me', array('personFields' => 'names,emailAddresses'));
        $login = $me->getNames()[0]->getDisplayName();
        $email = $me->getEmailAddresses()[0]->getValue();

        $query = "INSERT INTO spotifydatabase (login, email) VALUES (:login, :email)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        echo "Użytkownik dodany do bazy danych.";

    } catch (Exception $e) {
        die('Błąd autoryzacji lub zapisu do bazy danych: ' . $e->getMessage());
    }
} else {

    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit;
}
?>
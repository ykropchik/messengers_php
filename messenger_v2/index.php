<?php
    require_once __DIR__.'/vendor/autoload.php';
    require_once __DIR__.'/mysql-config.php';
    
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
    $twig = new \Twig\Environment($loader);
    $template = $twig->load('index.html');

    try {
        $db = new PDO("mysql:host=localhost;dbname={$dbName}", $dbUser, $dbUserPassword);        
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage();
        die();
    }

    $login = $_GET['login'];
    $password = $_GET['password'];
    $text = $_GET['text'];

    $isLogin = false;
    $loginError = false;

    if (isset($login) && isset($password)) {
        $sqlReq = $db->prepare("SELECT * FROM users WHERE `login` = ?");
        $sqlReq->execute([$login]);
        $rows = $sqlReq->fetchAll();
        if (count($rows) != 0) {
            $sqlReq = $db->prepare("SELECT * FROM users WHERE `login` = :login and `password` = :password");
            $sqlReq->execute(["login" => $login, "password" => $password]);
            $rows = $sqlReq->fetchAll();
            if (count($rows) != 0) {
                $isLogin = true;
            } else {
                $loginError = true;
            }
        } else {
            $loginError = true;
        }
    }

    if ($isLogin && isset($text)) {
        $sqlReq = $db->prepare("INSERT INTO `messages` (`create_time`, `author`, `message`) VALUES (:time, :author, :message)");
        $sqlReq->execute(["time" => date("y.m.d H:i"), "author" => $login, "message" => $text]);
    }


    echo $template->render(['messages' => getMessages($db), 'login' => $isLogin, 'loginError' => $loginError]);

    function getMessages($db) {
        $sqlReq = $db->prepare("SELECT * FROM messages");
        $sqlReq->execute();
        $rows = $sqlReq->fetchAll();
        return($rows);
    }
?>


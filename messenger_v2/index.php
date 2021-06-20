<?php
    require_once __DIR__.'/vendor/autoload.php';
    require_once __DIR__.'/mysql-config.php';
    require_once __DIR__.'/user.php';
    require_once __DIR__.'/message.php';
    
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
    $twig = new \Twig\Environment($loader);
    $template = $twig->load('index.html');

    try {
        $db = new PDO("mysql:host=localhost;dbname={$dbName}", $dbUser, $dbUserPassword);      
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage();
        die();
    }

    $mapper = new MessageMapper($db);

    $login = $_GET['login'];
    $password = $_GET['password'];
    $text = $_GET['text'];

    $isLogin = false;
    $loginError = false;

    if (isset($login) && isset($password)) {
        $user = new User(NULL, NULL);
        $foundedUser = $user->getByLogin($login, $db);

        if ($foundedUser->getLogin() === $login && $foundedUser->getPassword() === $password) {
            $isLogin = true;
        } else {
            $loginError = true;
        }
    }

    if ($isLogin && isset($text)) {
        $newMessage = new Message($login, date("y.m.d H:i"), $text);
        $mapper->saveMessage($newMessage);
    }

    function getMessages($db) {
        $sqlReq = $db->prepare("SELECT * FROM messages");
        $sqlReq->execute();
        $rows = $sqlReq->fetchAll();
        return($rows);
    }

    echo $template->render(['messages' => $mapper->getAllMessages(), 'login' => $isLogin, 'loginError' => $loginError]);
?>


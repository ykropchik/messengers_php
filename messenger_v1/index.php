<?php
    $users = [
        'user_1' => '12345',
        'user_2' => 'password',
        'user_3' => 'dromReluz',
        'user_4' => 'hateAntonova',
        'roman' => 'iworkinDROM'
    ];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="messenger_v1/style.css">
    <title>Мессенджер v1</title>
</head>
<body>
    <?php
        $login = $_GET['login'];
        $password = $_GET['password'];
        $text = $_GET['text'];
        if (isset($login) && isset($password) && isset($text)) {
            if (isset($users[$login])) {
                if($users[$login] == $password) {
                    $messages = file_get_contents(__DIR__."/messages.json");
                    $parsed_messages = json_decode($messages, true);

                    $date = getdate();
                    //$stringDate = $date["mday"].".".$date["mon"].".".$date["year"]." ".$date["hours"].":".$date["minutes"];
                    $stringDate = date("d.m.y H:i");
                    $newMessage = [
                        "author" => $login,
                        "date" => $stringDate,
                        "text" => $text
                    ];

                    array_push($parsed_messages, $newMessage);
                    //fwrite($file, json_encode($parsed_messages));
                    //fclose($file);
                    // var_dump(json_encode($parsed_messages));
                    file_put_contents(__DIR__."/messages.json", json_encode($parsed_messages, JSON_UNESCAPED_UNICODE));
                }
            }
        }
    ?>
    <div id="messages-box">  
        <?php
            $messages = file_get_contents("messages.json");
            $parsed_messages = json_decode($messages, true);
            for ($i = 0; $i < count($parsed_messages); $i++) {
                echo    '<div class="message">
                            <span class="author">'.$parsed_messages[$i]['author'].'</span>
                            <span class="date">'.$parsed_messages[$i]['date'].'</span>
                            <div class="text">'.$parsed_messages[$i]['text'].'</div>
                        </div>';
            }
        ?>
    </div>

    <div id="message-create">
        <?php
            $login = $_GET['login'];
            $password = $_GET['password'];
            if (isset($login) && isset($password)) {
                if (isset($users[$login])) {
                    if($users[$login] == $password) {
                        echo    '<div id="new-message">
                                    <textarea type="text" id="newText"></textarea>
                                    <input type="button" value="Отправить" onclick="sendMessage()">
                                </div>';
                    }
                } else {
                    echo    '<div id="auth">
                            <label for="login">Логин:</label>
                            <input type="text" id="login">
                            <label for="password">Пароль: </label>
                            <input type="password" id="password">
                            <input type="button" value="Войти" onclick="authorize()">
                            <span id="error">Неверный логин или пароль</span>
                        </div>';
                }
            } else {
                echo    '<div id="auth">
                            <label for="login">Логин:</label>
                            <input type="text" id="login">
                            <label for="password">Пароль: </label>
                            <input type="password" id="password">
                            <input type="button" value="Войти" onclick="authorize()">
                        </div>';
            }
        ?>
        
    </div>
    <script src="messenger_v1/script.js"></script>
</body>
</html>
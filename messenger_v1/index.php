<?php
    $users = [
        'user_1' => '12345',
        'user_2' => 'password',
        'user_3' => 'dromReluz',
        'user_4' => 'hateAntonova',
        'roman' => 'iworkinDROM'
    ];

    
    echo($_SERVER['REQUEST_URI']);
    echo('<br>');
    $login = $_GET['login'];
    echo(htmlspecialchars($login));
?>
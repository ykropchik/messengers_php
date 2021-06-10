<?php
    $names = [
        "0" => "James",
        "1" => "Lando",
        "2" => "Piter",
        "3" => "Robert",
        "4" => "Alfred",
        "5" => "Mick"
    ];

    require_once __DIR__.'/vendor/autoload.php';
    
    $loader = new \Twig\Loader\ArrayLoader([
        'index' => 'Hello! My name is {{ name }}!',
    ]);
    
    $twig = new \Twig\Environment($loader);
    
    echo $twig->render('index', ['name' => $names[(string)rand(0, 5)]]);
?>
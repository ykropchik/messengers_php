<?php
    if(strtok($_SERVER['REQUEST_URI'], '?') == '/messenger') { 
        readfile('messenger_v1/index.html');
    }
    
    if(strtok($_SERVER['REQUEST_URI'], '?') == '/messengerV2') {
        readfile('messenger_v2/index.html');
    }

    if(strtok($_SERVER['REQUEST_URI'], '?') == '/') {
        readfile('index.html');
    }
?>
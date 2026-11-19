<?php

dd($_SESSION['user']);

view("index.view.php", [
    'heading' => 'Home',
]);
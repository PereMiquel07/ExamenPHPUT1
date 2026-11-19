<?php


use notes\NotesController;

$controller = new NotesController();

$controller->getNotes($_SESSION['user']['id']);
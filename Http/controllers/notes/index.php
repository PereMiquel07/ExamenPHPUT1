<?php


use notes\NotesController;

$controller = new NotesController();

$notes = $controller->getNotes();

view("notes/index.view.php", [
    'heading' => 'My Notes',
    'notes' => $notes
]);
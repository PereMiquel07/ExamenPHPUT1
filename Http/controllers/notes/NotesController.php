<?php

use \Core\App;
use Core\Database;

class NotesController
{

    private $db;

    public function __construct() {
        $this->db = App::resolve(Database::class);
    }

    //TODO:Mirar com passar o dur tema de s'user_id
    public function getNotes($userId, $default = null) {

        $notes = $this->db->query("SELECT * FROM notes WHERE user_id = :user_id", [
            'user_id' => $userId,
        ])->find();

        return $notes ?? $default;
    }

    public function getNota($id, $default = null) {

        $nota = $this->db->query("SELECT * FROM notes WHERE id = :id", [
            'id' => $id,
        ])->find();

        return $nota ?? $default;
    }



}
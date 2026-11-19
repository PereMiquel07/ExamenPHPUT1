<?php

use Core\App;
use Core\Database;

class NotesDaoImpl implements NotaDAO
{

    private $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function getNota($id) {
        $nota = $this->db->query("SELECT * FROM notes WHERE id = :id", [
            'id' => $id,
        ])->find();

        return $nota ?? null;
    }

    public function getNotes()
    {
        $notes = $this->db->query("SELECT * FROM notes WHERE user_id = :user_id", [
            'user_id' => getIdUsuari(),
        ])->find();

        return $notes ?? null;
    }
}
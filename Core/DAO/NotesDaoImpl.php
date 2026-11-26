<?php

namespace Core\DAO;

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
        ])->get();

        return $notes ?? null;
    }

    public function inserirNota($nota)
    {
        $this->db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
            'body' => $nota['body'],
            'user_id' => getIdUsuari()
        ]);
    }

    public function eliminarNota($id)
    {
        $this->db->query('DELETE FROM notes WHERE id = :id', [
            'id' => $id,
        ]);
    }

    public function actualitzarNota($nota, $id)
    {
        $this->db->query('UPDATE notes SET body = :body WHERE id = :id', [
            'body' => $nota['body'],
            'id' => $id,
        ]);
    }
}
<?php

use \Core\App;
use Core\Database;
use Core\Validator;

class NotesController
{

    private $db;
    private $errors = [];

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

    public function errors() {
        return $this->errors;
    }

    public function addNota($nota, $userId) {

        //Verificar si hi ha una nota realment?

        if (! Validator::string($nota['body'], 1, 1000)) {
            $this->errors['body'] = 'A body of no more than 1,000 characters is required.';
        }
        //Verificar i guardar dins sa mateixa funció?
        else {
            $this->db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
                'body' => $nota['body'],
                'user_id' => $userId
            ]);
        }

        return $this->errors();
    }



}
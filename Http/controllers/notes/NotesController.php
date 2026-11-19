<?php

namespace notes;

use Core\DAO\NotaDAO;
use Core\DAO\NotaDaoFactory;
use Core\Validator;

class NotesController
{

    private $errors = [];

    private NotaDAO $accesNotes;

    public function __construct()
    {
        $this->accesNotes = NotaDaoFactory::getInstancia()->getNotaDAOImpl();
    }
    public function index($default = [])
    {
        $notes = $this->accesNotes->getNotes();

        view("notes/index.view.php", [
            'heading' => 'My Notes',
            'notes' => $notes
        ]);
    }

    public function show($id, $default = null)
    {
        $nota = $this->accesNotes->getNota($id);

        authorize($nota['user_id'] === getIdUsuari());

        view("notes/show.view.php", [
            'heading' => 'Note',
            'note' => $nota
        ]);
    }

    public function errors()
    {
        return $this->errors;
    }

    private function validarBodyNota($body)
    {
        if (!Validator::string($body, 1, 1000)) {
            $this->errors['body'] = 'A body of no more than 1,000 characters is required.';
        }
    }

    private function hiHaErrors () {
        return count($this->errors);
    }

    public function store($nota)
    {
        $this->validarBodyNota($nota['body']);
        if (! $this->hiHaErrors()) {
            $this->accesNotes->inserirNota($nota);
            redirect('/notes');
        }
        return view("notes/create.view.php", [
            'heading' => 'Create Note',
            'errors' => $this->errors
        ]);
    }

    public function destroy($id)
    {
        $nota = $this->getNota($id);
        if ($nota !== null) {
            authorize($nota['user_id'] === getIdUsuari());
            $this->accesNotes->eliminarNota($id);
            header('location: /notes');
            exit();
        }
    }

    public function edit($nota, $id)
    {
        authorize($nota['user_id'] === getIdUsuari());
        $this->validarBodyNota($nota['body']);


        if (! $this->hiHaErrors()) {
            if ($this->getNota($id)) {
                $this->accesNotes->actualitzarNota($nota, $id);
                redirect('/notes');
            }
        }
        return view('notes/edit.view.php', [
            'heading' => 'Edit Note',
            'errors' => $this->errors,
            'note' => $nota
        ]);
    }
}
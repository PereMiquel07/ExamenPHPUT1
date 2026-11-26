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

    public function index()
    {
        $notes = $this->accesNotes->getNotes();



        return view("notes/index.view.php", [
            'heading' => 'My Notes',
            'notes' => $notes
        ]);
    }

    public function show()
    {
        $id = $_GET['id'];
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

    private function hiHaErrors()
    {
        return count($this->errors);
    }

    public function store($nota)
    {
        $this->validarBodyNota($nota['body']);
        if (!$this->hiHaErrors()) {
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
        $nota = $this->accesNotes->getNota($id);
        if ($nota !== null) {
            authorize($nota['user_id'] === getIdUsuari());
            $this->accesNotes->eliminarNota($id);
            header('location: /notes');
            exit();
        }
    }

    public function edit()
    {
        $note = $this->accesNotes->getNota($_GET['id']);

        authorize($note['user_id'] === getIdUsuari());

        view("notes/edit.view.php", [
            'heading' => 'Edit Note',
            'errors' => [],
            'note' => $note
        ]);
    }

    public function update()
    {
        $nota = $this->accesNotes->getNota($_POST['id']);

        authorize($nota['user_id'] === getIdUsuari());
        $this->validarBodyNota($nota['body']);

        if (!$this->hiHaErrors()) {
            $this->accesNotes->actualitzarNota($nota, $_POST['id']);
            redirect('/notes');
        }
        return view('notes/edit.view.php', [
            'heading' => 'Edit Note',
            'errors' => $this->errors,
            'note' => $nota
        ]);
    }

    public function create()
    {
        view("notes/create.view.php", [
            'heading' => 'Create Note',
            'errors' => []
        ]);
    }
}
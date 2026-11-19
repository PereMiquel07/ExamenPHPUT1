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
    public function getNotes($default = [])
    {
        $notes = $this->accesNotes->getNotes();

        return $notes ?? $default;
    }

    public function getNota($id, $default = null)
    {

        $nota = $this->accesNotes->getNota($id);

        return $nota ?? $default;
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

    public function afegirNota($nota)
    {
        $this->validarBodyNota($nota['body']);
        if (! $this->hiHaErrors()) {
            $this->accesNotes->inserirNota($nota);
            redirect('/notes');
        }
    }

    public function borrarNota($id)
    {
        //Llençar excepcio en cas de no trobar?
        if ($this->getNota($id)) {
            $this->accesNotes->eliminarNota($id);
            return true;
        }
        return false;
    }

    public function editarNota($nota, $id)
    {
        $this->validarBodyNota($nota['body']);

        if (! $this->hiHaErrors()) {
            if ($this->getNota($id)) {
                $this->accesNotes->actualitzarNota($nota, $id);
            }
        }
        return $this->errors();
    }


}
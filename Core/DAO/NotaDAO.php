<?php

namespace Core\DAO;

interface NotaDAO
{
    public function getNota($id);
    public function getNotes();

    public function inserirNota($nota);
    public function eliminarNota($id);
    public function actualitzarNota($nota);
}
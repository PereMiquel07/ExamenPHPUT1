<?php

namespace Core\DAO;
class NotaDaoFactory
{

    private static $instancia;

    public function __construct()
    {

    }

    public static function setFactory (NotaDAO $class) {
        self::$instancia = $class;
    }

    public static function getInstancia() {
        if(!self::$instancia) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    public function getNotaDAOImpl ()
    {
        return new NotesDaoImpl();
    }

}
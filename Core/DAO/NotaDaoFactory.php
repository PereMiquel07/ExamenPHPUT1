<?php

namespace Core\DAO;
class NotaDaoFactory
{

    private static $instancia;

    public static function setFactory (NotaDAO $class) {
        self::$instancia = $class;
    }

    public static function getInstancia() {
        if(!isset(self::$instancia)) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

}
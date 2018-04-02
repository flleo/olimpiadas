<?php

class Deportista{
    private $_codDeportista, $_nombreDeportista, $_dniDeportista, $_paisDeportista;
    
    
    public function __construct($codDeportista, $nombreDeportista, $dniDeportista, $paisDeportista) {
        $this->_codDeportista = $codDeportista;
        $this->_nombreDeportista = $nombreDeportista;
        $this->_dniDeportista = $dniDeportista;
        $this->_paisDeportista = $paisDeportista;
    }
    
    function get_codDeportista() {
        return $this->_codDeportista;
    }

    function get_nombreDeportista() {
        return $this->_nombreDeportista;
    }

    function get_dniDeportista() {
        return $this->_dniDeportista;
    }

    function get_paisDeportista() {
        return $this->_paisDeportista;
    }

    function set_codDeportista($_codDeportista) {
        $this->_codDeportista = $_codDeportista;
    }

    function set_nombreDeportista($_nombreDeportista) {
        $this->_nombreDeportista = $_nombreDeportista;
    }

    function set_dniDeportista($_dniDeportista) {
        $this->_dniDeportista = $_dniDeportista;
    }

    function set_paisDeportista($_paisDeportista) {
        $this->_paisDeportista = $_paisDeportista;
    }

  
}


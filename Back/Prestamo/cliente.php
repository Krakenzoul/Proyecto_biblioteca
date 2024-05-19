<?php
    
    class Cliente {

        private $cedula;
        private $primer_nombre;
        private $segundo_nombre;
        private $primer_apellido;
        private $segundo_apellido;
        private $telefono;
        public function setPrimer_nombre($primer_nombre){
            $this->primer_nombre=$primer_nombre;
        }
        public function getPrimer_nombre(){
            return $this->primer_nombre;
        }

        public function setSegundo_nombre($segundo_nombre){
            $this->segundo_nombre=$segundo_nombre;
        }
        public function getSegundo_nombre(){
            return $this->segundo_nombre;
        }

        public function setPrimer_apellido($primer_apellido){
            $this->primer_apellido=$primer_apellido;
        }
        public function getPrimer_apellido(){
            return $this->primer_apellido;
        }
        public function setSegundo_apellido($segundo_apellido){
            $this->segundo_apellido=$segundo_apellido;
        }
        public function getSegundo_apellido(){
            return $this->segundo_apellido;
        }

        public function setTelefono($telefono){
            $this->telefono=$telefono;
        }
        public function getTelefono(){
            return $this->telefono;
        }
        public function setCedula($cedula){
            $this->cedula=$cedula;
        }
        public function getCedula(){
            return $this->cedula;
        }

       
    }
    
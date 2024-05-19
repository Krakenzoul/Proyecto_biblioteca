<?php
include("cliente.php");
class Prestamo extends Cliente
{
    private $id_libro;
    private $fecha;
    private $fecha_devolucion;
    public function setId_libro($id_libro)
    {
        $this->id_libro = $id_libro;
    }
    public function getId_libro()
    {
        return $this->id_libro;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function setFecha_devolucion($fecha_devolucion)
    {
        $this->fecha_devolucion= $fecha_devolucion;
    }
    public function getFecha_devolucion()
    {
        return $this->fecha_devolucion;
    }
   
}


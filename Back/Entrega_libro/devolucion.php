<?php
include ("../Prestamo/prestamo.php");
class Devolucion extends Prestamo{
    private $fecha_devolucion_real;
    public function setFecha_devolucion_real($fecha_devolucion_real)
    {
        $this->fecha_devolucion_real= $fecha_devolucion_real;
    }
    public function getFecha_devolucion_real()
    {
        return $this->fecha_devolucion_real;
    }
   
}
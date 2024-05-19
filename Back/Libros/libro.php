<?php
class Libro {
    private $nombre_titulo;
    private $no_estanteria;
    private $categoria;
    private $nombre_autor;

    public function getnombre_Titulo() {
        return $this->nombre_titulo;
    }

    public function setnombre_Titulo($nombre_titulo) {
        $this->nombre_titulo = $nombre_titulo;
    }

    public function setnombre_Autor($nombre_autor) {
        $this->nombre_autor = $nombre_autor;
    }
    public function getnombre_Autor() {
        return $this->nombre_autor;
    }

    public function setCategoria($categoria){
        $this->categoria=$categoria;
    }
    public function getCategoria(){
        return $this->categoria;
    }
    public function setNo_estanteria($no_estanteria){
        $this->no_estanteria=$no_estanteria;
    }
    public function getNo_estanteria(){
        return $this->no_estanteria;
    }

}
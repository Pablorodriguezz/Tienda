<?php
    class Producto {
        
        private $nombreProducto;
        private $precio;
        private $descripcion;
        private $cantidad;
    
        public function __construct($id, $nombreProducto, $precio, $descripcion, $cantidad) {
            $this->id = $id;
            $this->nombreProducto = $nombreProducto;
            $this->precio = $precio;
            $this->descripcion = $descripcion;
            $this->cantidad = $cantidad;
        }
    }
?>
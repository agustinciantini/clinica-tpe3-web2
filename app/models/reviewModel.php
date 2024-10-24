<?php

class ReviewModel {
    private $db;

    public function __construct() {
       // Conexión a la base de datos
       $this->db = new PDO('mysql:host=localhost;dbname=clinica;charset=utf8', 'root', '');
    }
 
    // Obtener todas las reseñas, con opción de ordenar.
    public function getReviews($orderBy = null , $ordenDirection = ' ASC') {
        $sql = 'SELECT * FROM reseñas';

        if ($orderBy) {
            $sql .= ' ORDER BY ';
            switch($orderBy) {
                case 'id':
                    $sql .= ' id';
                    break;
                case 'usuario':
                     $sql .= ' usuario';
                    break;
                case 'medico':
                     $sql .= ' medico';
                    break;
                case 'comentario':
                     $sql .= ' comentario';
                    break;
            }

            if($ordenDirection === 'DESC'){
                $sql .= ' DESC';
            }else{
                $sql .= ' ASC';
            }
        }
        $query = $this->db->prepare($sql);
        $query->execute();
    
        // Obtener los datos en un arreglo de objetos.
        $reviews = $query->fetchAll(PDO::FETCH_OBJ);
    
        return $reviews;
    }

    // Obtener una reseña específica por su ID.
    public function getReview($id) {
        $query = $this->db->prepare('SELECT * FROM reseñas WHERE id = ?');
        $query->execute([$id]);
    
        $review = $query->fetch(PDO::FETCH_OBJ);
    
        return $review;
    }

    // Insertar una nueva reseña.
    public function createReview($usuario, $medico, $comentario) {
        $query = $this->db->prepare('INSERT INTO reseñas(usuario, medico, comentario) VALUES (?, ?, ?)');
        $query->execute([$usuario, $medico, $comentario]);
    
        // Retornar el ID de la última reseña insertada.
        $id = $this->db->lastInsertId();
    
        return $id;
    }

    // Eliminar una reseña.
    public function deleteReview($id) {
        $query = $this->db->prepare('DELETE FROM reseñas WHERE id = ?');
        $query->execute([$id]);
    }

    // Actualizar una reseña.
    public function updateReview($id, $usuario, $medico, $comentario) {
        $query = $this->db->prepare('UPDATE reseñas SET usuario = ?, medico = ?, comentario = ? WHERE id = ?');
        $query->execute([$usuario, $medico, $comentario, $id]);
    }
}
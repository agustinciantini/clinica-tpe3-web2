<?php

class ReviewModel {
    private $db;

    public function __construct() {
       // Conexión a la base de datos
       $this->db = new PDO('mysql:host=localhost;dbname=clinica;charset=utf8', 'root', '');
    }
 
    // Obtener todas las reseñas, con opción de ordenar
    public function getReviews($orderBy = false) {
        $sql = 'SELECT * FROM reseñas';

        if ($orderBy) {
            switch($orderBy) {
                case 'id_paciente':
                    $sql .= ' ORDER BY id_paciente';
                    break;
                case 'id_doctor':
                    $sql .= ' ORDER BY id_doctor';
                    break;
            }
        }

        // Ejecutar la consulta
        $query = $this->db->prepare($sql);
        $query->execute();
    
        // Obtener los datos en un arreglo de objetos
        $reviews = $query->fetchAll(PDO::FETCH_OBJ);
    
        return $reviews;
    }

    // Obtener una reseña específica por su ID
    public function getReview($id) {
        $query = $this->db->prepare('SELECT * FROM reseñas WHERE id = ?');
        $query->execute([$id]);
    
        $review = $query->fetch(PDO::FETCH_OBJ);
    
        return $review;
    }

    // Insertar una nueva reseña
    public function insertReview($id_paciente, $id_doctor, $comentario) {
        $query = $this->db->prepare('INSERT INTO reseñas(id_paciente, id_doctor, comentario) VALUES (?, ?, ?)');
        $query->execute([$id_paciente, $id_doctor, $comentario]);
    
        // Retornar el ID de la última reseña insertada
        $id = $this->db->lastInsertId();
    
        return $id;
    }

    // Eliminar una reseña
    public function eraseReview($id) {
        $query = $this->db->prepare('DELETE FROM reseñas WHERE id = ?');
        $query->execute([$id]);
    }

    // Actualizar una reseña
    public function updateReview($id, $id_paciente, $id_doctor, $comentario) {
        $query = $this->db->prepare('UPDATE reseñas SET id_paciente = ?, id_doctor = ?, comentario = ? WHERE id = ?');
        $query->execute([$id_paciente, $id_doctor, $comentario, $id]);
    }
}

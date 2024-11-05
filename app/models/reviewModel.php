<?php

class ReviewModel {
    private $db;

    public function __construct() {
       // Conexión a la base de datos
       $this->db = new PDO('mysql:host=localhost;dbname=clinica;charset=utf8', 'root', '');
    }
 
    // Obtener todas las reseñas, con opción de ordenar.
    public function getReviews($orderBy = null , $ordenDirection = ' ASC', $filter_medico=null, $filter_usuario=null, $filter_comentario=null, $page, $limit) {
        $sql = 'SELECT * FROM reseñas';
        //Filtros
        $filtros=[];//Agrego la consulta sql de los filtros SETEADOS.
        $params = [];//Agrego los valores de los filtros SETEADOS.

        if($filter_medico!=null){
            array_push($filtros,' medico = ? ');
            array_push($params, $filter_medico);
        }
        if($filter_usuario!=null){
            array_push($filtros,' usuario = ? ');
            array_push($params, $filter_usuario);
        }
        if($filter_comentario!=null){
            array_push($filtros,' comentario = ? ');
            array_push($params, $filter_comentario);
        }
        if(!empty($filtros)){
            $sql .= ' WHERE ';
            $sql .= implode(' AND ', $filtros);//Agrego filtros a la consulta.
            //$filtros=   medico = ? AND usuario = ? AND comentario = ?
        }
        //Ordenamiento
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
        //Paginacion
        //reviews?page=1&limit=5
        if($limit != null){
            $sql .= ' LIMIT '.$limit;
        }
        if($page != null){
            $sql .= ' OFFSET '.$page;
        }
        $query = $this->db->prepare($sql);
        $query->execute($params);    
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
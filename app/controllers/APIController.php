<?php
require_once './app/models/reviewModel.php';
require_once './app/views/APIView.php';

class APIController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new reviewModel();
        $this->view = new APIView();
    }

    public function getAllReviews($req, $res) {
        $orderBy = null; //devolverlos segun un criterio.
        $orderDirection = null; //devolverlos ordenados.
        $filter_medico = null;
        $filter_usuario = null;
        $filter_comentario = null;

        if(isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
        }
        if(isset($req->query->orderDirection)){
            $orderDirection  = $req->query->orderDirection;
        }
        if(isset($req->query->filter_medico)){
            $filter_medico  = $req->query->filter_medico;
        }
        if(isset($req->query->filter_usuario)){
            $filter_usuario  = $req->query->filter_usuario;
        }
        if(isset($req->query->filter_comentario)){
            $filter_comentario  = $req->query->filter_comentario;
        }
        $reviews = $this->model->getReviews( $orderBy , $orderDirection, $filter_medico, $filter_usuario, $filter_comentario);
        
        if(!$reviews){ // Verificar que la reseña exista.
            return $this->view->response('No hay reseñas', 404);
        }
        return $this->view->response($reviews , 200);// Devolver las reseñas a la vista.
    }

    public function getReview($req, $res) {
        $id = $req->params->id; // Obtener la reseña segun id.

        $review = $this->model->getReview($id); // Verificar que la reseña exista.

        if(!$review) {
            return $this->view->response("La reseña con el id=$id no existe", 404);
        }
        
        return $this->view->response($review , 200); // Devolver la reseña a la vista.
    }

    public function deleteReview($req, $res) {
        $id = $req->params->id; //Eliminar reseña según id.
        
        $review = $this->model->getReview($id);  // Verificar que la reseña exista.

        if (!$review) {
            return $this->view->response("La reseña con el id=$id no existe", 404);
        }

        // Eliminar la reseña.
        $this->model->deleteReview($id);
        return $this->view->response("La reseña con el id=$id se eliminó con éxito", 200);
    }

    public function createReview($req, $res) {
        // Validar los datos.
        if (empty($req->body->usuario) || empty($req->body->medico) || empty($req->body->comentario)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // Obtener los datos.
        $usuario = $req->body->usuario;
        $medico = $req->body->medico;
        $comentario = $req->body->comentario;

        // Insertar la reseña.
        $id = $this->model->createReview($usuario, $medico, $comentario);

        if (!$id) {
            return $this->view->response("Error al insertar reseña", 500);
        }

        // Devolver la reseña insertada.
        $review = $this->model->getReview($id);
        return $this->view->response($review, 201);
    }

    public function updateReview($req, $res) {
        $id = $req->params->id; //Editar una reseña segun id.

        // Verificar que la reseña exista.
        $review = $this->model->getReview($id);
        if (!$review) {
            return $this->view->response("La reseña con el id=$id no existe", 404);
        }

        // Validar los datos.
        if (empty($req->body->usuario) || empty($req->body->medico) || empty($req->body->comentario)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // Obtener los datos.
        $usuario = $req->body->usuario;
        $medico = $req->body->medico;
        $comentario = $req->body->comentario;

        // Actualizar la reseña.
        $this->model->updateReview($id, $usuario, $medico, $comentario);

        // Devolver la reseña modificada.
        $review = $this->model->getReview($id);
        $this->view->response($review, 200);
    }
}
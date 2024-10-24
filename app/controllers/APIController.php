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
        $orderDirection = null; 
        if(isset($req->query->orderBy))
            $orderBy = $req->query->orderBy;

        if(isset($req->query->orderDirection)){
            $orderDirection  = $req->query->orderDirection;
        }
        
        $reviews = $this->model->getReviews( $orderBy , $orderDirection);

        // Devolver las reseñas a la vista.
        return $this->view->response($reviews , 200);
    }

    public function getReview($req, $res) {
        // Obtener el id de la reseña desde la ruta.
        $id = $req->params->id;

        // Obtener la reseña de la database.
        $review = $this->model->getReview($id);

        if(!$review) {
            return $this->view->response("La reseña con el id=$id no existe", 404);
        }

        // Devolver la reseña a la vista.
        return $this->view->response($review , 200 );
    }

    public function deleteReview($req, $res) {
        $id = $req->params->id;

        // Verificar que la reseña exista.
        $review = $this->model->getReview($id);

        if (!$review) {
            return $this->view->response("La reseña con el id=$id no existe", 404);
        }

        // Eliminar la reseña.
        $this->model->deleteReview($id);
        $this->view->response("La reseña con el id=$id se eliminó con éxito", 200);
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
        $id = $req->params->id;

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
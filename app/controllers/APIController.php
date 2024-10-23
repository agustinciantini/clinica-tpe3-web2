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

    // /api/reviews
    public function getAll($req, $res) {
        $orderBy = null;
        $orderDirection = null;
        if(isset($req->query->orderBy))
            $orderBy = $req->query->orderBy;

        if(isset($req->query->orderDirection)){
            $orderDirection  = $req->query->orderDirection;
        }
        
        $reviews = $this->model->getReviews( $orderBy , $orderDirection);

        // Obtener todas las reseñas
        
        
        // Devolver las reseñas a la vista
        return $this->view->response($reviews , 200);
    }

    // /api/reviews/:id
    public function getReview($req, $res) {
        // Obtener el id de la reseña desde la ruta
        $id = $req->params->id;

        // Obtener la reseña de la DB
        $review = $this->model->getReview($id);

        if(!$review) {
            return $this->view->response("La reseña con el id=$id no existe", 404);
        }

        // Devolver la reseña a la vista
        return $this->view->response($review , 200 );
    }

    // api/reviews/:id (DELETE)
    public function delete($req, $res) {
        $id = $req->params->id;

        // Verificar que la reseña exista
        $review = $this->model->getReview($id);

        if (!$review) {
            return $this->view->response("La reseña con el id=$id no existe", 404);
        }

        // Eliminar la reseña
        $this->model->eraseReview($id);
        $this->view->response("La reseña con el id=$id se eliminó con éxito", 200);
    }

    // api/reviews (POST)
    public function create($req, $res) {

        // Validar los datos
        if (empty($req->body->id_paciente) || empty($req->body->id_doctor) || empty($req->body->comentario)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // Obtener los datos
        $id_paciente = $req->body->id_paciente;
        $id_doctor = $req->body->id_doctor;
        $comentario = $req->body->comentario;

        // Insertar la reseña
        $id = $this->model->insertReview($id_paciente, $id_doctor, $comentario);

        if (!$id) {
            return $this->view->response("Error al insertar reseña", 500);
        }

        // Devolver la reseña insertada
        $review = $this->model->getReview($id);
        return $this->view->response($review, 201);
    }

    // api/reviews/:id (PUT)
    public function update($req, $res) {
        $id = $req->params->id;

        // Verificar que la reseña exista
        $review = $this->model->getReview($id);
        if (!$review) {
            return $this->view->response("La reseña con el id=$id no existe", 404);
        }

        // Validar los datos
        if (empty($req->body->id_paciente) || empty($req->body->id_doctor) || empty($req->body->comentario)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // Obtener los datos
        $id_paciente = $req->body->id_paciente;
        $id_doctor = $req->body->id_doctor;
        $comentario = $req->body->comentario;

        // Actualizar la reseña
        $this->model->updateReview($id, $id_paciente, $id_doctor, $comentario);

        // Devolver la reseña modificada
        $review = $this->model->getReview($id);
        $this->view->response($review, 200);
    }
}
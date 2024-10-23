<?php
require_once './app/models/reviewModel.php';

class reviewApiController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new reviewModel();
        $this->view = new JSONView();
    }

    // /api/reviews
    public function getAll($req, $res) {
        $orderBy = false;
        if(isset($req->query->orderBy))
            $orderBy = $req->query->orderBy;

        // Obtener todas las reseñas
        $reviews = $this->model->getReviews($orderBy);
        
        // Devolver las reseñas a la vista
        return $this->view->response($reviews);
    }

    // /api/reviews/:id
    public function get($req, $res) {
        // Obtener el id de la reseña desde la ruta
        $id = $req->params->id;

        // Obtener la reseña de la DB
        $review = $this->model->getReview($id);

        if(!$review) {
            return $this->view->response("La reseña con el id=$id no existe", 404);
        }

        // Devolver la reseña a la vista
        return $this->view->response($review);
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
        $this->view->response("La reseña con el id=$id se eliminó con éxito");
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
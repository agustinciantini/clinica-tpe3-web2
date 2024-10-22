<?php
class reviewApiController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new reviewModel();
        $this->view = new JSONView();
    }

    // /api/tareas
    public function getAll($req, $res) {
        $filtrarFinalizadas = null;
        
        if(isset($req->query->finalizadas)) {
            $filtrarFinalizadas = $req->query->finalizadas;
        }
        
        $orderBy = false;
        if(isset($req->query->orderBy))
            $orderBy = $req->query->orderBy;

        $reviews = $this->model->getReviews($filtrarFinalizadas, $orderBy);
        
        // mando las tareas a la vista
        return $this->view->response($reviews);
    }

    // /api/tareas/:id
    public function get($req, $res) {
        // obtengo el id de la tarea desde la ruta
        $id = $req->params->id;

        // obtengo la tarea de la DB
        $review = $this->model->getReview($id);

        if(!$review) {
            return $this->view->response("La review con el id=$id no existe", 404);
        }

        // mando la tarea a la vista
        return $this->view->response($review);
    }

    // api/tareas/:id (DELETE)
    public function delete($req, $res) {
        $id = $req->params->id;

        $review = $this->model->getReview($id);

        if (!$review) {
            return $this->view->response("La review con el id=$id no existe", 404);
        }

        $this->model->eraseReview($id);
        $this->view->response("La review con el id=$id se eliminó con éxito");
    }

    // api/tareas (POST)
    public function create($req, $res) {

        // valido los datos
        if (empty($req->body->titulo) || empty($req->body->prioridad)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // obtengo los datos
        $titulo = $req->body->titulo;       
        $descripcion = $req->body->descripcion;       
        $prioridad = $req->body->prioridad;       

        // inserto los datos
        $id = $this->model->insertReview($titulo, $descripcion, $prioridad);

        if (!$id) {
            return $this->view->response("Error al insertar review", 500);
        }

        // buena práctica es devolver el recurso insertado
        $review = $this->model->getReview($id);
        return $this->view->response($review, 201);
    }

    // api/tareas/:id (PUT)
    public function update($req, $res) {
        $id = $req->params->id;

        // verifico que exista
        $review = $this->model->getReview($id);
        if (!$review) {
            return $this->view->response("La review con el id=$id no existe", 404);
        }

         // valido los datos
         if (empty($req->body->titulo) || empty($req->body->prioridad) || empty($req->body->finalizada)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // obtengo los datos
        $titulo = $req->body->titulo;       
        $descripcion = $req->body->descripcion;       
        $prioridad = $req->body->prioridad;
        $finalizada = $req->body->finalizada;

        // actualiza la tarea
        $this->model->updateReview($id, $titulo, $descripcion, $prioridad, $finalizada);

        // obtengo la tarea modificada y la devuelvo en la respuesta
        $review = $this->model->getReview($id);
        $this->view->response($review, 200);
    }
}
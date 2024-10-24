# clinica-tpe3-web2

## Integrantes:
* Jazmín Barragán.
* Agustin Ciantini.

## Descripción:

Este proyecto tiene como objetivo crear una API de reseñas de comentarios para una clínica médica, que servirá como una herramienta para gestionar, analizar y manipular las opiniones de los pacientes. La API proporciona acceso a las reseñas existentes en la base de datos, permitiendo a los usuarios obtener una lista completa de reseñas con opciones de filtrado personalizadas. Específicamente, los usuarios podrán filtrar las reseñas según el ID, médico, usuario o comentario, lo que facilita la búsqueda de opiniones relacionadas con cualquiera de estos criterios. Además, la API permite ordenar los resultados de las reseñas en dos modalidades: orden ascendente (ASC) o orden descendente (DESC), lo que mejora la accesibilidad y visualización. También proporciona funcionalidades para crear, modificar y eliminar reseñas.

## Endpoints:

Se detalla la lista de endpoints disponibles en la API para la gestión de reseñas de comentarios en la clínica:

- **GET /reviews**: Devuelve todas las reseñas almacenadas en la base de datos.
- **GET /review/:id**: Devuelve los detalles de una reseña específica según su ID.
- **POST /review**: Permite crear una nueva reseña proporcionando la información requerida en el cuerpo de la solicitud.
- **PUT /review/:id**: Actualiza una reseña existente por ID.
- **DELETE /review/:id**: Elimina una reseña específica por ID.
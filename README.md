# clinica-tpe3-web2

## Integrantes:
* Jazmín Barragán.
* Agustin Ciantini.

## Descripción:

Este proyecto tiene como objetivo crear una API de reseñas de comentarios para una clínica médica, que servirá como una herramienta para gestionar, analizar y manipular las opiniones de los pacientes. La API proporciona acceso a las reseñas existentes en la base de datos, permitiendo a los usuarios obtener una lista completa de reseñas con opciones de filtrado personalizadas. Específicamente, los usuarios podrán filtrar las reseñas según el médico, usuario o comentario, lo que facilita la búsqueda de opiniones relacionadas con cualquiera de estos criterios. Además, la API permite ordenar los resultados de las reseñas en dos modalidades: orden ascendente (ASC) o orden descendente (DESC), lo que mejora la accesibilidad y visualización. También proporciona funcionalidades para crear, modificar y eliminar reseñas.

## Endpoints:

Se detalla la lista de endpoints disponibles en la API para la gestión de reseñas de comentarios en la clínica:

- **GET /api/reviews**: Devuelve todas las reseñas almacenadas en la base de datos.
- **GET /api/review/:id**: Devuelve los detalles de una reseña específica según su ID.
- **POST /api/review**: Permite crear una nueva reseña proporcionando la información requerida en el cuerpo de la solicitud.
- **PUT /api/review/:id**: Actualiza una reseña existente por ID.
- **DELETE /api/review/:id**: Elimina una reseña específica por ID.

## Ordenamiento:
Las reseñas se pueden ordenar por todos sus campos y elegir la direccion de este orden.

Ejemplos:
/api/reviews?orderBy=id&orderDirection=DESC
/api/reviews?orderBy=usuario&orderDirection=ASC
/api/reviews?orderBy=medico&orderDirection=DESC
/api/reviews?orderBy=comentario&orderDirection=ASC

## Filtros:
Las reseñas se pueden filtrar por todos los campos, de a uno, por varios a la vez e incluso por todos.

Ejemplos:
/api/reviews?filter_medico=fausto
/api/reviews?filter_usuario=celeste
/api/reviews?filter_comentario=buen servicio

 --- Concatenados ---
 /api/reviews?filter_medico=fausto&filter_usuario=celeste
 /api/reviews?filter_usuario=celeste&filter_comentario=buen servicio
 (todos)
 /api/reviews?filter_medico=fausto&filter_usuario=celeste&filter_comentario=buen servicio

## Ordenamiento + Filtros
Filtrar por campos, ordenar por campo y en una direccion.

 /api/reviews?filter_medico=maria&filter_usuario=celeste&filter_comentario=excelente&orderBy=id&orderDirection=DESC

 ## Paginación
 Tanto la pagina como el limit de las reseñas a mostrar se pasan por parámetros.
 Si ingresa un limite=0, no hay reseñas.
 Si ingresa una valor de pagina mayor a la cantidad de reseñas, no hay reseñas.
/api/reviews?page=2&limit=6


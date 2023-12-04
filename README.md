# API_CRUD_USER_REINGENERIA

## Documentación del Controlador de Usuarios

### Introducción
La clase UserController sirve como controlador para manejar operaciones relacionadas con usuarios en tu aplicación. Esta documentación proporciona una visión general de los métodos y la funcionalidad dentro de la clase UserController.

### Descripción de la Clase

#### Propiedades

$_method: Representa el método HTTP utilizado en la solicitud (GET, POST, PUT, DELETE, PATCH).

$_complement: Contiene información adicional, como un ID o complemento, dependiendo del contexto.

$_data: Almacena datos asociados con la solicitud, como detalles de usuario.

### Métodos HTTP y Acciones Correspondientes:

#### GET

Si $_complement es 0, recupera todos los usuarios.
Si $_complement no es 0, recupera un usuario específico por ID.

#### POST

Crea un nuevo usuario utilizando los datos proporcionados en el cuerpo de la solicitud (use_mail, use_pss, use_dateCreate).

#### PUT "Actualiza correo y contraseña"

Actualiza un usuario existente utilizando los datos proporcionados en el cuerpo de la solicitud (use_id, use_mail, use_pss).

#### DELETE "Elimina el usuario"

Elimina un usuario existente identificado por los datos proporcionados en el cuerpo de la solicitud (use_id).

#### PATCH "Actualiza el status"

Actualiza el estado de un usuario existente identificado por los datos proporcionados en el cuerpo de la solicitud (use_id, us_status).

Correciones por: Felix Ruiz

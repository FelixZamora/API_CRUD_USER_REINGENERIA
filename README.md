# API_CRUD_USER_REINGENERIA

Documentación del Controlador de Usuarios
Introducción
La clase UserController sirve como controlador para manejar operaciones relacionadas con usuarios en tu aplicación. Esta documentación proporciona una visión general de los métodos y la funcionalidad dentro de la clase UserController.

Descripción de la Clase
Propiedades
$_method: Representa el método HTTP utilizado en la solicitud (GET, POST, PUT, DELETE, PATCH).
$_complement: Contiene información adicional, como un ID o complemento, dependiendo del contexto.
$_data: Almacena datos asociados con la solicitud, como detalles de usuario.
Constructor
__construct($_method, $_complement, $_data): Inicializa el objeto UserController con el método, complemento y datos proporcionados.
Métodos Públicos
index(): Actúa como el punto de entrada principal para el controlador, dirigiendo el flujo según el método HTTP.
Métodos Privados
generateSalting(): Genera una contraseña salada y cifrada, así como un identificador y una clave para las credenciales del usuario.
Métodos
index()
Este método sirve como el punto de entrada principal para el UserController. Maneja diferentes métodos HTTP (GET, POST, PUT, DELETE, PATCH) y dirige las solicitudes a métodos correspondientes en la clase UserModel.

Métodos HTTP y Acciones Correspondientes:
GET

Si $_complement es 0, recupera todos los usuarios.
Si $_complement no es 0, recupera un usuario específico por ID.
POST

Crea un nuevo usuario utilizando los datos proporcionados en el cuerpo de la solicitud.
PUT

Actualiza un usuario existente utilizando los datos proporcionados en el cuerpo de la solicitud.
DELETE

Elimina un usuario existente identificado por los datos proporcionados en el cuerpo de la solicitud.
PATCH

Actualiza el estado de un usuario existente identificado por los datos proporcionados en el cuerpo de la solicitud.
Respuestas:
Las respuestas están formateadas como JSON e incluyen información relevante sobre la acción ejecutada.
generateSalting()
Este método privado es responsable de generar contraseñas cifradas y saladas, así como identificadores y claves cifradas.

Entrada: Ninguna (utiliza la propiedad $_data)
Salida: Un array que contiene credenciales cifradas y saladas.

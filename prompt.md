Analiza y desarrolla a detalle el proyecto especificado en el archivo "Parcial práctico avanzado — Proyecto Docker (PHP + MySQL)". 

Objetivo general:
Construir un entorno completamente funcional basado en contenedores Docker que permita ejecutar una aplicación PHP con base de datos MySQL, cumpliendo con las buenas prácticas de desarrollo, modularidad y persistencia de datos.

🧩 Entregables requeridos:
1. **Estructura completa del proyecto**, organizada y lista para ejecutar con `docker-compose up -d`.  
   - Cualquier usuario debe poder ejecutar el proyecto sin configuraciones adicionales.
   - El contenedor de base de datos debe usar un **volumen persistente** para no perder datos tras un `docker-compose down`.

2. **Archivos solicitados (con contenido listo para copiar/pegar)**:
   - `app/Dockerfile`: basado en `php:8.2-apache`, habilitar `pdo_mysql` y exponer puerto 80.
   - `docker-compose.yml`: definir servicios `app` y `db`, red interna, volúmenes persistentes, variables de entorno y dependencias (`depends_on`).
   - `db/init.sql`: crear la base de datos, tabla `users` e insertar 3 registros de ejemplo.
   - `app/index.php`: punto de inicio con mensaje de bienvenida y conexión a la BD.
   - `app/users.php`: endpoints para listar (`GET /users`) y agregar usuarios (`POST /users`).
   - `.env.example`: con variables `MYSQL_ROOT_PASSWORD`, `MYSQL_DATABASE`, `MYSQL_USER`, `MYSQL_PASSWORD`, etc.
   - `README.md`: guía clara y breve con los pasos para construir, ejecutar y probar el proyecto.

3. **Comandos de ejecución y prueba manual**:
   - Construcción de la imagen: `docker build -t <tu_usuario>/php-app:1.0 .`
   - Publicación en Docker Hub: `docker push <tu_usuario>/php-app:1.0`
   - Ejecución del stack: `docker-compose up -d`
   - Verificación de contenedores: `docker ps`
   - Pruebas de endpoints:
     - `curl http://localhost:8080`
     - `curl http://localhost:8080/users`
     - `curl -X POST -H "Content-Type: application/json" -d '{"name":"John","email":"john@example.com"}' http://localhost:8080/users`

4. **Buenas prácticas y convenciones**:
   - Usar nombres de variables y funciones en inglés.
   - No incluir credenciales reales (usar placeholders o `.env`).
   - Aplicar formato limpio y comentarios mínimos.
   - Estructura reproducible (no dependiente de configuraciones locales).

5. **README.md (sencillo)** debe incluir:
   - Descripción del proyecto.
   - Pasos para construir y ejecutar el entorno.
   - Ejemplos de endpoints y comandos de prueba.
   - Nota sobre la persistencia de la base de datos mediante volumen.

6. **No incluir**:
   - Archivos de CI/CD (como GitHub Actions).
   - Credenciales reales o secretos.

🧠 Requisitos funcionales adicionales:
- La base de datos debe persistir su información incluso después de detener o eliminar los contenedores.
- El proyecto debe levantar correctamente con **solo `docker-compose up -d`**, sin pasos manuales previos.
- Todos los archivos deben ser coherentes y consistentes entre sí (nombres de DB, usuarios, rutas y puertos).

Entrega esperada:
Una estructura de proyecto completa y funcional con todos los archivos mencionados, comandos de verificación manual y un README simple, todo siguiendo las buenas prácticas de programación y Docker.

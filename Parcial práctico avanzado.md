**Parcial práctico avanzado — Proyecto Docker (PHP + MySQL)**

**Objetivo:** Construir y contenerizar una aplicación web sencilla en **PHP** con base de datos **MySQL**, usando Dockerfile y docker-compose.yml. El estudiante deberá crear su propia imagen de la aplicación, subirla a **Docker Hub**, y luego utilizar esa imagen en el docker-compose.yml. Finalmente, subir todo el proyecto a **GitHub**.

-----
**Contexto del ejercicio**

El estudiante debe crear una aplicación PHP básica (sin framework) que permita:

- Mostrar una lista de usuarios (GET /users).
- Agregar un nuevo usuario (POST /users) con los campos nombre y email.

La aplicación debe conectarse a una base de datos **MySQL**, ejecutándose directamente desde PHP.

-----
**Requisitos mínimos**

1. **Dockerfile (para PHP)**
   1. Usar imagen base php:8.2-apache.
   1. Copiar los archivos fuente de la aplicación dentro del contenedor.
   1. Instalar extensiones necesarias (por ejemplo, pdo\_mysql).
   1. Exponer el puerto 80.

Ejemplo de construcción:

docker build -t usuario\_dockerhub/php-app:1.0 .

docker push usuario\_dockerhub/php-app:1.0

1. **docker-compose.yml** con dos servicios:
   1. app: usa la imagen subida a Docker Hub (usuario\_dockerhub/php-app:1.0).
   1. db: imagen oficial mysql:8, con volumen para persistencia y variables desde .env.

Además debe incluir:

1. Una red común.
1. Archivo .env con credenciales seguras.
1. **Persistencia y scripts SQL:**
   1. Volumen para /var/lib/mysql.
   1. Script init.sql con creación de tabla users(id, nombre, email) y tres registros de prueba.
1. **Estructura del proyecto:**

project-root/

├─ app/

│  ├─ index.php

│  ├─ users.php

│  └─ Dockerfile

├─ db/

│  └─ init.sql

├─ docker-compose.yml

├─ .env.example

└─ README.md

4. Subir el proyecto a **GitHub**:
   1. Crear un repositorio público o privado con el nombre docker-php-mysql.
   1. Subir todos los archivos del proyecto.


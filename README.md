<div align="center">

# 📚 Librería Capítulos

### Portal web para consultar libros y autores

</div>

---

## Descripción

**Librería Capítulos** es un portal web desarrollado como proyecto final de la asignatura **Programación Web**.

El sistema le permite al usuario consultar los libros y autores registrados en la base de datos proporcionada por el profesor, realizar búsquedas, aplicar filtros, visualizar la información completa de cada libro y enviar mensajes mediante un formulario de contacto.

El proyecto utiliza una arquitectura sencilla en la que las páginas muestran la interfaz, JavaScript realiza las solicitudes y las acciones PHP se comunican con MySQL utilizando PDO.

---

## Funcionalidades

| Módulo       | Descripción                                                                                       |
| ------------ | ------------------------------------------------------------------------------------------------- |
| **Inicio**   | Presenta el libro más vendido y tres publicaciones seleccionadas aleatoriamente.                  |
| **Libros**   | Muestra la información completa de todos los libros y permite filtrarlos por distintos criterios. |
| **Autores**  | Presenta la información de los autores y permite consultar sus libros relacionados.               |
| **Contacto** | Muestra la información de la librería y almacena los mensajes enviados por los usuarios.          |

---

## Tecnologías utilizadas

- HTML5
- CSS3
- JavaScript
- PHP 8
- MySQL / MariaDB
- PDO
- Bootstrap
- XAMPP

---

## Estructura

```text
libreria-proyecto-pweb/
│
├── actions/
│   ├── autores/
│   │   ├── obtener_autores.php
│   │   └── obtener_estados.php
│   │
│   ├── contacto/
│   │   └── guardar_mensaje.php
│   │
│   ├── inicio/
│   │   ├── obtener_libro-mas-vendido.php
│   │   └── obtener_libros-destacados.php
│   │
│   └── libros/
│       └── obtener_libros.php
│
├── assets/
│   ├── css/
│   │   └── estilos.css
│   │
│   └── js/
│       ├── app.js
│       ├── autores.js
│       ├── contacto.js
│       ├── inicio.js
│       └── libros.js
│
├── config/
│   └── conexion.php
│
├── database/
│   ├── dblibreria.sql
│   └── dblibreria-completa.sql
│
├── autores.php
├── contacto.php
├── index.php
├── libros.php
└── README.md
```

---

## Base de datos

La base de datos proporcionada es:

```text
dblibreria
```

Y el archivo recomendado para instalar todas las tablas es:

```text
database/dblibreria-completa.sql
```

Este archivo .sql incluye la base de datos original de la librería y la tabla `contacto`, utilizada para almacenar los mensajes enviados desde el formulario.

Entre las tablas utilizadas se encuentran:

- `titulos`
- `autores`
- `titulo_autor`
- `publicadores`
- `contacto`

> [!NOTE]
> Los mensajes se almacenan en la tabla `contacto` mediante una consulta preparada con PDO.

---

## Autor

**Alen Josué Toribio Fernández**

Matrícula: 2025-1057
Estudiante de Desarrollo de Software  
Instituto Tecnológico de Las Américas — ITLA

---

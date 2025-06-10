# Sistema de Gestión de Estudiantes

Este sistema permite gestionar cursos, alumnos, materias y asistencia para una institución educativa. Está desarrollado utilizando PHP, HTML y CSS, con una base de datos MySQL.

## Características Principales

- Gestión de 7 cursos técnicos (7to INFO A, 7to INFO B, 7to ADO A, 7to ADO B, 7to ELECTRONICA, 7to QUIMICA, 7to MULTI)
- Importación de alumnos desde archivos PDF
- Registro de materias con sus respectivos horarios
- Control de asistencia por materia y cálculo de porcentajes
- Reportes de asistencia por alumno y por materia
- Interfaz responsiva para uso en dispositivos móviles y de escritorio

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache, Nginx, etc.)

## Instalación

1. Clonar o descargar este repositorio
2. Crear una base de datos MySQL
3. Importar el archivo `db_setup.sql` para crear las tablas necesarias
4. Configurar los datos de conexión a la base de datos en `config/database.php`
5. Colocar los archivos en el directorio de su servidor web
6. Acceder al sistema a través de su navegador

## Acceso al Sistema

Para acceder al sistema, utilice las siguientes credenciales:

- Usuario: admin
- Contraseña: admin123

## Estructura del Proyecto

- `config/`: Archivos de configuración
- `controllers/`: Controladores de la aplicación
- `models/`: Modelos para interactuar con la base de datos
- `views/`: Vistas de la aplicación
- `includes/`: Funciones y utilidades
- `public/`: Archivos públicos (CSS, JS, imágenes)
- `uploads/`: Directorio para almacenar archivos PDF subidos

## Uso del Sistema

1. Iniciar sesión con las credenciales proporcionadas
2. Navegar a la sección de cursos para ver los cursos disponibles
3. Seleccionar un curso para administrar sus alumnos y materias
4. Importar alumnos desde un archivo PDF o agregarlos manualmente
5. Agregar materias con sus horarios
6. Registrar la asistencia de los alumnos por materia
7. Consultar los reportes de asistencia por alumno o por materia

## Características Adicionales

- Diseño moderno y responsivo
- Animaciones sutiles para mejorar la experiencia de usuario
- Colores distintivos para cada tipo de curso
- Visualización clara de los porcentajes de asistencia
- Interfaz intuitiva para la gestión de alumnos y materias
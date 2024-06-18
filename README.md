# Employee Satisfaction SPA

## Descripción del Proyecto

Esta es una aplicación de una sola página (SPA) desarrollada para el seguimiento de la satisfacción de los empleados de varias empresas. La aplicación permite visualizar una lista de empleados, buscar por cualquiera de sus propiedades, ordenar la lista por nivel de satisfacción o categoría, y manejar una lista de favoritos.

## Tecnologías Utilizadas

### Frontend
- **Svelte**: Utilizado para construir la interfaz de usuario interactiva y dinámica.
- **Axios**: Utilizado para realizar solicitudes HTTP al backend.

### Backend
- **PHP Laravel 8.0**: Utilizado para construir la API RESTful.
- **MySQL/MariaDB**: Utilizado para la persistencia de datos.

## Requerimientos

- **Node.js** y **npm**
- **Composer**
- **MySQL/MariaDB**
- **PHP 7.3+**

## Instalación y Configuración

### Backend (Laravel)

1. Clonar el repositorio:
    ```bash
    git clone https://github.com/medison0001/EmployeeSatisfaction.git
    cd EmployeeSatisfaction
    ```

2. Instalar dependencias:
    ```bash
    composer install
    ```

3. Configurar el archivo `.env`:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=employee_satisfaction
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4. Ejecutar las migraciones:
    ```bash
    php artisan migrate
    ```

5. Iniciar el servidor de desarrollo:
    ```bash
    php artisan serve
    ```

### Frontend (Svelte)

1. Navegar al directorio del frontend:
    ```bash
    cd employee-satisfaction-frontend
    ```

2. Instalar dependencias:
    ```bash
    npm install
    ```

3. Iniciar el servidor de desarrollo:
    ```bash
    npm run dev
    ```

## Uso

1. Abrir el navegador y visitar `http://localhost:5000` para ver la aplicación en funcionamiento.

## Funcionalidades

- **Listado de Empleados**: Visualiza una lista de empleados con sus detalles.
- **Búsqueda**: Busca empleados por nombre, correo, área, categoría, empresa, o nivel de satisfacción.
- **Ordenación**: Ordena la lista de empleados por nivel de satisfacción o categoría.
- **Paginación**: Muestra 5 empleados por página.
- **Favoritos**: Agrega empleados a una lista de favoritos, con capacidad de búsqueda y eliminación en la lista de favoritos.

## Pruebas

### Pruebas Unitarias

Se ha implementado una prueba unitaria para verificar la creación de empleados.

#### Ejecutar Pruebas

1. Asegurarse de que la base de datos de pruebas esté configurada en el archivo `.env`:
    ```env
    DB_DATABASE=employee_satisfaction_test
    ```

2. Ejecutar las pruebas:
    ```bash
    php artisan test
    ```

## Patrones de Diseño Utilizados

### Singleton (Creacional)

El patrón Singleton se utiliza en Laravel para gestionar instancias únicas de servicios. Por ejemplo, el contenedor de servicios de Laravel utiliza singleton para manejar instancias únicas.

### Factory Method (Creacional)

Se implementa un Factory Method para crear instancias de `Employee` según su categoría. Esto permite centralizar la lógica de creación y mantenerla limpia y manejable.

## Supuestos

- Se asume que el usuario final tiene acceso a un navegador web moderno y conexión a internet para acceder a la aplicación.
- Se asume que los datos de empleados están previamente cargados en la base de datos para la visualización y búsqueda.

## Envío del Proyecto

El código del proyecto reside en el siguiente repositorio de Git:
https://github.com/medison0001/EmployeeSatisfaction.git

Para cualquier pregunta o aclaración, por favor contactar a medison@misena.edu.co.

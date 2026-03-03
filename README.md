# Sistema de Punto de Venta (POS) - OXXO

Proyecto desarrollado para la asignatura de **Programación Web**. Es una aplicación web Full-Stack diseñada para gestionar el flujo de caja, el inventario y las ventas de una sucursal, simulando el entorno de un OXXO.

##  Stack Tecnológico

* **Backend:** Laravel 11 (API RESTful)
* **Frontend:** React.js + Vite
* **Base de Datos:** MySQL
* **Autenticación:** Laravel Sanctum (Bearer Tokens)

##  Módulos Principales

1. **Autenticación:** Login seguro para cajeros y administradores.
2. **Catálogo de Productos:** Gestión de inventario con alertas de stock mínimo.
3. **Punto de Venta:** Carrito de compras y registro de ventas (tickets).
4. **Kardex (Inventario):** Historial de entradas y salidas de mercancía.
5. **Corte de Caja:** Resumen de ventas totales del día.

##  Requisitos Previos

Asegurar de tener instalados los siguientes programas antes de ejecutar el proyecto:
* PHP >= 8.2
* Composer
* Node.js y npm
* Servidor local de base de datos (XAMPP, MAMP, o MySQL nativo)

##  Instrucciones de Instalación y Ejecución

### 1. Configuración del Backend (API Laravel)

Abre tu terminal, navega a la carpeta `backend` y ejecuta:

```bash
# Instalar dependencias de PHP
composer install

# Copiar el archivo de entorno y generar la llave
cp .env.example .env
php artisan key:generate

# Configurar tu base de datos en el archivo .env y luego correr migraciones
php artisan migrate

# Iniciar el servidor de desarrollo
php artisan serve

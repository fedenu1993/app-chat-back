# Proyecto de chat

Este es un proyecto de ejemplo que implementa un sistema de autenticación con registro de usuarios, verificación por correo electrónico y login utilizando Laravel y Sanctum para la gestión de tokens.

Parte de chat (COMPLETAR)

Parte de pasarela de pagos (COMPLETAR)

## Requisitos

Antes de empezar, asegúrate de tener los siguientes programas instalados:

- PHP >= 8.1
- Composer
- MySQL o cualquier otra base de datos compatible
- Laravel >= 9.x
- Mailpit o un servidor SMTP para el envío de correos

## Instalación

### 1. Clonar el repositorio

git clone https://github.com/fedenu1993/app-chat-back.git
cd app-chat-back

### 2. Instalar dependencias

Ejecuta el siguiente comando para instalar todas las dependencias de PHP con Composer:
composer install

### 3. Configuración de entorno

Copia el archivo .env.example y renómbralo como .env:
cp .env.example .env

Configuración de base de datos
Configura las variables de la base de datos en el archivo .env. Asegúrate de actualizar las siguientes líneas:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario_de_bd
DB_PASSWORD=tu_contraseña_de_bd

Configuración de correo
Configura las variables de correo electrónico en el archivo .env. Si estás utilizando Mailpit para pruebas locales, la configuración es la siguiente:

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@tu-dominio.com
MAIL_FROM_NAME="${APP_NAME}"

Si usas un servidor SMTP en producción (como Gmail, Mailgun, etc.), necesitarás configurar los valores correspondientes:

MAIL_MAILER=smtp
MAIL_HOST=smtp.tu-servidor.com
MAIL_PORT=587
MAIL_USERNAME=tu-usuario
MAIL_PASSWORD=tu-contraseña
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-email@dominio.com
MAIL_FROM_NAME="${APP_NAME}"

### 4. Generar la clave de aplicación

Ejecuta el siguiente comando para generar la clave de la aplicación:
php artisan key:generate

### 5. Migraciones

Ejecuta las migraciones para crear las tablas necesarias en la base de datos:
php artisan migrate

Si necesitas poblar la base de datos con datos de prueba, puedes usar:
php artisan db:seed

### 6. Configurar Sanctum

Asegúrate de que la configuración de Sanctum esté correcta. Ejecuta el siguiente comando para publicar el archivo de configuración:

php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

A continuación, asegúrate de que api middleware esté configurado en app/Http/Kernel.php:

'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],

### 7. Iniciar el servidor

Para iniciar el servidor de desarrollo, ejecuta:
php artisan serve

Por defecto, la aplicación estará disponible en http://localhost:8000.

## Uso de la API

La API permite realizar las siguientes operaciones:

### 1. Registro de usuario

Método: POST
Endpoint: /api/register

Datos requeridos:
{
  "name": "Nombre del usuario",
  "email": "correo@dominio.com",
  "password": "contraseña123",
  "password_confirmation": "contraseña123"
}

Al registrarse, el sistema enviará un correo electrónico de verificación. El usuario debe verificar su correo antes de poder iniciar sesión.

### 2. Login de usuario

Método: POST
Endpoint: /api/login

Datos requeridos:

{
  "email": "correo@dominio.com",
  "password": "contraseña123"
}

Si las credenciales son correctas, el sistema devolverá un token de autenticación.

### 3. Verificación del correo electrónico

Método: GET
Endpoint: /api/email/verify/{id}/{hash}

Después de registrarse, el usuario recibirá un correo con un enlace de verificación. Cuando el usuario acceda al enlace, su correo será confirmado y podrá usar la cuenta para acceder a la aplicación.

### 4. Reenviar correo de verificación

Método: POST
Endpoint: /api/email/verification-notification

El usuario puede solicitar un nuevo enlace de verificación si no lo recibió o si lo perdió.

Autenticación requerida: El usuario debe estar autenticado para realizar esta solicitud.

## Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo LICENSE para más detalles.
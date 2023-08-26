# Gobierno-Digital
## Proyecto para Gobierno-Digital Back-End

### Eliezer Lozano Trejo

Para desplegar un proyecto Laravel, debes seguir estos pasos:

1. **Clonar el proyecto de GitHub en tu servidor web.**
2. **Crear una base de datos y configurar el archivo .env.**
3. **Migrar y sembrar la base de datos.**
4. **Copiar los archivos del proyecto al servidor web.**
5. **Configurar el servidor web para que sirva el proyecto.**

**Clonar el proyecto de GitHub**

Para clonar el proyecto de GitHub, abre una terminal en tu computadora y ejecuta el siguiente comando:

```
git clone git@github.com:Necrospartan/Gobierno-Digital.git
```

Esto creará una nueva carpeta llamada `Gobierno-Digital` en tu directorio de trabajo actual. Desplaste a la carpeta que contine el proyecto.

```mv Gobierno-digital```

Ahora ejecuta el comando:

```composer install```

El comando `composer install` descarga e instala las dependencias de un proyecto de PHP.

En la carpeta del proyecto encontrar el archivo `.env.example`, renombralo como `.env`.

Por último, generaremos la Key con la que se cifraran los tokens, esto lo hacemos mediante el siguiente comando:

```php artisan jwt:secret```

**Crear una base de datos y configurar el archivo .env**

Laravel requiere una base de datos para almacenar sus datos. Para crear una base de datos, puedes utilizar tu herramienta de administración de bases de datos favorita. Una vez que hayas creado la base de datos, debes configurar el archivo `.env`.

El archivo `.env` contiene las variables de entorno del proyecto. Para configurar la base de datos, debes actualizar las siguientes variables en el archivo `.env`:

* `DB_HOST`: La dirección del servidor de la base de datos.
* `DB_PORT`: El puerto del servidor de la base de datos.
* `DB_DATABASE`: El nombre de la base de datos que creaste anteriormente.
* `DB_USERNAME`: El nombre de usuario de la base de datos.
* `DB_PASSWORD`: La contraseña de la base de datos.

**Migrar y sembrar la base de datos**

Laravel utiliza migraciones y semillas para crear y poblar la base de datos. Para migrar la base de datos, ejecuta el siguiente comando:

```php artisan migrate```

Este comando aplicará todas las migraciones a la base de datos.

Para sembrar la base de datos, ejecuta el siguiente comando:

```php artisan db:seed```

Este comando ejecutará todas las semillas para poblar la base de datos con datos de ejemplo.

**Inicia un servidor web PHP**

Para iniciar el servidor web, ejecuta el siguiente comando en la terminal:

```php artisan serve```

El servidor web se iniciará y te mostrará un mensaje que indica que la aplicación está en ejecución.

Puedes acceder a tu aplicación en http://localhost:8000 en tu navegador web.

**Pruebas**
Abre tu programa `postman` e importa el archivo `tests_postman/Prueba Gobierno Digital.postman_collection.json` 
En el encontraras la pruba para cada una de las funciones implementadas en esta API.

**Login** es una función que se utiliza para autenticar a un usuario. Regresa el *Token* generado por `JWT Token`. Existen dos tipos de usuarios `Administrador` el cial puede consultar, crear, editar y eliminar usuarios., `Usuario` el cual solo pude consultar la información.
**Create** *(Adminstrador)* permite a los usuarios agregar un nuevo registro a la base de datos,
**Read_id***(Adminstrador, Usuario)* regresa la informacion del usuarion del id proporcionado.
**Read_all***(Adminstrador, Usuario)* regresa la informacion de todos los usuarios en la base de datos.
**Update** *(Adminstrador)* actualiza la informacion del usuario de la id proporcinada.
**Delete** *(Adminstrador)* elimina de la base de datos al usuario que coincida con la id proporcionada.

***Uso del postman***
En la carpeta `prueba administrador``, se encontra las pruebas antes mensionadas.

* La prueba `login` se encuentra precargada con informacion correspondente a un usuario con privilegio de administror, esta funcion regresara su respectivo `Token`.

* Prueba de `create`, para esta prueba tendremos que copiar el token del login y pegarlo en la pestaña Authorization y ejecutar la prueba, si todo salio de manera corecta regresara un mensaje de que el usuario se agrego de manera correcta.

* Prueba de `read_id`y `read_all`, cada una regresara la informacion correspondiente.

* Prueba de `update`, de manera similar a la pruba `create` necesitara que proporciones el `Token` del login. Si la actualizacion salio de manera correcta regresara un mensaje de exito.

* Prueba de `delete`, similar a las anteriores se necesitara que se proporcione el `Token` del inicio de seccion. Si el borrdo del usuario se realiza de  manera correcta regresara un mensaje de exito.

En la carpeta `prueba usuario`, se encontrar las mismas pruebas, pero ahora el login contiene la infromacion de inicio de un usuario sin provilegio de administrador. Las pruebas se realizar de manera identica a las del administrador. La unica diferencia sera que en todas regresara un mensaje `No tienes permiso de acceder a esta ruta`, salvo la de `read`.
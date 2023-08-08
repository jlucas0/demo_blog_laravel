## Descripción
Esta aplicación representa la estructura de un hipotético blog, con vistas web y una API. Se ha diseñado únicamente como ejemplo, por lo que no tiene un uso real.

Está, por tanto, creada únicamente como experimento y demostración de conocimientos.

## Requisitos
La aplicación está implementada en Laravel 10, por lo que se deberán cumplir con los <a href="https://laravel.com/docs/10.x/deployment#server-requirements">requisitos especificados por el propio framework</a>.

La aplicación ha sido desarrollada usando como motor de base de datos MySQL 8, pero también ha sido probada con una base de datos SQLite integrada. No obstante, podría usarse como motor cualquiera de los soportados por Laravel.

Para la gestión de dependencias se usa <a href="https://getcomposer.org/">Composer</a> por lo que deberá encontrarse instalado previamente.

## Instalación
<ol>
    <li>Instalar todas las dependencias mediante Composer ejecutando en la carpeta raíz el siguiente comando: <pre>composer install</pre>
    (Suponiendo que Composer se encuentre instalado como comando).</li>
    <li>Crear el archivo de configuración del entorno, añadiendo un fichero con nombre ".env" en el directorio raíz. Puede usarse el incluido ".env.example" como plantilla.</li>
    <li>Elegir el motor de base de datos deseado de los soportados por Laravel, y configurar la conexión en el archivo .env como se especifica en la <a href="https://laravel.com/docs/10.x/database#introduction">documentación</a>.
    Si se elige como motor SQLite, se incluye un comando para crear cómodamente la base de datos, ejecutando: <pre>php artisan db:sqlite-generate</pre>
    </li>
    <li>Establecer la clave de cifrado ejecutando: <pre>php artisan key:generate</pre></li>
    <li>Crear la estructura de tablas de la base de datos ejecutando las migraciones: <pre>php artisan migrate</pre>
    Opcionalmente, si se desea partir con algunos datos de prueba, se puede aplicar el seeder:<pre>php artisan db:seed</pre>
    Este comando crea 10 autores y 50 posts con datos ficticios.</li>
    <li>Una vez instalada la aplicación, puede ponerse en funcionamiento con:
    <pre>php artisan serve</pre>
    Este comando crea un servicio web local que permite conectar con la aplicación mediante HTTP.
    </li>
</ol>


## Estructura
<u>Modelo de datos</u>

La aplicación cuenta con dos tablas principales para las entidades: authores (authors) y publicaciones (posts). Adicionalmente se incluye otra tabla para la gesión de tokens de acceso, utilizados para la autenticación en la API.

Los campos y relaciones pueden comprobarse en el siguiente esquema:
<p align="center">
    <img src="https://lh3.googleusercontent.com/u/0/drive-viewer/AITFw-yMkjklpQTgAo8XcJ9ouJy4KqXJT7QGhrrROSHiB8RqoLISzzN4cO-oX9vfSpQgOJSSlajLzWYEA1fUeQcgOPbMq1THZg=w2560-h1243" alt="MER" width="200">
</p>

<u>Clases</u>

Dejando a un lado las clases incluidas por el propio framework, y algunas secundarias como las utilizadas para representar ciertos componentes web, podemos centrarnos en 3 grupos de clases fundamentalmente, ubicadas dentro del directorio app.

En primer lugar se encuentran los modelos (<strong>Models</strong>), que representan las entidades fundamentales y configuran sus propiedades y relaciones. Son clases estándar del <a href="https://laravel.com/docs/10.x/eloquent">ORM Eloquent</a>, por lo que mantienen todas sus características.

Los que se encargan de manipular los modelos para recuperar información o dar persistencia a los datos son los denominados "adaptadores" (<strong>Adapters</strong>). Estos adaptadores implementan la interfaz Adapter y tienen los métodos principales para el CRUD (teniendo en cuenta que en este caso al ser un ejemplo algunos no se han incluido), así como los necesarios para el manejo de cada entidad específica.

Por último, están los controladores (<strong>Controllers</strong>) dentro del directorio Http. Estos se encargan de gestionar las peticiones recibidas y generar las respuestas correspondientes apoyándose en los adaptadores para obtener la información necesaria. Los controladores están divididos en dos grupos: los de tipo web, que se encargan de pintar las vistas HTML para la aplicación frontend, y los de tipo API (que heredan de la clase abstracta ApiController), enfocados en implementar las funciones de la API Rest utilizando JSON.


## Características funcionales
<u>Web</u>

La web consta únicamente de dos páginas: la portada y el detalle de la publicación.

La portada contiene un listado de publicaciones ordenadas con las más recientes primero, agrupadas de 10 en 10 por página, y pulsando en cada una de ellas se accede al detalle.

En el detalle se muestra la publicación completa así como cierta información sobre el autor.

La maquetación se ha llevado a cabo usando <a href="https://getbootstrap.com/docs/5.3/getting-started/introduction/">Boostrap 5.3</a>. Dado que se ha usado únicamente la hoja de estilos base de Boostrap, que ya está en formato comprimido, no se ha incluido ningún compilador de recursos como Vite o Mix.

Adicionalmente se ha incluido también una vista para el error 404.

<u>API</u>

La API Rest cuenta con varias funcionalidades de ejemplo referentes a los autores y las publicaciones.

En una de ellas se ha añadido un sistema de autenticación básico mediante token, considerando que para poder crear una nueva publicación debe accederse como un autor registrado. Para ello, los autores pueden hacer login mediante su email y contraseña (todos los autores generados mediante el seeder tienen por defecto la contraseña "password"). Con esta función de login, se puede obtener un token de acceso.

Toda la documentación de la API puede consultarse en la url /api/documentation, la cual ha sido generada mediante <a href="https://github.com/DarkaOnLine/L5-Swagger">L5-Swagger</a>


## Testing

Para asegurar el correcto funcionamiento de la aplicación, se han añadido una serie de test que analizan ciertas funciones.

En este caso, únicamente se han aplicado tests sobre las funciones de los adaptadores a modo de ejemplo, aunque sería interesante realizarlos también sobre los controladores.

Los tests son de tipo "feature", ya que todas las funcionalidades testadas hacen uso del framework y por tanto éste debe arrancarse previamente (lo cual no ocurre con los tests de tipo "unit").

Para verificar que todos los tests se realizan correctamente se debe ejecutar:
<pre>php artisan test</pre>

Por otro lado se ha añadido también el paquete <a href="https://github.com/nunomaduro/larastan">Larastan</a> para el análisis del código configurado en el modo más estricto.

Se puede probar con:
<pre>php .\vendor\bin\phpstan analyse</pre>


## Comentarios adicionales
Aunque esta aplicación ha sido creada únicamente como ejemplo y a modo de práctica, se podrían mejorar aún ciertos aspectos (aparte de los mencionados antes como el testeo de los controladores).

Hay diversas características básicas de un blog que no se han incluido, tales como el registro de usuarios, la categorización de publicaciones o implementar algún buscador...

Todo ello son cuestiones que aunque sean interesantes a nivel funcional, no aportan mayor relevancia en cuanto a la estructura interna. En cambio, sí que hubiese sido interesante poder gestionar imágenes para incluirlas como portada en las publicaciones o para los autores, ya que permitiría incluir manejo de ficheros (al menos para la función de crear publicaciones mediante la API, ya que el envío de imágenes a una API es algo más complicado de implementar).

Por otro lado, también hay cuestiones implementadas que podrían perfeccionarse. Una de ellas es por ejemplo el paginador de la portada, que en el momento en que haya muchas publicaciones probablemente aparezcan demasiados números, por lo que sería interesante que se comprimiesen. Aparte, se llegó a contemplar también el incorporar un contador de visitas en cada publicación (y de hecho el campo sigue estando en la base de datos), pero finalmente no se ha llegado a implementar para no alargar demasiado el tiempo dedicado a esta práctica. También podrían limitarse los campos que se muestran en el listado de publicaciones de la API, pero por el momento se listan con toda la información pese a que podría obtenerse una respuesta demasiado extensa al incluir todo el texto de la publicación.
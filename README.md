# Prueba Stradata

## Descripción
Sistema que permita la validación de nombres de personas contra una base de datos de personas publicas (Tabla diccionario), 
es decir, políticos, actores, cantantes, etc., para saber qué porcentaje de
coincidencia existe entre ellos.

El sistema cuenta con: 
- Un algoritmo de validación de nombres expuesto como web service, que
  reciba como parámetros los nombres y apellidos de la persona que se debe
  validar y el porcentaje de coincidencia mínimo que se espera como
  respuesta, es decir, a partir de ese valor de porcentaje se entregarán
  coincidencias. A modo de Ejemplo: Alejandro Hernandez vs Alejandro
  Fernandez, tendrá una coincidencia del 90%, si al Web service le envío
  como parámetro el 90%devolveré el resultado, pero si el parámetro es del
  95 % el resultado será vacío. (Este se puede consumir mediante webservice)
- Pagina de inicio 
- Login
- Dashboard diseñado con ppción de ingregar un nombre y el rating de similitud y devuelve las 25 mejores coincidencias
(para esto se hizo tambien una pequeña mejora a nivel de base de datos dando un index de full text search usando el driver de natural language 
para mejorar un poco los resultados. Una vez sobre esos resultados hace las calculaciones de las coincidencias)
- Usa laravel, Tailwind Css y Apline js (un mini framework sin necesidad de instalar que esta basado en vue se usó por su simplicidad)

## Instalación

Una vez terminado esto usar la base de datos que esta en <br>
`database/stradata.sql` <br>
<br>
Una vez se tiene la base de datos importado y su usuario puede correr
`cp .env.example .env` asi se genera el .env
 
Despues se debe de instalar las dependencias 
`composer install` <br> <br>

se puede iniciar sesión con: <br>

prueba@gmail.com <br>
password

## Código donde esta la prueba

Hay una Clase que se llama StringCompare.php
`app/StringCompare.php` <br>
Esta clase es la encargada de cacular y comparar el nombre dado con los strings.

Al construir la clase coge el nombre y permuta el nombre en un array de nombres posibles. <br>
Ej: Juan Goovaerts hace un array `['Juan Goovaerts,','Goovaerts Juan']` esto se hace para que el
se puede comprar el nombre es los ordenes posibles

Tiene un método que reemplaze letters por sus parecido esto hace que se puede cumplir el requisito de que Vi y Bi dan el mismo resultado

Tiene un metodo que calcula la similitud de de los strings, y devuelve el porcentaje, el hace el transform a lower case y cambia el string con el método explicado aquí arriba

El método `compare` va coger el array de los posibles ordenes de los nombres y va comparar con un string, calcula toda las posibildades y retorna el mayor puntaje

El metodo `withPublicFigures` recibe un array de collection y calcula para todos su porcentaje

Desde el controlador se ordena por el ranking, y se limita 25 resultados

En `app/PublicFigure.php`  se hizo un search method que usa el full text search de sql para poder "filtrar" un poco los resultados y no hacerlo con todos los records así mejorando un poco el rendimineto

No pude probar lo suficiente con boolean mode que sería lo ideal para performance entonces por ahora lo deje en natural lang

En `database/migrations/` se puede ver la migración y como se agregó el index


Se hizo tambien un test que se puede correr 
`php artisan test`

El test se puede ver en
`tests/Unit/StringCompareTest.php`


# Listado de paises - API Rest

Implementación de un API Rest para solicitar el listado de paises del mundo con sus codigos ISO en formato JSON.

##  Requisitos

* Tener **PHP >= 5.3.0*
* Modulos de base de datos **php5-mysql**, y **php5-sqlite** para los tests
* Para la generación del informe de covertura de tests instalar php5-xdebug

##  Configuración


Copiar el fichero ```app/properties.ini.dis``` a ```app/properties.ini``` y configurar las credenciales de acceso a base de datos.

```ini
db.dsn = "mysql:host=localhost;port=3306;dbname=api_country"
db.username = "root"
db.password =  ""
```

El servidor web deberá poder acceder al directorio **public**

##  Instalación

### Automatica

Verificada las dependencias y teniendo la configuración se puede llevar a cabo una instalación rápida ejecutando...

```bash
./install.sh
```

* Desplegara las librerías de proyecto
* Creará y cargará la base de datos
* Pasará los tests y generará los informes en el directorio **report**

### Manual

Constará de los siguientes pasos...

#### Librerías

Debemos desplegar las diferentes librerías dependientes de la aplicación para su ejecución, así como para su testeo.

* Descargar composer si no estuviera instalado y ejecutar su instalación...

```bash

curl -sS https://getcomposer.org/installer | php -- --filename=composer

./composer installl

```

#### Base de datos

* Crear y cargar la base de datos...

```bash

mysql -h localhot -u user api-rest < fixtures/database.sql

mysql -h localhot -u user api-rest < fixtures/countries.sql

```

#### Tests

Para comporbar la integridad de la aplicación se pasarán los tests con **phpunit** ...

```bash

./vendor/bin/phpunit -c phpunit.xml.dist

```

Los informes se generan bajo el directorio **report** donde podras encontrar...

* ./report/coverage/index.html - Para covertura de codigo
* ./report/testdox.html - Para listado de tests


## Ejecución

Para consuir el API se accedera por HTTP a ....

* http://hostname/api/countries





#!/bin/bash

PATH_PWD=$(pwd)
SCRIPT_PATH=$(cd $(dirname $0); pwd)
SCRIPT_NAME=$(basename $0)

cd $SCRIPT_PATH

echo -e "\n\n### Iniciando proceso de instalación...\n"

PROPERTIES_FILE=${SCRIPT_PATH}/app/properties.ini

if [[ ! -e ${PROPERTIES_FILE} ]]; then
    echo 'Configura el fichero de configuración "properties.ini"'
    exit -1
fi

CMD_COMPOSER=($(which ./composer ./composer.phar composer composer.phar))
if [[ ${CMD_COMPOSER} == "" ]]; then
    curl -sS https://getcomposer.org/installer | php -- --filename=composer
    CMD_COMPOSER="composer"
fi

$CMD_COMPOSER install

#
echo -e "\n\n### Inicializando base de datos...\n"

CMD_MYSQL=($(which mysql))
if [[ ${CMD_MYSQL} == "" ]]; then
    echo 'Instala el cliente mysql para poder inicializar la base de datos'
    exit -1
fi

PARAMS_MYSQL=$(cat ${PROPERTIES_FILE} | tr -d "\"" | tr ";:" "\n" | \
            sed "s/db\.//;s/host/--host/;s/dbname/--database/;s/username/--user/;s/password/--password/;s/[ ]*=[ ]*/=/g" | \
            grep "\-\-[a-Z]" | tr "\n" " ")

echo "Creando base de datos..."
$CMD_MYSQL $PARAMS_MYSQL < ${SCRIPT_PATH}/fixtures/database.sql
echo "Cargando datos..."
$CMD_MYSQL $PARAMS_MYSQL  < ${SCRIPT_PATH}/fixtures/countries.sql

echo -e "\n\n### Pasando tests y generando informes...\n"

CMD_PHPUNIT=${SCRIPT_PATH}/vendor/bin/phpunit

$CMD_PHPUNIT -c ${SCRIPT_PATH}

cd $PATH_PWD


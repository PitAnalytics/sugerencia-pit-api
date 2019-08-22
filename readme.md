#
CONFIGURACION Y DEPENDENCIAS

##
INSTALAR DEPENDENCIAS

###
composer require catfan/medoo
###
composer require slim/slim

##
OPTIMIZAR AUTOLOAD PSR-4
###
cd app
###
composer dump-autoload -o


##
DEPENDENCIAS OPCIONALES
###
composer require guzzlehttp/guzzle

###
composer require wisembly/elephant.io

##
RUTAS DE PRUEBA

###
ROOT
###
http://localhost/skeleton/public

###
http://localhost/skeleton/public
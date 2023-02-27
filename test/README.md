## Docs
https://phpunit.readthedocs.io/

## Конфигурация
* в корне скопировать файл `phpunit.xml.example`, переименовав его в `phpunit.xml`
* настроить параметры среды в теге `<php>`
* дополняйте файл `.example`, если вводите новые переменные/параметры в локальном файле

## Запуск
```console
foo@bar:~$ vendor/bin/phpunit --testsuite example
```

## Запуск из контейнера docker
```console
foo@bar:~$ docker-compose exec php sh -c "cd var/www/game && vendor/bin/phpunit --testsuite example"
```
## или
```console
foo@bar:~$ ./test/run example
```

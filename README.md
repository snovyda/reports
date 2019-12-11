# Reports system
Reports upload and processing


## Инсталляция

1) git clone
2) composer install
3) Setup DATABASE_URL in <i>.env</i> file. 
    For example <code>DATABASE_URL=mysql://user:yourPassword@127.0.0.1:3306/reports_db?serverVersion=8.0</code>
    Tested on MySQL v 8.0
4) bin/console doctrine:database:create
5) bin/console doctrine:migrations:migrate

## Запуск

bin/console server:start && navigate to http://127.0.0.1:8000/

# mon BLOG

#### Environnement docker: ( php 8 / apache / mariadb)

```shell 
docker compose build --pull --no-cache
docker-compose up -d
```

##### Base de données:
```shell 
php bin/console doctrine:schema:update -f
```
##### fixtures:
```shell 
php bin/console doctrine:fixtures:load
```
##### front: installation du front
```shell 
yarn install
yarn watch
```

##### TEST unitaire
```shell 
php bin/phpunit
```
Le site est accessible en local sous l'url suivante:
https://localhost    

```shell 
Accées base de données  via adminer:
http://localhost:8080/   
serveur:database
utilisateur:root
Mot de passe:password              
Base de données: interInvest-test-technique

(voir .env)
DATABASE_URL=mysql://root:password@database:3306/interInvest-test-technique?serverVersion=5.7                                        
```


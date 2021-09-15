# Final Project

This is the RestFull Api of the application for the Final Project subject from the career of Information System Engineering of the UTN of Argentina. This project is about the building of a teaching platform of the Natural Cience, particularly for the teaching of the contents of the human body. The application has some features on Augmented Reality that should improve at teaching to the students and it is focused on the evaluation process of them.
This is a forked repository and the project is actualy being under development.

# Instalation Steps

This document describes the needed steps in order to configure the development environment for the local PC under Linux operating systems by using Docker.

### Requirements for installing the project.

* Already installed **Git**.
* Already installed **Composer**.
* Already installed **docker** and **docker-compose** (use the Digital Ocean guides. They are well documented).
* Already installed **php-client** **php-mbstring**.

### Clone the repositories of Github

Clone the repositories under the directory of election with the name of your choice.

* Repository of the **api** (backend):

``` 
git clone git@github.com:emi310397/ProyectoFinalBackEnd api
```

* Repository of the **web** app (frontend):

``` 
git clone git@github.com:sbarrautn/ProyectoFinalFrontEnd web
```

* Repository of the containers **docker** (docker):

``` 
git clone git@github.com:sbarrautn/ProyectoFinalDocker docker
```

### Instalation of the Docker containers.

1. Enter to the project docker folder. (`/docker`)

2. Execute `docker-compose pull`

3. Execute `docker-compose up -d`

4. Start the containers with `docker-compose start` or `pfd start`

5. To verify that all containers have started and see their status `docker-compose ps`

6. Edit the `.env` file of the docker by adding the routes of each repository folder.

7. (Optional) If we don't want to remember al the IPs, we can edit the local host file `sudo /etc/hosts` by mapping each IP with a easy to remember domain name. For eg:
`10.5.0.2        api.project.test`
`10.5.0.6        project.test`

8. (Optional) In order to use the `pfd` command and get autocompleted the rest of commands: `pfd install-bash-completions`

9. (Optional) In order to use the `pfd` command from any directory and not only from `/docker`:
    * We enter to edit our `~/.profile`.
    * Add the next line `PATH="$HOME/dev/project/docker/scripts/:$PATH"` at the end of `~/.profile`.
    * If we want to test if it is working wihtout rebooting, reload the new path: `source ~/.profile`

### Install composer in the project of the Api.

```
https://getcomposer.org/download/
```
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
PD: Consider that the previous hash is being updated so it is better to enter to the composer site.

Copy the `composer.phar` from the installation provided by the previous commands to the root folder of the Api of the project.

### Api container (Backend)

If we want to enter to the Api container: `pfd commander` or `pfd bash` or `docker exec -it proyecto_api bash`.

### Web container (Frontend)

If we want to enter to the Web container: `pfd frontend-start` or `docker exec -it proyecto_web bash`.

### Dependencies installation.

1. Enter to the Lord Commander (Ricky Fort) executing `pfd commander` or `pfd bash` or `docker exec -it proyecto_api bash` (Wich is basicaly our Nginx bash)

2. Execute `./composer.phar install` to download all the Laravel dependencies.

### Create an Enviroment file

1. Create a ```.env``` file.

2. Copy from the ```.env.example``` file.

3. Edit the variables that are necessary.

4. Execute in order to complete the `.env` file `php artisan key:generate`.

This file has all the credentials of the used account services.

### Database configuration.

1. Install mysql-client

2. Execute `pfd bash database` or `docker exec -it proyecto_database bash` (With this, we enter to the Mysql docker)

4. Execute `mysql -uroot -psecret`

5. Create the DB: `create database project;`

6. Verify the DB creation: `show databases;`

7. We get out if the DB was created successfully: `exit`.

### Migration execution (Laravel)

1. First, update the `.env` file with the DB credentials:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=project
DB_USERNAME=root
DB_PASSWORD=secret
```

1. Enter to the bash of the Api (Lord Commander) in `/docker` and execute: `pfd commander` or `pfd bash` or `docker exec -it proyecto_api bash`.

2. Execute in the bash `php artisan doctrine:clear:metadata:cache` in order to clean the Doctrine cache.

3. Execute in the bash `php artisan doctrine:migrations:migrate` or `php artisan doctrine:migrations:refresh` depending on the working context.

4. Once finished the execution we will hace all the tables of our DB `project`.

5. That's all! We can get out from the Commander: `exit`.

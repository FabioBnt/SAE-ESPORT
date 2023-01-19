# SAE-ESPORT

 Projet Universitaire Web ayant pour but de développer une application facilitant l'organisation d'une saison de tournois d'e-sport. \
 Academic Web project aiming at developing an application facilitating the organization of a season of e-sport tournaments.

## How to run PHPUnit tests / Comment lancer les tests PHPUnit (WINDOWS)

### 1- install composer / installer composer

<https://getcomposer.org/download/>

### 2- add php and composer to sys path varibales / ajouter php et composer aux variables d'environnement système

### 3- go to the repository of your project and install dependencies / se positionner à la racine de votre projet et installer les dépendances

 ```sh
 cd /SAE-ESPORT/
 composer require phpunit/phpunit ^9
 ```

### 4- finally run the tests / lancer les tests

 ```sh
 .\vendor\bin\phpunit 
 ``

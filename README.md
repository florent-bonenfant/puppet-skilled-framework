# Guinot - Extranet - Back-end

##  Présentation du projet

L'application **Guinot - Portail** permet aux instituts de beauté Guinot et Mary Cohr de pouvoir récupérer les documents et informations relatifs à leur contrat d'affiliation : factures, conditions commerciales, contrats de location de matériel.

Le projet est découpé en deux applications :
 - un back-end, permettant d'administrer l'application et offrant l'accès au données via des APIs REST
 - un front-end, permettant aux adhérents Guinot et Mary Cohr d'accéder à leurs informations

Les données de l'application sont principalement issues de fichiers CSV déposés les jours sur le serveur par le logiciel eOne.

##  Technologies

Le back-end repose sur le framework PHP [globalis-ms/puppet-skilled-framework](https://github.com/globalis-ms/puppet-skilled-framework), développé par GLOBALIS. Il présente une architecture de fichier similaire au framework CodeIgniter, tout en intégrant des modules provenant d'autres technologies PHP, notamment Laravel et Symfony.

Les tâches automatisées sont paramétrées avec [globalis-ms/robo_task](https://github.com/globalis-ms/robo_task) et les migrations de base de données sont gérées par [cakephp/phinx](https://github.com/cakephp/phinx).

L'intégration repose sur le starter [globalis-ms/globox](https://github.com/globalis-ms/globox), il est situé dans le répertoire *integrations* avec l'ensemble des assets. Lors de la concaténation et la minification des assets, les fichiers traités sont copiés dans le répertoire *public*.

La documentation des APIs est générée par Postman. Le fichier à importer se trouve dans le répertoire *util*.

##  Pré-requis de l'environnement

 - PHP 7.0 ou 7.1
 - MySQL 5.7
 - Apache 2.4 (modules de base + rewrite + ssl)

##  Configuration et installation

Commencer par installer les dépendances PHP du projet grâce à Composer, récupérable à cette [adresse](https://getcomposer.org).
```
composer install
```

Ensuite, lancer la configuration et l'installation automatique du projet avec la commande suivante :
```
./vendor/bin/robo install
```

 Ci-dessous les informations qui seront demandées pour installer l'application :

| Option | Description |
| --- | --- |
| DB_NAME |  Nom de la base de données. |
| DB_USER |  Nom de l'utilisateur de la base de données. |
| DB_PASSWORD |  Mot de passe de l'utilisateur de la base de données. |
| DB_HOST |  Adresse de la base de données. |
| DB_HOST |  Port utilisé par la base de données. |
| ENVIRONEMENT |  Environnement de l'application : *development*, *testing*, *production*. |
| WEB_SCHEME | Protocole utilisé par l'application : *http* ou *https*. |
| WEB_HOST | Nom de domaine. |
| WEB_SCHEME | Chemin de l'application à partir de la racine du serveur web (laisser vide si il n'y a pas de sous-répertoire). |
| COOKIE_SECURE | Utilise les cookies uniquement s'il existe une connexion sécurisée HTTPS |
| EMAIL_PROTOCOL | Protocole ou programme utilisé pour envoyer des mails : *mail*, *sendmail*, ou *smtp*. |
| EMAIL_HOST | Adresse du serveur SMTP (utilisé pour les envois mail par SMTP) |
| SMTP_USER | Nom de l'utilisateur SMTP (utilisé pour les envois mail par SMTP) |
| SMTP_PASSWORD | Mot de passe de l'utilisateur SMTP (utilisé pour les envois mail par SMTP) |
| SMTP_CRYPTO | Méthode d'encryption SMTP : *tls*, *smtp* ou vide. (utilisé pour les envois mail par SMTP) |
| EMAIL_PORT | Port utilisé par le serveur SMTP. (utilisé pour les envois mail par SMTP) |
| EMAIL_INTERCEPTION | Adresse mail vers laquelle sont redirigés tous les mails envoyés par l'application. Laisser vide pour ne pas activer la redirection. |
| DATA_PATH | Chemin vers le dossier contenant les archives des fichiers importés ainsi que les documents eOne. |
| DATA_IMPORT_PATH | Chemin vers le dossier contenant tous les fichiers eOne à importer. |
| DATA_EXPORT_PATH | Chemin vers le dossier contenant tous les fichiers exportés par l'application à récupérer pour eOne. |
| LOG_IMPORT_PATH | Chemin vers le dossier contenant les logs journalisés des imports. |
| FRONT_WEB_SCHEME | Protocole utilisé par l'application front-end : *http* ou *https*. |
| FRONT_WEB_HOST | Nom de domaine de l'application front-end. |
| FRONT_WEB_PATH | Chemin de l'application à partir de la racine du serveur web (laisser vide si il n'y a pas de sous-répertoire). |

Ensuite, installer la structure de la base de données :
```
./vendor/bin/robo migrate:up
```

Ajouter un jeu de données dans la base :
```
./vendor/bin/phinx seed:run
```

## Tâches journalières

Lancer l'importation des données eOne :
```
php public/index.php sync && php public/index.php queue
```

Envoyer les notifications aux clients (à déclencher après l'importation des données) :
```
php public/index.php notification
```

## Déployer l'application sur le serveur de recette

```
./vendor/bin/robo deploy:staging <branche>
```

## Déployer l'application sur le serveur de production

```
./vendor/bin/robo deploy:production <branche>
```
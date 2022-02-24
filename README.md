# O'Japon

Le projet O'Japon est un site collaboratif, permettant à des voyageurs de partager leur expérience de voyage, et à de futurs voyageurs de préparer leur séjour au Japon.

O'Japon is a collaborative website, allowing travelers to share their travel experience, and future travelers to prepare their stay in Japan.

## Backend

Ce repository ne concerne que le backend du projet, qui sera développé à l'aide de WordPress.

This repository will only contain the back end project with wordpress

## Frontend

Les interactions et la dynamisation des pages seront développées à l'aide du [framework Vue.js](https://vuejs.org/).

The front end will be developed with the framework [Vue.js](https://vuejs.org/).

Le repository pour le frontend se trouve [ici](https://github.com/O-clock-Yuna/projet-24-voyage-o-japon-front).

See front-end repository [front](https://github.com/O-clock-Yuna/projet-24-voyage-o-japon-front)

## Configuration initiale 
## Initial setting

### Récupérer ce repo Github
### Clone the repository

```bash
git clone git@github.com:O-clock-Yuna/projet-24-voyage-o-japon-back.git
```

---

### Création du vhost
## Create vhost

Se déplacer dans le dossier du repo puis récupérer le chemin exact du dossier courant pour le copier et le garder de côté :

Move in the folder and retrieve the exact path of the current folder to copy it and keep it aside : 

```bash
pwd
```

Ouvrir ensuite le dossier des vhosts d'Apache, pour dupliquer un des fichiers de conf existants (par exemple _ocooking.conf_ pour créer _ojapon.conf_). Ouvrir le nouveau fichier avec nano pour l'éditer :

Then open the vhost Apache folder. Duplicate one of the conf files ( for exemple _ocooking.conf_ pour créer _ojapon.conf_ )
Open the new file with nano for edit it.

```bash
cd /etc/apache2/sites-available/
ls
sudo cp ocooking.conf ojapon.conf 

sudo nano ojapon.conf
```

Modifier les infos **(/!\ rajouter _/bedrock/web_ à la fin du chemin)**

Edit information **(/!\ add _/bedrock/web_ at the end)**

```apache
<VirtualHost *:80>
	ServerName ojapon.local
	ServerAdmin webmaster@localhost
	DocumentRoot path/to/project/folder/bedrock/web

	# Emplacement logs Apache
	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Activer le nouveau site puis redémarrer Apache

Activate the new website and reload Apache

```bash
sudo a2ensite ojapon.conf

sudo service apache2 reload
```

Modifier les hosts sur le poste

Modify the hosts on the computer

```bash
sudo sed -i -e '$a127.0.0.1 ojapon.local' /etc/hosts
```

---

### Création de la base de données

### Creation of the database

Via Adminer ou phpMyAdmin, avec un nom de BDD et un user identique. Accorder tous les privilèges à l'user.

Use Adminer or phpMyAdmin with the same name between database and username. Grant all privileges.  

---

### Configurer le projet

### Configure the project

Éditer le fichier .env pour modifier :

Edit .env file 

* les infos de connexion à la BDD
* la variable WP_HOME='http://ojapon.local'
* les différentes keys avec [Roots.io](https://roots.io/salts.html)

* Database information
* WP_HOME='http://ojapon.local'
* Change the keys with [Roots.io](https://roots.io/salts.html) 


Le projet utilise la version 5.8.3 de WordPress, le fichier _composer.lock_ en tient compte. Il suffit donc d'installer les dépendances pour que le projet soit prêt à fonctionner (commande à exécuter dans le dossier bedrock) :

This project use the version 5.8.3 of Wordpress. You have to install dependencies to get the project ready ( command to run in bedrock folder) :

```bash
composer install
```

En cas de besoin, pour forcer l'utilisation de la version 5.8.3 de WordPress, modifier dans le fichier _composer.json_ à la racine du dossier Bedrock la ligne suivante :

If necessary, to force the use of version 5.8.3 of WordPress, modify in the _composer.json_ file at the root of the Bedrock folder the following line :

```composer
"roots/wordpress": "5.8.3",
```

Puis faire une mise à jour des dépendances :

Then update dependencies : 

```bash
composer update
```

---

### Terminer l'installation

### Complete the installation

Aller sur l'adresse locale du projet http://ojapon.local. Cela devrait afficher la page de configuration de WP.

Go to http://ojapon.local. This should display the wordpress configuration page.

Il peut être nécessaire de modifier les droits du dossier web pour installer des plugins ou faire des mises à jour :

It may be necessary to modify the rights of the web folder to install plugins or make updates


```bash 
sudo chgrp -R www-data .
sudo find . -type f -exec chmod 664 {} +
sudo find . -type d -exec chmod 775 {} +
```

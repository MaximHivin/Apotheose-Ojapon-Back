# O'Japon

Le projet O'Japon est un site collaboratif, permettant à des voyageurs de partager leur expérience de voyage, et à de futurs voyageurs de préparer leur séjour au Japon.

## Backend

Ce repository ne concerne que le backend du projet, qui sera développé à l'aide de WordPress.

## Frontend

Les interactions et la dynamisation des pages seront développées à l'aide du [framework Vue.js](https://vuejs.org/).

Le repository pour le frontend se trouve [ici](https://github.com/O-clock-Yuna/projet-24-voyage-o-japon-front).

## Configuration initiale

### Récupérer ce repo Github

```bash
git clone git@github.com:O-clock-Yuna/projet-24-voyage-o-japon-back.git
```

---

### Création du vhost

Se déplacer dans le dossier du repo puis récupérer le chemin exact du dossier courant pour le copier et le garder de côté :

```bash
pwd
```

Ouvrir ensuite le dossier des vhosts d'Apache, pour dupliquer un des fichiers de conf existants (par exemple _ocooking.conf_ pour créer _ojapon.conf_). Ouvrir le nouveau fichier avec nano pour l'éditer :

```bash
cd /etc/apache2/sites-available/
ls
sudo cp ocooking.conf ojapon.conf 

sudo nano ojapon.conf
```

Modifier les infos **(/!\ rajouter _/bedrock/web_ à la fin du chemin)**

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

```bash
sudo a2ensite ojapon.conf

sudo service apache2 reload
```

Modifier les hosts sur le poste

```bash
sudo sed -i -e '$a127.0.0.1 ojapon.local' /etc/hosts
```

---

### Création de la base de données

Via Adminer ou phpMyAdmin, avec un nom de BDD et un user identique. Accorder tous les privilèges à l'user.

---

### Configurer le projet

Éditer le fichier .env pour modifier :

* les infos de connexion à la BDD
* la variable WP_HOME='http://ojapon.local'
* les différentes keys avec [Roots.io](https://roots.io/salts.html)

Le projet utilise la version 5.8.3 de WordPress, le fichier _composer.lock_ en tient compte. Il suffit donc d'installer les dépendances pour que le projet soit prêt à fonctionner (commande à exécuter dans le dossier bedrock) :

```bash
composer install
```

En cas de besoin, pour forcer l'utilisation de la version 5.8.3 de WordPress, modifier dans le fichier _composer.json_ à la racine du dossier Bedrock la ligne suivante :

```composer
"roots/wordpress": "5.8.3",
```

Puis faire une mise à jour des dépendances :

```bash
composer update
```

---

### Terminer l'installation

Aller sur l'adresse locale du projet http://ojapon.local. Cela devrait afficher la page de configuration de WP.

Il peut être nécessaire de modifier les droits du dossier web pour installer des plugins ou faire des mises à jour : 

```bash 
sudo chgrp -R www-data .
sudo find . -type f -exec chmod 664 {} +
sudo find . -type d -exec chmod 775 {} +
```
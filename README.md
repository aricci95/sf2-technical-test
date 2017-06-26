# StadLine Technical Test

### Auteur

Antoine RICCI (aricci95@gmail.com)

### Temps passé

Plus ou moins 4 heures.


### Config

ajouter dans parameters.yml => github_api_token: '38a5dfeac4c6e2bddd9a44b58bd607cc0065bd1e'

### Test Account

stadline / testtest

### Database

Run la synchro Symfony Doctrine : bin/console doctrine:schema:update --force

Inserer le compte de test :

INSERT INTO `user` (`id`,`username`,`username_canonical`,`email`,`email_canonical`,`enabled`,`salt`,`password`,`last_login`,`confirmation_token`,`password_requested_at`,`roles`,`first_name`,`last_name`) VALUES (3,'stadline','stadline','stadline@gmail.com','stadline@gmail.com',1,NULL,'$2y$13$OzIcOj9m40LO3RHmqZjJVuiIP2Nsc4o9oQTH2i66TY9JUGcuRcRyS','2017-06-26 15:16:13',NULL,NULL,'a:2:{i:0;s:5:\"ADMIN\";i:1;s:10:\"ROLE_ADMIN\";}','','');
# README #

### Requirements ###

* PHP 5.5+ / HHVM
* Mysql 5+
* Composer

### How do I get set up? ###

```
#!shell

git clone https://markovicmilosh@bitbucket.org/markovicmilosh/quantox_test.git
```


```
#!shell

cd quantox
```


```
#!shell

composer self-update && composer install
```

_make sql table_

```
#!shell

php -S localhost:81
```


### SQL table ###


```
#!sql

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;

```
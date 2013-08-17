Socool Framework

you must have session in database for use session with socool framework.

example with mysql :

```SQL

CREATE TABLE IF NOT EXISTS `session` (
  `session_id` varchar(255) NOT NULL,
  `session_value` text NOT NULL,
  `session_time` int(11) NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

```

for install socool you must use composer to load all dependencies of the project :

getcomposer.org

```cmd
php composer.phar require ddtraceweb/socool
```

For Assets Css and Js, I recommand to use "Bower"

http://bower.io/

```
cd web/assets/components
bower update
```

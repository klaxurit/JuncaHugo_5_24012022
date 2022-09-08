### Code rating from Codacy [![Codacy Badge](https://app.codacy.com/project/badge/Grade/5efc8b4a92e54bc9b5389c2959a5c791)](https://www.codacy.com/gh/klaxurit/JuncaHugo_5_24012022/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=klaxurit/JuncaHugo_5_24012022&amp;utm_campaign=Badge_Grade)

### Code review from SymfonyInsight [![SymfonyInsight](https://insight.symfony.com/projects/fc6b1990-e50a-44af-ac56-ab2f4dd66f28/mini.svg)](https://insight.symfony.com/projects/fc6b1990-e50a-44af-ac56-ab2f4dd66f28)

---

### Welcome to my PHP from scratch blog 
Hi! This is the readme of my **OCR** project number 5 named **"Create your first blog in PHP"**.  
The version of **PHP** used is **8.0**

---

### Dev environment

*Ubuntu 20.04 & Pop!_OS 21.10*  
![linux logo](https://d33wubrfki0l68.cloudfront.net/e7ed9fe4bafe46e275c807d63591f85f9ab246ba/e2d28/assets/images/tux.png)

---

### Used packages
*phpmailer/phpmailer* [![Latest Stable Version](http://poser.pugx.org/phpmailer/phpmailer/v)](https://packagist.org/packages/phpmailer/phpmailer) [![Total Downloads](http://poser.pugx.org/phpmailer/phpmailer/downloads)](https://packagist.org/packages/phpmailer/phpmailer) [![License](http://poser.pugx.org/phpmailer/phpmailer/license)](https://packagist.org/packages/phpmailer/phpmailer) [![PHP Version Require](http://poser.pugx.org/phpmailer/phpmailer/require/php)](https://packagist.org/packages/phpmailer/phpmailer)

*cocur/slugify* [![Latest Stable Version](http://poser.pugx.org/cocur/slugify/v)](https://packagist.org/packages/cocur/slugify) [![Total Downloads](http://poser.pugx.org/cocur/slugify/downloads)](https://packagist.org/packages/cocur/slugify)  [![License](http://poser.pugx.org/cocur/slugify/license)](https://packagist.org/packages/cocur/slugify) [![PHP Version Require](http://poser.pugx.org/cocur/slugify/require/php)](https://packagist.org/packages/cocur/slugify)

*twig/twig* [![Latest Stable Version](http://poser.pugx.org/twig/twig/v)](https://packagist.org/packages/twig/twig) [![Total Downloads](http://poser.pugx.org/twig/twig/downloads)](https://packagist.org/packages/twig/twig) [![License](http://poser.pugx.org/twig/twig/license)](https://packagist.org/packages/twig/twig) [![PHP Version Require](http://poser.pugx.org/twig/twig/require/php)](https://packagist.org/packages/twig/twig)

*mailhog/mailhog* [![latest packaged version(s)](https://repology.org/badge/latest-versions/mailhog.svg)](https://repology.org/project/mailhog/versions)

---

### Install project

##### Requirements:
- Apache server
- PHP 8.1 (with somes packages: yaml, mysqli, pdo_mysql)
- MySQL 8.0
- Composer 2

##### Installation step by step:
- Clone the git repository in your /var/www/your_domain/public_html/
- Run composer install in the project folder.
- Find the database.sql file at the project root and import it on your MySQL serv. 
- ( *admin* mail: admin@admin.com pw: Admin1306- / *user* mail: user@user.com pw: User1306- )
- Check out the config folder at the project root, config them and remove the .example extension to use it.

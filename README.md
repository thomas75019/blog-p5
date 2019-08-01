# blog-p5
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/19fce4b1ad2345aeab0403cad5ce445c)](https://app.codacy.com/app/thomas75019/blog-p5?utm_source=github.com&utm_medium=referral&utm_content=thomas75019/blog-p5&utm_campaign=Badge_Grade_Dashboard)

Descritpion
===========

Blog created my degree.
This blog only PHP, Object Oriented Programming concepts, and MVC Architecture. 
Some externals library has been used such as: 
* Twig For the templates
* Aura/Router for the router
* Doctrine for the ORM 
* Zend/Diactoros for the psr7 implementation
* plasticbrain/php-flash-messages for flash messages
* PhpMailer for the mailer service 

# Installation

Clone this project, then to install depedencies:
  
    $ composer install
    
Modidy configuration files to set up the database then 
    
    $ vendor/bin/doctrine orm:schema-tool:create

To create database's schema

See [Doctrine Documentation](https://www.doctrine-project.org/projects/doctrine-orm/en/current/tutorials/getting-started.html)

To launch the project 
   
    $ php -S 127.0.0.1
    

    

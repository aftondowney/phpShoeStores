# _Shoe Stores_

#### _This will allow a user to create a store and add brands to that store. They will also be able to add stores to a particular brand, 03/04/2016_

#### By _**Afton Downey**_

## Description

_This app was built with PHP using Silex and Twig templates. The purpose of this app is for a user to be able to add stores to a shoe database. Brands can be listed under individual stores. Stores can also be listed under specific brands._

## Setup/Installation Requirements

* _Fork or clone from GitHub_
* _Please create a separate branch if you cloned_
* _Open the folder in a text editor like Atom to view the code_
* _In your terminal for the site to work, use the command "composer update"_
* _To see the page displayed on the front end, within the terminal navigate to the web folder to initialize a local server_
* _Type in the command "php -S localhost:8000" to start the server_
* _Use localhost:8000 in your web browser to view the page_
* MySQL Commands
1. create database shoes;
2. use shoes;
3. create table brands (name text, id serial primary key);
4. create table stores (name text, id serial primary key);
5. create table stores_brands (store_id int, brand_id int, id serial primary key);


## Known Bugs

_As of 3/4/16 there are no known bugs._

## Technologies Used

_This app was built in PHP using HTML alongside Silex and Twig. I used PHPUnit for testing and created the database using MySQL. PHPmyadmin is the database manager._

### License

*MIT License*

Copyright (c) 2016 **_Afton Downey_**

Neo4 Social App

A simple example of how a social app can use Neo4J to enhance features such as relationships.
Built using PHP and Bower.

![](http://neo4j.com/wp-content/themes/neo4jweb/assets/images/neo4j-logo-2015.png)

In the root directory

> curl -sS https://getcomposer.org/installer | php

Install Dependencies

> bower install
> composer install

Note: Ensure that the Neo4j service is running.

You will also obviously need to have Neo4J installed (These installation steps are for Ubuntu).

> wget -O - http://debian.neo4j.org/neotechnology.gpg.key >> key.pgp
> sudo apt-key add key.pgp
> echo 'deb http://debian.neo4j.org/repo stable/' | sudo tee -a /etc/apt/sources.list.d/neo4j.list > /dev/null
> sudo apt-get update && sudo apt-get install neo4j
> sudo service neo4j-service (stop|start|restart)

Import Seed Data

> neo4j-shell -file seed.cql
> neo4j-shell -file contraints.cql

You can then run a development server using PHP by running the following in the /web directory or configuring your web server to point at the contained index.php file.

> php -S localhost:8000

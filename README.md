Neo4 Social App

A simple example of how a social app can use Neo4J to enhance features such as relationships.

> curl -sS https://getcomposer.org/installer | php

Install Dependencies

> bower install
> composer install

You will also obviously need to have Neo4J installed (These installation steps are for Ubuntu).

> wget -O - http://debian.neo4j.org/neotechnology.gpg.key >> key.pgp
> sudo apt-key add key.pgp
> echo 'deb http://debian.neo4j.org/repo stable/' | sudo tee -a /etc/apt/sources.list.d/neo4j.list > /dev/null
> sudo apt-get update && sudo apt-get install neo4j
> sudo service neo4j-service (stop|start|restart)

You can then run a development server using PHP by running

> php -S localhost:8000


TO DO

Degrees of seperation logic on UI
Tidy up UI
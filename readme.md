# Laravel GraphQL Demo

### Tech Stack

* [Laravel] - PHP MVC Framework
* [GraphQL] - GraphQL Library
* [Docker] - Container deployment and development system

# Getting Started

### (1): Clone the repo
```sh
git clone git@github.com:dcronje/laravel-graphql.git
```
### (2): Setup local certificates
Install root ssl certificate
##### Linux:

```sh
sudo mkdir /usr/local/share/ca-certificates/laravel-graphql
sudo cp ./dev_setup/local_ssl/rootCA.pem /usr/local/share/ca-certificates/laravel-graphql/laravel-graphql.dev.pem
sudo chmod 0755 /usr/local/share/ca-certificates/laravel-graphql/ && sudo chmod 0644 /usr/local/share/ca-certificates/laravel-graphql/laravel-graphql.dev.pem
sudo update-ca-certificates
```

##### Mac OSX:

```sh
sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain ./dev_setup/local_ssl/rootCA.pem
```

##### Windows
```sh
Dont use windows, it sucks. Install ubuntu.
```

### (3): Install Docker
* Download and install the latest version of: [Docker]
* Make the dev_setup.sh file executable:
```sh
chmod +x ./dev_setup.sh
```
* Run the dev_setup.sh script
```sh
./dev_setup.sh
```

### (4): Modify your hosts file
```sh
echo '127.0.0.1 laravel-graphql.dev' | sudo tee -a /etc/hosts
```

#### Woohoo you are good to go! browse to: [laravel-graphql.dev/graphiql](https://laravel-graphql.dev/graphiql)

[Laravel]: <https://laravel.com>
[GraphQL]: <https://github.com/Folkloreatelier/laravel-graphql>
[Docker]: <https://docs.docker.com/>

Note the example API uses google geocode API so you must set the GOOGLE_API_KEY in your .env file then run
```sh
docker exec -it laravel-graphql-web /bin/bash
```
once logged in run:
```sh
php artisan config:cache
```

#### OR

```sh
docker exec -it laravel-graphql-web /bin/bash -c "php artisan config:cache"
```

# Tooling
There is an artisan command to help create new GraphQL entities:
## To Add a New Entity
log in to the container:
```sh
docker exec -it laravel-graphql-web /bin/bash
```
then
```sh
php artisan graph:create {entity_name} --lists --mtations
```
--mutations
will create add / remove / update mutations with all supporting input types for your new entity

--lists
will create create getAll getOne getCount queries with all supporting input and object tyes for you new entity

you will need to edit the following files (if applicable):

#### /app/GraphQL/{entity_name}/Types/{entity_name}InputType.php 
To set all the input properties for creating a new object.

#### /app/GraphQL/{entity_name}/Types/{entity_name}ListFiltersType.php 
To set all properties you may want to filter on.

#### /app/GraphQL/{entity_name}/Types/{entity_name}ListOrderEnumType.php 
To set properties you may want to order by.

#### /app/GraphQL/{entity_name}/Types/{entity_name}Type.php 
To set the properties of your new entity.

#### /app/GraphQL/{entity_name}/Types/{entity_name}UpdateInputType.php 
To set all the input properties for updating an existing object.

#### /app/GraphQL/{entity_name}/Types/{entity_name}Helper.php 
To modify the addWhereToQuery and addOrderToQuery function in order to filter and order lists.

## Lastly
edit:
#### /config/graphql.php
and add: 'App\GraphQL\\{entity_name}\\{entity_name}Exporter.php' to the $exporters array then cache your config as demonstrated above.


#### Note
if you wish to use the --mutations and or the --lists options the entity name must corospond with the name of an Eloquent object




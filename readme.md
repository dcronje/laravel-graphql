# Laravel GraphQL Demo

### Tech Stack

* [Laravel] - PHP MVC Framework
* [GraphQL] - GraphQL Library
* [Docker] - Container deployment and development system

# Getting Started

### (1): Clone the repo
```sh
git clone ssh://git@gitlab.cg.sih.services:222/compare-guru/laravel-graphql-web.git
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

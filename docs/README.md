# Shorti

[![Buy me a coffee](https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png)](https://www.buymeacoffee.com/nicklog)

[![Docker Build](https://img.shields.io/docker/cloud/build/nicklog/shorti.svg?style=flat-square&logo=docker)](https://hub.docker.com/r/nicklog/shorti)
[![License](https://img.shields.io/github/license/nicklog/shorti.svg?style=flat-square&logo=license)](https://github.com/nicklog/shorti)


##  Requirements

* **Docker**

##  Installation

Create a `docker-compose.yml` file in an empty directory.

```yaml
version: '3.6'

services:
  app:
    image: nicklog/shorti:latest
    environment:
      - TZ=Europe/Berlin
      - DATABASE_NAME=shorti
      - DATABASE_USER=shorti
      - DATABASE_PASSWORD=shorti
      - DATABASE_HOST=database
      - DATABASE_PORT=3306
    depends_on:
      - database
    networks:
      - default
    ports:
      - "9000:80"

  database:
    image: mariadb:latest
    environment:
      - MYSQL_DATABASE=shorti
      - MYSQL_USER=shorti
      - MYSQL_PASSWORD=shorti
      - MYSQL_ROOT_PASSWORD=shorti
    networks:
      - default
```
Change any settings to your needs and then run simply `docker-compose up -d`.  
You should now be able to access the site under port `9000` or the port you set.

With this example setup the website is not secured by https.  
When you want to secure it I suggest to use a reverse proxy.

## User

On first call of the website you can create a user. Create one and then login.  
The first user becomes an admin and can create more user if necessary.

##  Update

Just update the docker image with...
```bash
docker-compose pull
docker-compose up -d
```

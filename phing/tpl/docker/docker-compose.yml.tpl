version: '2'
services:
    %%container.name%%_api_php:
        build: docker/images/php
        volumes:
            - ./docker/config/apache2:/etc/apache2/sites-enabled
            - ./docker/config/php/custom.ini:/usr/local/etc/php/conf.d/custom.ini
            - ./:/var/www/html
        container_name: %%container.name%%-api_php
        ports:
            - %%apache.port%%:80
        networks:
            - vpcbr
        privileged: true
        environment:
            - APP_ENV=develop
            - SET_CONTAINER_TIMEZONE=true
            - CONTAINER_TIMEZONE=Europe/Paris
        networks:
            - vpcbr
    %%container.name%%_api_db:
        image: mysql
        container_name: %%container.name%%-api_db
        ports:
            - %%mysql.port%%:3306
        networks:
            - vpcbr
        environment:
            - MYSQL_USER=%%mysql.user%%
            - MYSQL_ROOT_PASSWORD=%%mysql.password%%
            - MYSQL_DATABASE=%%mysql.db.name%%
        volumes:
            - ./docker/data/db:/var/lib/mysql

networks:
  vpcbr:
    external:
      name: vpcbr

###############################################################################
#                          Generated on phpdocker.io                          #
###############################################################################
version: "3.1"
services:

    redis:
      image: redis:alpine
      container_name: [@!project-name!@]-redis

    mysql:
      image: mysql:5.7
      container_name: [@!project-name!@]-mysql
      working_dir: /application
      volumes:
        - .:/application
      environment:
        - MYSQL_ROOT_PASSWORD=qwe
        - MYSQL_DATABASE=[@!project-name!@]
        - MYSQL_USER=[@!project-name!@]
        - MYSQL_PASSWORD=qwe
      ports:
        - "8002:3306"

    webserver:
      image: nginx:alpine
      container_name: [@!project-name!@]-webserver
      working_dir: /application
      volumes:
          - ./src-[@!project-name!@]:/application
          - ./phpdocker/nginx/nginx.conf:/etc/nginx/conf.d/default.conf
      ports:
       - "8000:80"

    php-fpm:
      build: phpdocker/php-fpm
      container_name: [@!project-name!@]-php-fpm
      working_dir: /application
      volumes:
        - ./src-[@!project-name!@]:/application
        - ./phpdocker/php-fpm/php-ini-overrides.ini:/etc/php/7.3/fpm/conf.d/99-overrides.ini

    phpmyadmin:
      image: phpmyadmin/phpmyadmin:latest
      container_name: [@!project-name!@]-phpmyadmin
      environment:
          PMA_HOST: [@!project-name!@]-mysql
          PMA_PORT: 3306
          PMA_ARBITRARY: 1
      ports:
        - '8005:80'
      volumes: 
        - ./sessions


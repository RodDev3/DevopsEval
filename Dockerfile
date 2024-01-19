FROM php:8.1-apache

COPY . /var/www/html

FROM mysql:latest AS database_builder

ENV MYSQL_ROOT_PASSWORD=root_password
ENV MYSQL_DATABASE=movie_database
ENV MYSQL_USER=db_user
ENV MYSQL_PASSWORD=db_password

COPY database/database.sql /docker-database/

EXPOSE 80
FROM composer:latest

WORKDIR /var/www/tempmail/

ENTRYPOINT ["composer", "--ignore-platform-reqs"]

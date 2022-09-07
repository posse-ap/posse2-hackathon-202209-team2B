FROM php:7.4.7-fpm
WORKDIR /var/www/html
RUN apt-get update \
  && docker-php-ext-install pdo_mysql
COPY --from=builder /go/src/github.com/mailhog/mhsendmail/mhsendmail /usr/local/bin/
RUN chmod +x /usr/local/bin/mhsendmail \
    && echo 'sendmail_path = "/usr/local/bin/mhsendmail --smtp-addr=mail:1025"' > /usr/local/etc/php/conf.d/sendmail.ini
COPY ./php.ini /usr/local/etc/php/

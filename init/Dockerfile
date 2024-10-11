FROM wordpress:php8.1-apache
RUN apt-get update
RUN apt-get install ssl-cert
RUN a2enmod ssl && a2ensite default-ssl
RUN make-ssl-cert generate-default-snakeoil
# COPY ssl-cert-snakeoil.key /etc/ssl/private/ssl-cert-snakeoil.key
# COPY ssl-cert-snakeoil.pem /etc/ssl/certs/ssl-cert-snakeoil.pem
WORKDIR /var/www/html

EXPOSE 8001


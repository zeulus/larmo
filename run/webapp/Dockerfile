FROM debian:jessie
MAINTAINER Marcin Wójcik <mwojcik@future-processing.com>

ENV DEBIAN_FRONTEND noninteractive

# Install base packages
RUN apt-get update && \
    apt-get -y install \
        curl \
        apache2 \
        git \
        nodejs \
        npm

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

WORKDIR /var/www/html
RUN npm install -g bower

EXPOSE 80

CMD ["apache2ctl", "-DFOREGROUND"]
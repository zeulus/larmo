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

# npm packages require "node" command to exist and be the nodejs
RUN update-alternatives --install /usr/bin/node node /usr/bin/nodejs 10

WORKDIR /var/www/html
RUN npm install -g bower

COPY entrypoint.sh /
RUN chmod a+x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 80

CMD ["apache2ctl", "-DFOREGROUND"]
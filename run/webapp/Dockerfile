FROM node:0.10.38
MAINTAINER Marcin Wójcik <mwojcik@future-processing.com>, Mateusz Książek <mksiazek@future-processing.com>

RUN apt-get update && apt-get install -y ruby
RUN gem install sass

EXPOSE 8080

CMD [ "bash","-c", "npm install; npm start" ]

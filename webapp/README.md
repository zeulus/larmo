# Larmo - Web Application

Web application for presenting stored messages from *Larmo Hub*. Powered by node.js

## Supported features

* displaying latest messages

## Installation guide

#### Requires for development
- *node.js*
- *npm*
- *ruby* with *sass gem*

### 1. Install dependencies by npm
Run in your console command ```npm install``` and wait to install all required dependencies.

### 2. Run application
Starting application is very easy, if you don't want use any settings you can run command: ```npm start``` or ```node index.js``` 
and go to site *localhost:8080* in your browser

If you want run application with your settings then you'll set environment variables before.

Available environment variables:

- ```PORT``` - set port (default 8080)
- ```MODE_ENV``` - set mode *production* or *dev* (default dev)
- ```API_URL``` - set Larmo Hub API URL (default is localhost:port)

Easy way to run application with environment variables:

```PORT=8000 API_URL=http://your-hub-site.com node index.js```

## Authors

* [Adrian Piętka](mailto:apietka@future-processing.com)
* [Mateusz Książek](mailto:mksiazek@future-processing.com)
# Larmo - Web Application

Web application for presenting stored messages from *Larmo Hub*.

## Supported features

* displaying latest messages
* filter messages by source

## Installation guide

### 1. Install dependencies by Bower

```bash
$: bower install
```

### 2. Setup configuration

Change url to API in configuration file (/src/config.js).

```js
app.constant("config", {
    "api" : {
        "useMock": true, # use static data from JSON files (localized in /data directory)
        "url": "http://path.to/api" # example: http://larmo.org/api
    }
});
```

### 3. Run application

Publish source of application on web server (Apache, nginx). Thats all!

## Authors

* [Adrian Piętka](mailto:apietka@future-processing.com)
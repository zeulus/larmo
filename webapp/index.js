var express = require('express'),
    app = express();

app.use(express.static(__dirname));
app.set('view engine', 'ejs');

var port = process.env.PORT || 8080;
var config = {
    apiUrl: process.env.API_URL || 'localhost:' + port,
    useMock: process.env.USE_MOCK || true,
    mode: process.env.MODE || 'dev'
};

app.get('/', function(req, res) {
    res.render('index', { config: JSON.stringify(config) });
});

var server = app.listen(port);

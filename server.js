var http = require('http');
var fs = require('fs');
var app = require('express');

var express = express();

/*
 * req : infos envoyé du client
 * res : retour su serveur
 */

// Chargement du fichier index.html affiché au client

var server = http.createServer(function(req, res) {
    fs.readFile('./index.html', 'utf-8', function(error, content) {
        res.writeHead(200, {"Content-Type": "text/html"});
        res.end(content);
    });

});
/*
var index = function index(req, res){
    res.setHeader('Content-Type','text/plain');
    res.end("Yolo");
}

express.get('/', index(req, res));
*/

// Chargement de socket.io

var io = require('socket.io').listen(server);

// Quand un client se connecte, on le note dans la console

io.sockets.on('connection', function (socket) {
    console.log('Un client est  !');
});


server.listen(8080);
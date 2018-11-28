var express = require('express');
var fs = require('fs');
var request = require('request');
var cheerio = require('cheerio');
var serveStatic = require('serve-static');
var exec = require("child_process").exec;

var app     = express();

app.use(express.static('resources/'));

app.get('/admin', function(req, res){
  exec("php resources/php/index.php", function (error, stdout, stderr) {
    res.send(stdout);
  });
});

app.get('/presentation', function(req, res){
  var id = req.query['id'];

  if(id)
  {
    exec("php resources/php/presentation.php " + id, function (error, stdout, stderr) {
      res.send(stdout);
    });
  }
});

app.get('/slide', function(req, res){
  var id = req.query['id'];

  if(id)
  {
    exec("php resources/php/slide.php " + id, function (error, stdout, stderr) {
      res.send(stdout);
    });
  }
});

app.get("/client", function(req, res){
  exec("php php/index.php", function (error, stdout, stderr) {
    res.send(stdout);
  });
});

app.get("/ajax-slide", function(req, res){
  var action = req.query['action'];
  var id = req.query['id'];
  var main = req.query['main'];

  if(id && action && main)
  {
    exec("php resources/php/ajax/ajax-slide.php " + action + " " + id + " " + main, function(error, stdout, stderr){
      res.send(stdout);
    });
  }
});

app.use("/slides", express.static('resources/php/slides'));

// app.get("/", function(req, res){
//   var request = req.query.req;
//
//   if(!request){
//     console.log("request not received");
//     return false;
//   }
//
//   console.log("request received");
//
//   console.log("req: " + request);
//
//   res.send("log");
//
// })


app.listen('8081');
console.log('Magic happens on port 8081');
exports = module.exports = app;

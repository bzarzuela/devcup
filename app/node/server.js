var app = require('express').createServer()
  , io = require('socket.io').listen(app);

io.set('log level', 0);

if (process.argv[2] == undefined) {
  app.listen(8081);
  console.log('listening at 8081');
} else {
  app.listen(process.argv[2]);
  console.log('listening at ' + process.argv[2]);
}


io.sockets.on('connection', function(socket) {
  socket.on('join room', function(room) {
    socket.join(room);
  });
});

// Sends all of the querystring parameters to the channel_message as a JSON object.
app.get('/send/:room', function (req, res) {
  io.sockets.in(req.params.room).emit('message', req.query);
  res.send('ok');
});

app.get('/send/:room/:event', function (req, res) {
  io.sockets.in(req.params.room).emit(req.params.event, req.query);
  res.send('ok');
});
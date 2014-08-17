http = require 'http'
sockjs = require 'sockjs'
express = require 'express'

app = sockjs.createServer()

rooms = {
  global: []
}

conns = {}
agents = {}
supervisor = {}

joinRoom = (room, conn, see_whisper = false) ->
  console.log see_whisper
  conn.canSeeWhisper = see_whisper
  console.log conn.canSeeWhisper
  console.log 'Room: ', room

  if not rooms[room]
    console.log 'init room'
    rooms[room] = {}

  if not conns[conn.id]
    console.log 'init conn'
    conns[conn.id] = {}

  conns[conn.id][room] = room
  rooms[room][conn.id] = conn
  # rooms['global'][conn.id] = conn
  console.log(conn.id, ' joined room: ', room)

sendWhisper = (room, data) ->
  if not rooms[room]
    return console.log 'Invalid Room: ', room

  for id, conn of rooms[room]
    console.log 'Checking for whisper: ', id
    if conn.canSeeWhisper
      conn.write JSON.stringify data
    else
      console.log 'Cannot see whisper', id

sendMessage = (room, data) ->
  if not rooms[room]
    return console.log 'Invalid Room: ', room

  for id, conn of rooms[room]
    console.log 'Writing to: ', id
    conn.write(JSON.stringify(data))

  # for id, conn of rooms['global']
  #   console.log 'Global Message to: ', id
  #   conn.write(message)

whisper = (room, message) ->
  if not rooms[room]
    return console.log 'Invalid Room: ', room

  for id, conn of rooms[room]
    if conn.canSeeWhisper
      console.log 'Whispering to: ', id
      conn.write(message)

  # for id, conn of rooms['global']
  #   if conn.canSeeWhisper
  #     console.log 'Global Whisper to: ', id
  #     conn.write(message)

app.on 'connection', (conn)->
  conn.on 'data', (data) ->
    try
      data = JSON.parse(data)
    catch e
      return console.log(data, 'is not json')

    switch data.type
      when 'join' then joinRoom(data.payload, conn, data.see_whisper)
      when 'message' then sendMessage(data.room, data)
      when 'whisper' then whisper(data.room, data.payload)
      when 'online'
        if data.access == 'supervisor'
          console.log 'Supervisor going online: ', conn.id
          supervisor[conn.id] = conn
          conn.write JSON.stringify
            type: 'online'
            conn_id: conn.id
        else 
          console.log 'Agent going online: ', conn.id
          agents[conn.id] = conn
          conn.write JSON.stringify
            type: 'online'
            conn_id: conn.id
      when 'offline'
        console.log 'Agent signing out: ', conn.id
        delete agents[conn.id]
        conn.write JSON.stringify
          type: 'offline'
          conn_id: 'Not Ready'

  conn.on 'close', ->
    for room of conns[conn.id]
      if rooms[room][conn.id]
        console.log conn.id, ' leaving room: ', room
        delete rooms[room][conn.id]

    # if rooms['global'][conn.id]
    #   console.log conn.id, ' removing from global room'
    #   delete rooms['global'][conn.id]

    if conns[conn.id]
      console.log conn.id, ' removing from global conns'
      delete conns[conn.id]

    if agents[conn.id]
      console.log conn.id, ' removing from global agents'
      delete agents[conn.id]

server = express.createServer()
server.use(express.bodyParser())

app.installHandlers server,
  prefix: '/sockjs'

server.post '/chatty/send', (req, res) ->
  data = JSON.parse(req.body.json)
  sendMessage(data.room, data)
  res.send 'ok'

server.post '/chatty/whisper', (req, res) ->
  data = JSON.parse(req.body.json)
  sendWhisper(data.room, data)
  res.send 'ok'

server.get '/chatty/popup/:conn_id/:room/:ref/:name', (req, res) ->
  console.log 'Popup Request: ', req.params.conn_id, req.params.room
  conn_id = req.params.conn_id
  if agents[conn_id] is undefined
    console.log 'No agent available'
    res.send JSON.stringify
      success: false
      message: 'No agent available'
  else
    console.log 'Sending popup message'
    agents[conn_id].write JSON.stringify
      type: 'popup'
      room: req.params.room
      ref: req.params.ref
      name: req.params.name
    res.send JSON.stringify
      success: true
      name: req.params.name

server.get '/chatty/popup-supervisor/:conn_id/:room/:ref/:name', (req, res) ->
  console.log 'Popup Request for Supervisor: ', req.params.conn_id, req.params.room
  conn_id = req.params.conn_id
  if supervisor[conn_id] is undefined
    console.log 'No Supervisor available'
  else
    console.log 'Sending popup message to supervisor'
    supervisor[conn_id].write JSON.stringify
      type: 'popup'
      room: req.params.room
      ref: req.params.ref
      name: req.params.name
    res.send JSON.stringify
      success: true
      name: req.params.name

if (process.argv[2] == undefined)
  server.listen 8081, '0.0.0.0'
  console.log('listening at 8081')
else
  server.listen process.argv[2], '0.0.0.0'
  console.log('listening at ' + process.argv[2])
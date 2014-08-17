class ChatBot
  constructor: (@endpoint, @room) ->
    this.connect()

  connect: () =>
    @sock = new SockJS(@endpoint);

    @sock.onopen = =>
      console.log 'Clearing interval for reconnect', @interval
      clearInterval(@interval)
      @interval = undefined
      console.log 'Cleared Interval: ', @interval
      this.join(@room)

    @sock.onmessage = (e) =>
      if @onMessageCallback isnt undefined
        console.log 'Calling callback: ', e.data
        @onMessageCallback(JSON.parse(e.data))
      else
        console.log 'Not calling callback'

    @sock.onclose = =>
      if @interval is undefined
        console.log 'Setting interval for reconnect'
        @interval = setInterval(this.connect, 2000)
        console.log 'Interval: ', @interval

      if @onDisconnectCallback isnt undefined
        console.log 'Calling disconnect callback '
        @onDisconnectCallback()

  join: (room) ->
    console.log 'Joining: ', room
    @sock.send JSON.stringify
      type: 'join'
      payload: room

    if @onConnectCallback isnt undefined
      console.log 'Calling connect callback '
      @onConnectCallback()

  onMessage: (callback)->
    console.log 'Defining callback'
    @onMessageCallback = callback

  onDisconnect: (callback)->
    @onDisconnectCallback = callback

  onConnect: (callback)->
    @onConnectCallback = callback
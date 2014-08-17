jQuery ->
  bot = new ChatBot('http://localhost:8081/sockjs', channel)

  bot.onMessage (data) ->
    console.log data
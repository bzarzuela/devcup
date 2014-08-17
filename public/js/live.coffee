jQuery ->
  bot = new ChatBot('http://localhost:8081/sockjs', channel)

  bot.onMessage (data) ->
    if data.sender == 'tweet'
      $('#tweet').text(data.message)

    if data.sender == 'sentiment'
      $('#sentiment').text(data.message).removeClass().addClass(data.message)

    if data.sender == 'mover'
      $('#mover').text(data.message)

    if data.sender == 'pay'
      $('#pay').show()
      $('#everything').hide()

    if data.sender == 'progress'
      $('#progress').text(data.message)
      if parseInt($('#progress').text()) >= parseInt($('#target').text())
        $('#pay').show()
        $('#everything').hide()

    if data.sender == 'reset'
      $('#mover').html('&nbsp;')
      $('#sentiment').html('&nbsp;').removeClass()
      $('#tweet').text('Please wait...')
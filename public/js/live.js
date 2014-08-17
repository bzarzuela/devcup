// Generated by CoffeeScript 1.6.3
jQuery(function() {
  var bot;
  bot = new ChatBot('http://localhost:8081/sockjs', channel);
  return bot.onMessage(function(data) {
    if (data.sender === 'tweet') {
      $('#tweet').text(data.message);
    }
    if (data.sender === 'sentiment') {
      $('#sentiment').text(data.message).removeClass().addClass(data.message);
    }
    if (data.sender === 'mover') {
      $('#mover').text(data.message);
    }
    if (data.sender === 'pay') {
      $('#pay').show();
    }
    if (data.sender === 'progress') {
      $('#progress').text(data.message);
      if (parseInt($('#progress').text()) >= parseInt($('#target').text())) {
        $('#pay').show();
      }
    }
    if (data.sender === 'reset') {
      $('#mover').html('&nbsp;');
      $('#sentiment').html('&nbsp;').removeClass();
      return $('#tweet').text('Please wait...');
    }
  });
});

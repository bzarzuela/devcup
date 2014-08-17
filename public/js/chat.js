// Generated by CoffeeScript 1.6.3
var ChatBot,
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

ChatBot = (function() {
  function ChatBot(endpoint, room) {
    this.endpoint = endpoint;
    this.room = room;
    this.connect = __bind(this.connect, this);
    this.connect();
  }

  ChatBot.prototype.connect = function() {
    var _this = this;
    this.sock = new SockJS(this.endpoint);
    this.sock.onopen = function() {
      console.log('Clearing interval for reconnect', _this.interval);
      clearInterval(_this.interval);
      _this.interval = void 0;
      console.log('Cleared Interval: ', _this.interval);
      return _this.join(_this.room);
    };
    this.sock.onmessage = function(e) {
      if (_this.onMessageCallback !== void 0) {
        console.log('Calling callback: ', e.data);
        return _this.onMessageCallback(JSON.parse(e.data));
      } else {
        return console.log('Not calling callback');
      }
    };
    return this.sock.onclose = function() {
      if (_this.interval === void 0) {
        console.log('Setting interval for reconnect');
        _this.interval = setInterval(_this.connect, 2000);
        console.log('Interval: ', _this.interval);
      }
      if (_this.onDisconnectCallback !== void 0) {
        console.log('Calling disconnect callback ');
        return _this.onDisconnectCallback();
      }
    };
  };

  ChatBot.prototype.join = function(room) {
    console.log('Joining: ', room);
    this.sock.send(JSON.stringify({
      type: 'join',
      payload: room
    }));
    if (this.onConnectCallback !== void 0) {
      console.log('Calling connect callback ');
      return this.onConnectCallback();
    }
  };

  ChatBot.prototype.onMessage = function(callback) {
    console.log('Defining callback');
    return this.onMessageCallback = callback;
  };

  ChatBot.prototype.onDisconnect = function(callback) {
    return this.onDisconnectCallback = callback;
  };

  ChatBot.prototype.onConnect = function(callback) {
    return this.onConnectCallback = callback;
  };

  return ChatBot;

})();

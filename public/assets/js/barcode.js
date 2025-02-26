var barcode = {
  instance: null,
  scan: function(options) {
    var $viewport = $('.viewport');
    if (!$viewport.find('video').length) {
      $viewport.append('<video src=""></video>');
    }

    var options = $.extend({
      video: $viewport.find('video').get(0),
      mirror: true,
      onDetected: function() {
        console.log('Detected!', arguments);
      }
    }, options);
    var scanner = new Instascan.Scanner(options);
    this.instance = scanner;

    Instascan.Camera.getCameras()
    .then(function (cameras) {
      if (!cameras.length) throw new Error('No cameras found.');

      return scanner.start(cameras[0]);
    })
    .then(function () {
      if (typeof options.onStarted == 'function') {
        options.onStarted();
      }
    })
    .catch(function (e) {
      if (typeof options.onInitializeFailed == 'function') {
        options.onInitializeFailed(e);
      }
    });

    scanner.addListener('scan', options.onDetected)
  },

  stop: function() {
    var self = this;
    if (this.instance) {
      this.instance.stop().then(function() {
        self.instance = null;
      });
    }
  }
}

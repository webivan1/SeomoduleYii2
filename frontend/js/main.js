$(function () {

  var connect = function() {
    this.url = '/seomodule/default/get-connect?alias={alias}';
    this.selector = 'select[name="ConfigMetaData[connect]"]';
    this.gridData = '.grid-connect-keys';
    this.init();
  };

  connect.prototype = {
    init: function() {
      var el = $(this.selector);
      var gridData = $(this.gridData);

      if (el.val() !== '') {
        this.getConnect(el.val());
      }

      var self = this;

      el.on('change', function() {
        var elChange = $(this);
        if (elChange.val() === '') {
          gridData.html('');
        } else {
          self.getConnect(elChange.val());
        }
      });
    },

    getConnect: function(name) {
      $.get(this.url.replace('{alias}', name), function(response) {
        $(this.gridData).html(response);
      }.bind(this));
    }
  };

  new connect();

  $('.js-add-object').on('click', function () {
    var container = $('.js-clone-container');
    var item = container.find('.js-clone-item:first-child');
    var clone = item.clone();

    clone.find('input, textarea').val('');

    container.append(clone);
  });

});
function runConnect(elem) {
  if (elem.hasAttribute('disabled')) {
    return false;
  }

  elem.setAttribute('disabled', 'disabled');

  $.getJSON(elem.getAttribute('data-url'), function (response) {
    elem.removeAttribute('disabled');

    $.pjax.reload({ container: '#grid-yii' });
  });

  return false;
}
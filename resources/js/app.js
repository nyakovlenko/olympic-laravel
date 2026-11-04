import $ from 'jquery';
import * as bootstrap from 'bootstrap';

window.$ = window.jQuery = $;

$(function () {
  // тост при нажатии на «Загрузить»
  const toastEl = $('#liveToast')[0];
  if (!toastEl) return;

  const toast = new bootstrap.Toast(toastEl);

  $('.btn-load').on('click', function () {
    $('#toastYear').text($(this).data('year'));
    toast.show();
  });
});

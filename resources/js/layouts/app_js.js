$(document).ready(function () {
  $('#open-sidebar').on('click', function () {
    $('#sidebar').removeClass('-translate-x-full');
  });
  $('#close-sidebar').on('click', function () {
    $('#sidebar').addClass('-translate-x-full');
  });
});
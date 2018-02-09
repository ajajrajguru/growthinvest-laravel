(function() {
  $(document).ready(function() {});

  $('body').on('click', '.toggle-password', function() {
    $('.toggle-password .fa').toggleClass('fa-eye fa-eye-slash');
    if ($('#password').attr('psswd-shown') === 'false') {
      $('#password').removeAttr('type');
      $('#password').attr('type', 'text');
      $('#password').removeAttr('psswd-shown');
      $('#password').attr('psswd-shown', 'true');
    } else {
      $('#password').removeAttr('type');
      $('#password').attr('type', 'password');
      $('#password').removeAttr('psswd-shown');
      $('#password').attr('psswd-shown', 'false');
    }
  });

  return;

}).call(this);

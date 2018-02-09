
$(document).ready ->

#show-hide password
$('body').on 'click', '.toggle-password', ->
	$('.toggle-password .fa').toggleClass 'fa-eye fa-eye-slash'
	if $('#password').attr('psswd-shown') is 'false'
		$('#password').removeAttr 'type'
		$('#password').attr 'type', 'text'
		$('#password').removeAttr 'psswd-shown'
		$('#password').attr 'psswd-shown', 'true'
	else
		$('#password').removeAttr 'type'
		$('#password').attr 'type', 'password'
		$('#password').removeAttr 'psswd-shown'
		$('#password').attr 'psswd-shown', 'false'
	return
return
function passwords_match()
{
	pass = document.querySelectorAll("input[name='pass']")[0].value;
	pass_confirm = document.querySelectorAll("input[name='pass_confirm']")[0].value;
	if (pass != pass_confirm)
	{
		document.querySelector("div[class='answer']").textContent = "Passwords don't match!";
		return False;
	}
	return True;
}

function check_password_complexity()
{
	pass = document.querySelectorAll("input[name='pass']")[0].value;
	login = document.querySelectorAll("input[name='login']")[0].value;
	if (pass.length < 6)
		return False;
	if (pass.indexOf(login) != -1)
		return False;
}

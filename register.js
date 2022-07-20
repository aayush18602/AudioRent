function formsubmit(){
    const username = document.forms['logform']['username'];
    const email = document.forms['logform']['email'];
    const password = document.forms['logform']['password'];    
    const password2 = document.forms['logform']['password2'];

    if(username.value == "")
    {
      alert("Please fill your username!!");
      username.focus();
      return false;
    }
    const expression = /^([a-zA-Z0-9\.-]+)@([a-zA-Z0-9-]+).([a-z]{2,20})$/;
    if(!email.value.match(expression))
    {
      alert("Email in Invalid format!!");
      email.focus();
      return false;
    }
    if(password.value == "")
    {
      alert("Please fill your password!!");
      password.focus();
      return false;
    }
    if(password2.value == "")
    {
      alert("Please fill both the password!!");
      password2.focus();
      return false;
    }

    if(password.value.length < 8)
    {
        alert("Password length should be greater than 8")
        password.focus();
        return false;
    }
    const strr = password.value;
    if(!(strr.match(/[a-z]/) && strr.match(/[A-Z]/) && strr.match(/[0-9]/)))
    {
      alert("Password does not match criteria!!");
      password.focus();
      return false;
    }
    if(password.value != password2.value)
    {
        alert("Both passwords should get matched!!");
        return false;
    }
    
    return true;
  }

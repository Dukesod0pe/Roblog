let fname = document.getElementById("fname_T");
fname.addEventListener("blur", fNameHandler_T);

let lname = document.getElementById("lname_T");
lname.addEventListener("blur", lNameHandler_T);

let dob = document.getElementById("dob_T");
dob.addEventListener("blur", dobHandler_T);

let email = document.getElementById("email_T");
email.addEventListener("blur", emailHandler_T);

let uname = document.getElementById("uname_T");
uname.addEventListener("blur", unameHandler_T);

let pwd = document.getElementById("pwd_T");
pwd.addEventListener("blur", pwdHandler_T);


let cpwd = document.getElementById("confirmpwd_T");
cpwd.addEventListener("blur", cpwdHandler_T);

let avatar = document.getElementById("pfp_T");
avatar.addEventListener("blur", avatarHandler_T);

let submitButton = document.getElementById("submitButton_T");
submitButton.addEventListener("click", validateSignup_T);

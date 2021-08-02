var registerButton = document.getElementById("registerButton");
var cancelButton= document.getElementById("cancelReg");
var passInput = document.getElementById("pass");
var passCheck= document.getElementById("passCheck");
var upperCheck =document.getElementById("upperCheck");
var numberCheck=document.getElementById("numberCheck");
var lengthCheck=document.getElementById("lengthCheck");
var symbolCheck=document.getElementById("symbolCheck");
var confirmButton = document.getElementById("confReg");
var comparePass=document.getElementById("confpass");
var makeActive=false;
confirmButton.disabled=true;

console.log(comparePass);


if(registerButton!=null)
{
registerButton.onclick=function()
{
  document.getElementById("modalBG").style.visibility="visible";
  document.getElementById("modalBG").style.opacity="100%";
  document.getElementById("modal").style.visibility="visible";
  document.getElementById("modal").style.opacity="100%";
};
}

if(cancelButton!=null)
{
cancelButton.onclick=function()
{
  document.getElementById("modalBG").style.visibility="hidden";
  document.getElementById("modalBG").style.opacity="0%";
  document.getElementById("modal").style.visibility="hidden";
  document.getElementById("modal").style.opacity="0%";
};
}
pass.onkeyup=checkPassword;

function checkPassword()
{
  passCheck.style.opacity="100%";
  var up=false;
  var num=false;
  var sym=false;
  var lngth=false;



  var upercase= /[A-Z]/g;
  var numbers = /[0-9]/g;
  var symbols=/[!@#$%^&*()-=_+]/g;

  if(numbers.test(pass.value))
  {

    numberCheck.style.color="#008000";
    num=true;

  }
  else
  {
    numberCheck.style.color="#ff6666";
    num=false;
  }


  if(upercase.test(pass.value))
  {
    upperCheck.style.color="#008000";
    up=true;
  }
  else
  {
    upperCheck.style.color="#ff6666";
    up=false;
  }





  if(symbols.test(pass.value))
  {

    symbolCheck.style.color="#008000";
    sym=true;
  }
  else
  {
    symbolCheck.style.color="#ff6666";
    sym=false;
  }


  if(pass.value.length>=8)
  {
    lengthCheck.style.color="#008000";
    lngth=true;
  }
  else
  {
    lengthCheck.style.color="#ff6666";
    lngth=false;
  }


  if(lngth && sym && up && num && comparePass==null)
  {
    confirmButton.disabled=false;
  }
  else if(lngth && sym && up && num &&comparePass!=null)
  {
    makeActive=true;
  }
  else 
  {
    confirmButton.disabled=true;
  }



}



if(comparePass!=null)
{

  confpass.onkeyup=ComparePasswords;

  let confText= document.getElementById("passText");

  function ComparePasswords()
  {

    if(pass.value==confpass.value && makeActive)
    {
      confText.style.opacity="0%";
      confirmButton.disabled=false;
    }
    else
    {
      confText.style.opacity="100%";
      confirmButton.disabled=true;
    }

  }

}

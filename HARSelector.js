document.getElementById("submitButton").addEventListener("click",open);
document.getElementById("optionsBtn").addEventListener("click",OptionsReveal);








function open()
{
document.getElementById("inputBtn").click();
document.getElementById('inputBtn').addEventListener('change', submitForm);
}

function submitForm()
{


  document.getElementById("harNameWrite").textContent='Έχετε επιλέξει το αρχέιο ' + document.getElementById("inputBtn").value ;
}

function OptionsReveal()
{
  document.getElementById("optionsPanel").style.opacity="100%";
}



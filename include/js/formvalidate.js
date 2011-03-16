// JavaScript Document
function validateForm()
{
 var okSoFar=true
 with (document.phpformmailer)
 {
  var foundAt = email.value.indexOf("@",0)
  if (foundAt < 1 && okSoFar)
  {
    okSoFar = false
    alert ("Vul aub een e-mail adres in.")
    email.focus()
  }
  /*
  var e1 = email.value
  var e2 = email2.value
  if (!(e1==e2) && okSoFar) 
  {
    okSoFar = false
    alert ("Email addresses you entered do not match.  Please re-enter.")
    email.focus()
  } */
  if (thesubject.value=="" && okSoFar)
  {
    okSoFar=false
    alert("Vul aub een onderwerp in.")
    thesubject.focus()
  }
  if (themessage.value=="" && okSoFar)
  {
    okSoFar=false
    alert("Vul aub een opmerking in.")
    themessage.focus()
  }
  if (okSoFar==true)  submit();
 }
}

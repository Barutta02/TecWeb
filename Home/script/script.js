<<<<<<< Updated upstream
=======

var toggleMenu = document.getElementById('mobile-menu-toggle');

/*
toggleMenu.addEventListener('click', function() {toggleMenu.checked = !toggleMenu.checked; console.log("click")});
toggleMenu.addEventListener('focus', function() {
  console.log("Focus");
  toggleMenu.checked = true;
});
*/

>>>>>>> Stashed changes
function addCheckboxListeners() {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
      var className = checkbox.id.replace("Chbox", "");
      document.querySelectorAll("." + className).forEach(function (element) {
        element.classList.toggle("hide", checkbox.checked);
      });
    });
  });
}
addCheckboxListeners();

// Funzione per ottenere la dimensione del file
function getFileSize(url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.open("HEAD", url, true);
  xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
          var size = xhr.getResponseHeader("Content-Length");
          callback(size);
      }
  };
  xhr.send();
}

// Funzione per aggiornare il link con la dimensione del file
function updateLinkWithSize(url, linkId) {
  getFileSize(url, function(size) {
      const sizeInMB = (size / 1048576).toFixed(2);
      const link = document.getElementById(linkId);
      // Crea un nuovo elemento <p> con la dimensione del file
      const sizeP = document.createElement('p');
      sizeP.classList.add('downloadSize');
      sizeP.innerHTML = (" (Dimensione: " + sizeInMB + " MB)");
      // Inserisci la dimensione del file dopo il link
      const parentNode = link.parentNode;
      const insertBeforeElement = link.nextSibling;
      parentNode.insertBefore(sizeP, insertBeforeElement);
  });
}

//Aggiungi la funzione validateInputAfterEvent all'avvenire dell'evento onBlur degli elementi dei form
function addOnBlur(){
  // Recupera gli input e le textarea
  const inputs = document.querySelectorAll('input, textarea');
  inputs.forEach(input => {
      input.addEventListener('blur', validateInputAfterEvent);
  });
}

function validateInputAfterEvent(event) {
  return validateInput(event.target);
}

//Validazione degli input
function validateInput(input) {
  const inputName = input.getAttribute('name');
  const inputValue = input.value;

  if (checks[inputName]) {
      const conditionMet = checks[inputName].condition(inputValue);
      if (!conditionMet) {
          // Rimuovi il tag <p> di errore se presente
          const siblingToRemove = input.nextSibling;
          if (siblingToRemove) {
              siblingToRemove.remove();
          }

          // Crea un nuovo elemento <p> con il messaggio di errore
          const errorElement = document.createElement('p');
          errorElement.classList.add('warning');
          errorElement.innerHTML = checks[inputName].message;

          //imposta il focus e selezione l'input errato
          input.focus();
          input.select();

          // Inserisci il messaggio di errore sotto il campo
          const parentNode = input.parentNode;
          const insertBeforeElement = input.nextSibling;
          parentNode.insertBefore(errorElement, insertBeforeElement);
          return false;
      } else {
          // Il controllo è passato, rimuovi il tag <p> di errore se presente
          const errorSibling = input.nextSibling;
          if (errorSibling) {
              errorSibling.remove();
          }
      }
  }
  return true;
}

//Validazione del form
function validateForm(){
  const inputs = document.querySelectorAll('input, textarea');
  let validInput = true;
  for (let i = 0; i < inputs.length; i++) {
    if(!validateInput(inputs[i])){
      validInput=false;
    }
  }
  return validInput;
}

function setSignInChecks(){
  checks = {
      username:{
          message:"Formato username non corretto, deve contenere almeno 2 caratteri e non può contenere solo spazi!",
          condition: function(str){
              let expr = /\w{2,}/ ;
              return str.trim().length > 0 && expr.test(str);
          }
      },
      firstname:{
          message:"Questo campo non può essere vuoto, non può contenere solo spazi e nemmeno numeri!",
          condition: function(str){
            let expr = /^[^\d]+$/ ;
              return str.trim().length > 0 && expr.test(str);
          }
      },
      lastname:{
          message:"Questo campo non può essere vuoto, non può contenere solo spazi e nemmeno numeri!",
          condition: function(str){
              let expr = /^[^\d]+$/ ;
              return str.trim().length > 0 && expr.test(str);
          }
      },
      email:{
          message:"Formato email non corretto, deve avere questa forma: nomeutente@dominio.estensione!",
          condition: function(str){
              let expr = /^([\w\-\+\.]+)\@([\w\-\+\.]+)\.([\w\-\+\.]+)$/;
              return expr.test(str);
          }
      },
      password:{
          message:"Formato <span lang='en'>password</span> non corretto!",
          condition: function(str){
              return isStrongPassword(str);
          }
      }
  }
}

function isValidLength(password) {
  return password.length >= 5;
}

function hasUpperCase(password) {
  return /[A-Z]/.test(password);
}

function hasLowerCase(password) {
  return /[a-z]/.test(password);
}

function hasNumber(password) {
  return /\d/.test(password);
}

function hasSpecialCharacter(password) {
  return /[!@#$%^&*()_+]/.test(password);
}


function isStrongPassword(password) {
  return (
      isValidLength(password) &&
      hasUpperCase(password) &&
      hasLowerCase(password) &&
      hasNumber(password) &&
      hasSpecialCharacter(password)
  );
}

function setLoginChecks(){
  checks = {
      //utile a ridurre il carico sul server
      username_or_email:{
          message:"Formato username o email non corretto, deve contenere almeno 2 caratteri e non può contenere solo spazi!",
          condition: function(str){
              let expr = /\w{2,}/ ;
              return str.trim().length > 0 && expr.test(str);
          }
      }/*
      tolto perchè altrimenti user e admin hanno password non sicure e non possono entrare. 
      Altrimenti potrebbe essere sensato per ridurre il carico sul server
      ,
      password:{
          message:"Formato <span lang='en'>password</span> non corretto, deve contenere almeno 5 caratteri, inclusi lettere maiuscole e minuscole, numeri e almeno uno dei seguenti caratteri speciali: !@#$%^&*",
          condition: function(str){
              return isStrongPassword(str);
          }
      }*/
  }
}

function setPrenotaScript() {
  // Recupera per gli input 
  const inputsNum = document.querySelectorAll('input[type="number"]');
  inputsNum.forEach(input => {
      input.addEventListener('blur', handleSubmitButton);
  });
  // Recupera i checkbox
  const inputsCheck = document.querySelectorAll('input[type="checkbox"]');
  inputsCheck.forEach(input => {
    input.addEventListener('change', handleSubmitButton);
  });
  handleSubmitButton();
}

//funzione per ridurre il carico sul server nel caso in cui la prenotazione sia vuota
function handleSubmitButton() {
  var submitButton = document.getElementById("submitPrenotazione");
  const inputs = document.querySelectorAll('li:not(.hide) input[type="number"]');
  let validPrenotazione = false;
  for (let i = 0; i < inputs.length && !validPrenotazione; i++) {
    if(inputs[i].value>0){
      validPrenotazione=true;
    }
  }
  // Rimuovi il tag <p> di suggerimento se presente
  const siblingToRemove = submitButton.nextSibling;
  if (siblingToRemove) {
      siblingToRemove.remove();
  }
  if(validPrenotazione){
    submitButton.disabled=false;
    submitButton.classList.remove('disabledButton');
  } else {
    submitButton.disabled=true;
    submitButton.classList.add('disabledButton');
    // Crea un nuovo elemento <p> con il suggerimento
    const instruction = document.createElement('p');
    instruction.classList.add('instruction');
    instruction.innerHTML = "Aggiungi dei piatti all'ordinazione per poter inviare l'ordine";
    const parentNode = submitButton.parentNode;
    const insertBeforeElement = submitButton.nextSibling;
    parentNode.insertBefore(instruction, insertBeforeElement);
  }
  
}
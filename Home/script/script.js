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

function aggiornaConsegna(button) {
  // Recupera i dati direttamente dal pulsante
  var dataOra = button.getAttribute("data-dataOra");
  var idPiatto = button.getAttribute("data-piatto");
  var username = button.getAttribute("data-cliente");

  // Chiamata AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "process/aggiornaStatoConsegna.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log("Stato consegnato aggiornato con successo!");
      button.classList.add("buttonDoneCompleted"); // Aggiungi la classe al pulsante
      button.disabled = true; // Disabilita il pulsante dopo l'aggiornamento
    } else if (xhr.readyState === 4 && xhr.status !== 200) {
      console.error(
        "Errore durante l'aggiornamento dello stato consegnato:",
        xhr.statusText
      );
    }
  };
  var params =
    "idPiatto=" +
    idPiatto +
    "&username=" +
    username +
    "&dataOraOrdine=" +
    dataOra +
    "&nuovoStatoConsegnato=1";
  xhr.send(params);
}

function closePrenotation(button) {
  // Recupera i dati direttamente dal pulsante
  var dataOra = button.getAttribute("data-dataOra");
  var username = button.getAttribute("data-username");

  // Chiamata AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "process/TerminaPrenotazione.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log("Stato consegnato aggiornato con successo!");
      button.classList.add("buttonDoneCompleted"); // Aggiungi la classe al pulsante
      button.disabled = true; // Disabilita il pulsante dopo l'aggiornamento
    } else if (xhr.readyState === 4 && xhr.status !== 200) {
      console.error(
        "Errore durante l'aggiornamento dello stato consegnato:",
        xhr.statusText
      );
    }
  };
  var params = "username=" + username + "&dataOra=" + dataOra;
  xhr.send(params);
}

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

//Aggiungi l'evento onBlur agli elementi dei form
function addOnBlur(){
  // Aggiungi per gli input e le textarea
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
          message:"Formato username non corretto, deve contenere almeno 2 caratteri!",
          condition: function(str){
              let expr = /\w{2,}/ ;
              return expr.test(str);
          }
      },
      firstname:{
        message:"Questo campo non può essere vuoto!",
          condition: function(str){
              return str.length > 0;
          }
      },
      lastname:{
          message:"Questo campo non può essere vuoto!",
          condition: function(str){
              return str.length > 0;
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
      username_or_email:{
          message:"Formato username o email non corretto, deve contenere almeno 2 caratteri!",
          condition: function(str){
              let expr = /\w{2,}/ ;
              return expr.test(str);
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
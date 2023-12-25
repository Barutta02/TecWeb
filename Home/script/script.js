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
  let inputs = document.querySelectorAll('input, textarea');
  inputs.forEach(input => {
      input.addEventListener('blur', validateInput);
  });
}

//Validazione dei form
function validateInput(event) {
  const inputName = event.target.getAttribute('name');
  const inputValue = event.target.value;

  if (checks[inputName]) {
      const conditionMet = checks[inputName].condition(inputValue);
      if (!conditionMet) {
          // Rimuovi il tag <p> di errore se presente
          const siblingToRemove = event.target.nextSibling;
          if (siblingToRemove) {
              siblingToRemove.remove();
          }

          event.target.setAttribute('aria-invalid', 'true');

          // Crea un nuovo elemento <p> con il messaggio di errore
          const errorElement = document.createElement('p');
          errorElement.classList.add('warning');
          errorElement.innerHTML = checks[inputName].message;

          //imposta il focus e selezione l'input errato
          event.target.focus();
          event.target.select();

          // Inserisci il messaggio di errore sotto il campo
          const parentNode = event.target.parentNode;
          const insertBeforeElement = event.target.nextSibling;
          parentNode.insertBefore(errorElement, insertBeforeElement);
      } else {
          // Il controllo è passato, rimuovi il tag <p> di errore se presente
          const errorSibling = event.target.nextSibling;
          if (errorSibling) {
              errorSibling.remove();
          }
          event.target.setAttribute('aria-invalid', 'false');
      }
  }
}

function setSignInChecks(){
  checks = {
      username:{
          message:"Formato username non corretto, deve avere almeno 2 caratteri!",
          condition: function(str){
              let expr = /\w{2,}/ ;
              return expr.test(str);
          }
      },
      password:{
          message:"Formato <span lang='en'>password</span> non corretto!",
          condition: function(str){
              return str.length>=5;
          }
      }
  }

}
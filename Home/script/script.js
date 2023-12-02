function addCheckboxListeners() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", function() {
            var className = checkbox.id.replace("Chbox", "");
            document.querySelectorAll("." + className).forEach(function(element) {
                element.classList.toggle("hide", checkbox.checked);
            });
        });
    });
}
addCheckboxListeners();


document.addEventListener('DOMContentLoaded', function() {
    var mobileMenu = document.getElementById('mobile-menu');
    var navList = document.querySelector('.nav-list');

    mobileMenu.addEventListener('click', function() {
        navList.classList.toggle('show');
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.menu')) {
            navList.classList.remove('show');
        }
    });
});


function aggiornaConsegna(button) {
    // Recupera i dati direttamente dal pulsante
    var dataOra = button.getAttribute('data-dataOra');
    var idPiatto = button.getAttribute('data-piatto');
    var username = button.getAttribute('data-cliente');

    // Chiamata AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'process/aggiornaStatoConsegna.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log('Stato consegnato aggiornato con successo!');
            button.classList.add('buttonDoneCompleted');  // Aggiungi la classe al pulsante
            button.disabled = true;  // Disabilita il pulsante dopo l'aggiornamento

        } else if (xhr.readyState === 4 && xhr.status !== 200) {
            console.error('Errore durante l\'aggiornamento dello stato consegnato:', xhr.statusText);
        }
    };
    var params = 'idPiatto=' + idPiatto + '&username=' + username + '&dataOraOrdine=' + dataOra + '&nuovoStatoConsegnato=1';
    xhr.send(params);
}
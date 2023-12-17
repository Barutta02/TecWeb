<!-- LTeX: language=it -->
# TecWeb
## Descrizione
Creare un applicazione di un ristorante sushi all you can eat che permetta al ristorante di gestire il proprio menù, la quantità di tavoli e posti a sedere. 

L'utente deve poter vedere il menù senza effettuare il login e avere le info di base.
Il menù è diviso in manu pranzo e menù cena, dove il menù cena è il menù pranzo più altri piatti.

Per poter prenotare dal menu deve effettuare la registrazione.
Alla fine di una pasto l'utente può decidere di salvare quanto ha ordinato nel pasto così che un giorno possa tornare e riutilizzare quanto ordinato.
Le bibite e dolci sono esclusi dall all you can eat.
Ogni utente registrato può inserire al più una recensione al ristorante.

Il ristoratore tramite un interfaccia deve poter avere una visualizzazione di tutti i piatti ordinati potendo segnare quelli già fatti e il tavolo a cui devono essere consegnati.

Al termine l'utente deve visualizzare la spesa finale e anche il ristoratore.
Solo al termine di una cena la recensione può essere lasciata.

Inoltre ogni piatto deve mostrare gli allergeni che contiene fornendo all'utente la possibilità di escludere dalla vista i piatti che contengono determinati allergeni.

## Link relazione google docs
```console
https://docs.google.com/document/d/1JQ51cC0FUomPYfBO32lsqs7JvSVDxeoC7vSkVOxJ2Zg/edit
```

## Come accedere al sito da remoto (Tunnel SSH)
### Aprire il tunnel SSH
Aprire il tunnel SSH verso il server del Paolotti:
```console
ssh paolotti.studenti.math.unipd.it -l nome_utente_labortorio -L8080:tecweb:80 -L8443:tecweb:443 -L8022:tecweb:22
```
Il tunnel va tenuto aperto per tutto il tempo necessario (non chiudere la shell SSH), altrimenti i comandi e URL dei paragrafi successivi non saranno più validi!

### Accedere al sito e al pannello PHPMyAdmin
Per accedere usare:
| **Contenuto** | **URL** |
|---|---|
| Sito | http://localhost:8080/nome_utente_laboratorio/Home/index.php |
| PHPMyAdmin  | http://localhost:8080/phpmyadmin/ |

### Recuperare la password del proprio database
Nella shell dove è stata aperta la connessione del tunnel SSH, aprire un'altra connessione SSH verso il server *tecweb.studenti.math.unipd.it* e fare il *cat* del file con la password:
```console
ssh nome_utente_laboratorio@tecweb.studenti.math.unipd.it
cat pwd_db_2023-24.txt
```
Verrà stampata la password del database. Successivamente chiudere la connessione verso il server *tecweb*:
```console
exit
```

### Copiare il progetto nel server del Paolotti
Usare il seguente comando dentro la root della cartella del progetto di Tecnologie Web:
```console
scp -P 8022 -r -p * nome_utente_laboratorio@localhost:public_html/
```
Usando l'argomento *-r* (ricorsivo) e *-p \** veranno caricati tutti i file dentro la cartella corrente sul server di **tecweb.studenti.math.unipd.it** nella posizione corretta.
Se possibile, meglio caricare solo le cartelle strettamente necessarie.
### Chiudere il tunnel SSH
Importante: chiudere sempre il tunnel SSH correttamente quando avete terminato. Andare nella shell dove avete aperto il tunnel, eseguire:
```console
exit
```

## Validatori e strumenti
- ### Struttura
    - [W3C HTML Tool](https://validator.w3.org/), controllo della conformità allo standard HTML, usare HTML5;
    - [HTML 5 Outliner](https://gsnedders.html5.org/outliner/), permette di ottenere la lista delle parole più importanti, controllare:
        - l'ordine delle parole che sia corretto;
        - la presenza di tutte le keyword;
        - l'assenza di "untitled";
        - l'assenza di doppioni di parole;
    - [W3C HTML Tool (nu)](https://validator.w3.org/nu), per regole ARIA? 

- ### Presentazione
    - [W3C CSS Tool](https://jigsaw.w3.org/css-validator/), controllo della conformità allo standard CSS 3;
    - ["Emulatore di daltonismo"](https://colororacle.org/), serve a verificare che i colori siano corretti anche per le persone con daltonismo;
    - [Controllo contrasto e accessibilità del colore](https://color.a11y.com/), attenzione, a volte può dare falsi positivi oppure potrebbe dare dei falsi negativi;
    - [CCA](https://www.tpgi.com/color-contrast-checker/), è un programma che permette di controllare il contrasto del colore, e di capire per quali parti della pagina è utilizzabile;
    - [Color Oracle](https://colororacle.org);
    - [Color Contrast Accessibility Validator](https://color.a11y.com).

- ### Tool solo in LAB140
    - **Total Validator, versione Basic**, è essenziale controllare prima della consegna del progetto, ogni tanto da dei falsi positivi, in caso di dubbi chiedere alla prof.

- ### Altro
    - [Screen reader](https://www.nvaccess.org/download/), consigliato dalla prof;
    - [Velocità di caricamento sito](https://pagespeed.web.dev/), per verificare la "pesantezza" del sito;
    - [Wcag4All](https://web.math.unipd.it/accessibility/test.html);
    - **Testare il sito con i browser più importanti: Firefox, MS Edge/Chrome, Safari**.

---

## Siti utili secondo la prof.
- [Microformati](https://microformats.org/), per i microformati;
- [Palette cromatiche accessibili](http://colorsafe.co/), permette di generare delle palette cromatiche a partire dal colore di bandiera, rispetta il WCAG 2.1;
- [WAI-ARI](https://w3c.github.io/using-aria/), preferibilmente non usarlo;
- [Lista ruoli WAI-ARI](https://www.w3.org/WAI/PF/aria/roles);
- [PageSpeed Insights](https://pagespeed.web.dev/).

 That is it, per il momento...

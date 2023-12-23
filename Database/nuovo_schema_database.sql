-- Nota 1: l'uso dei 'ON DELETE CASCADE' sono una soluzione temporanea
-- DB Target

USE sushirestaurant;

-- Pulizia DB
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS prenotazione CASCADE;
DROP TABLE IF EXISTS tavolo CASCADE;
DROP TABLE IF EXISTS recensione CASCADE;
DROP TABLE IF EXISTS utente CASCADE;
DROP TABLE IF EXISTS piatto CASCADE;
DROP TABLE IF EXISTS allergene CASCADE;
DROP TABLE IF EXISTS ordine CASCADE;
SET FOREIGN_KEY_CHECKS=1;


-- Crea lo schema e i vincoli

CREATE TABLE utente (
    username    VARCHAR(50) PRIMARY KEY,
    email       VARCHAR(100) CHECK (email LIKE '%@%.%'),
    nome        VARCHAR(50) NOT NULL,
    cognome     VARCHAR(50) NOT NULL,
    password    VARCHAR(255) NOT NULL CHECK (length(password) >= 8),
    privilegi   ENUM('Cliente', 'Admin') DEFAULT 'Cliente'
);

CREATE TABLE piatto (
    id                 INT PRIMARY KEY AUTO_INCREMENT,
    nome               VARCHAR(100) NOT NULL,
    descrizione        VARCHAR(100), -- maybe?
    categoria          VARCHAR(20) NOT NULL,
    prezzo             DECIMAL(5,2) NOT NULL CHECK (prezzo >= 0),
    tipologia_menu     ENUM('Pranzo', 'Cena', 'Entrambi') NOT NULL,
    tipologia_portata  ENUM('AllYouCanEat', 'AllaCarta') NOT NULL
);

CREATE TABLE allergene (
    nome                VARCHAR(50),
    piatto              INT,
    PRIMARY KEY (nome,piatto),
    FOREIGN KEY (piatto) REFERENCES piatto(id) ON DELETE CASCADE
);

CREATE TABLE tavolo (
    id      INT PRIMARY KEY,
    posti   INT NOT NULL CHECK (posti > 0)
);

CREATE TABLE prenotazione (
    utente                  VARCHAR(50),
    data_ora                TIMESTAMP,
    numero_persone          INT NOT NULL CHECK (numero_persone > 0),
    stato                   ENUM('DaSvolgersi', 'InCorso', 'Terminata') NOT NULL,
    tavolo                  INT NOT NULL,
    indicazione_aggiuntive  TEXT,
    PRIMARY KEY (utente,data_ora),
    FOREIGN KEY (utente) REFERENCES utente(username) ON DELETE CASCADE,
    FOREIGN KEY (tavolo) REFERENCES tavolo(id) ON DELETE CASCADE
);

CREATE TABLE ordine (
    utente              VARCHAR(50),
    piatto              INT,
    data_ora            TIMESTAMP,
    data_prenotazione   TIMESTAMP NOT NULL,
    quantita            INT NOT NULL CHECK (quantita > 0),
    consegnato          BOOLEAN NOT NULL,
    PRIMARY KEY (utente,piatto,data_ora),
    FOREIGN KEY (utente,data_prenotazione) REFERENCES prenotazione(utente,data_ora) ON DELETE CASCADE,
    FOREIGN KEY (piatto) REFERENCES piatto(id) ON DELETE CASCADE
);

-- Check ulteriori

-- Dati

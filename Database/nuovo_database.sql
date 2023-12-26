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
    password    VARCHAR(255) NOT NULL CHECK (length(password) >= 4),
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

-- DATI
INSERT INTO utente 
VALUES
    (
        'admin',
        'admin@sysadmin.net',
        'Giovanni', 
        'Muciaccia',
        'admin',
        'Admin'
    ),
    (
        'user',
        'user@example.net',
        'Pippo', 
        'Baudo',
        'user',
        'Cliente'
    )
;
    
INSERT INTO piatto
VALUES
    (
        1,
        'Nigiri di Salmone',
        'Salmone fresco su letto di riso',
        'Nigiri',
        12.99,
        'Cena',
        'AllaCarta'
    ),
    (
        2,
        'Maki California',
        'Avocado, granchio e cetriolo avvolti in alga e riso',
        'Uromaki',
        14.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        3,
        'Sashimi di Tonno',
        'Fette sottili di tonno fresco',
        'Sashimi',
        16.99,
        'Cena',
        'AllaCarta'
    ),
    (
        4,
        'Tempura di Gamberi',
        'Gamberi fritti in pastella leggera',
        'Fritti',
        18.99,
        'Entrambi',
        'AllaCarta'
    ),
    (
        5,
        'Menu Sushi Deluxe',
        'Assortimento di nigiri, maki e sashimi',
        'Barche',
        29.99,
        'Cena',
        'AllYouCanEat'
    ),
    (
        6,
        'Dragon Roll',
        'Granchio, avocado e cetriolo avvolti in anguilla e avocado',
        'Uromaki',
        22.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        7,
        'Uramaki Philly',
        'Salmone, formaggio cremoso e cetriolo',
        'Uromaki',
        15.99,
        'Cena',
        'AllaCarta'
    ),
    (
        8,
        'Tartare di Salmone',
        'Salmone crudo tritato con cipolla rossa e avocado',
        'Tartare',
        17.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        9,
        'Gyoza di Verdure',
        'Ravioli giapponesi ripieni di verdure',
        'Secondi Piatti', 11.99,
        'Entrambi',
        'AllaCarta'
    ),
    (
        10,
        'Roll di Avocado',
        'Avocado, cetriolo e riso avvolti in alga',
        'Uromaki',
        13.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        11,
        'Tataki di Manzo',
        'Fettine di manzo leggermente scottate e marinato',
        'Secondi piatti',
        23.99,
        'Cena',
        'AllaCarta'
    ),
    (
        12,
        'Maki Salmone e Avocado',
        'Salmone e avocado avvolti in alga e riso',
        'Uromaki',
        16.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        13,
        'Sashimi Misto',
        'Assortimento di sashimi con pesce misto',
        'Sashimi',
        19.99,
        'Cena',
        'AllaCarta'
    ),
    (
        14,
        'Tempura di Verdure',
        'Verdure miste fritte in pastella leggera',
        'Fritti',
        15.99,
        'Entrambi',
        'AllaCarta'
    ),
    (
        15,
        'Menu Sushi Premium',
        'Selezione premium di nigiri, maki e sashimi',
        'Barche',
        34.99,
        'Cena',
        'AllYouCanEat'
    ),
    (
        16,
        'Rainbow Roll',
        'Maki con strati di pesce vari',
        'Uromaki',
        26.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        17,
        'Uramaki Tempura',
        'Tempura di gamberi avvolta in riso e alga',
        'Uromaki',
        20.99,
        'Cena',
        'AllaCarta'
    ),
    (
        18,
        'Tartare di Tonno',
        'Tonno crudo tritato con avocado e salsa piccante',
        'Tartare',
        18.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        19,
        'Gyoza di Pollo',
        'Ravioli giapponesi ripieni di pollo',
        'Secondi piatti',
        12.99,
        'Entrambi',
        'AllaCarta'
    ),
    (
        20,
        'Roll Vegano',
        'Risotto, avocado, cetriolo e verdure',
        'Uromaki',
        14.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        21,
        'Nigiri di Tonno',
        'Tonno fresco su letto di riso',
        'Nigiri',
        14.99,
        'Cena',
        'AllaCarta'
    )
;


INSERT INTO allergene
VALUES
    ('Pesce', 1),
    -- Nigiri di Salmone
    ('Soia', 2),
    -- Maki California
    ('Pesce', 3),
    -- Sashimi di Tonno
    ('Crostacei', 4),
    -- Tempura di Gamberi
    ('Soia', 5),
    -- Menu Sushi Deluxe
    ('Pesce', 6),
    -- Dragon Roll
    ('Pesce', 7),
    -- Uramaki Philly
    ('Pesce', 8),
    -- Tartare di Salmone
    ('Sedano', 9),
    -- Gyoza di Verdure
    ('Sedano', 10),
    -- Roll di Avocado
    ('Pesce', 11),
    -- Tataki di Manzo
    ('Pesce', 12),
    -- Maki Salmone e Avocado
    ('Pesce', 13),
    -- Sashimi Misto
    ('Sedano', 14),
    -- Tempura di Verdure
    ('Pesce', 15),
    -- Menu Sushi Premium
    ('Pesce', 16),
    -- Rainbow Roll
    ('Crostacei', 17),
    -- Uramaki Tempura
    ('Pesce', 18),
    -- Tartare di Tonno
    ('Sedano', 19),
    -- Gyoza di Pollo
    ('Pesce', 20),
    -- Roll Vegano
    ('Pesce', 21)
;

INSERT INTO tavolo 
SELECT n AS id, FLOOR(RAND() * (10 - 2 + 1) + 2) AS numPosti
FROM
    (
        SELECT
            ROW_NUMBER() OVER () AS n
        FROM
            information_schema.tables
    ) AS numbers
LIMIT 50
;
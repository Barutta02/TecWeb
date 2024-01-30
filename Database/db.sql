-- DB Target
USE abustreo;

-- Pulizia DB
SET
    FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS prenotazione CASCADE;

DROP TABLE IF EXISTS tavolo CASCADE;

DROP TABLE IF EXISTS recensione CASCADE;

DROP TABLE IF EXISTS utente CASCADE;

DROP TABLE IF EXISTS piatto CASCADE;

DROP TABLE IF EXISTS allergene CASCADE;

DROP TABLE IF EXISTS ordine CASCADE;

SET
    FOREIGN_KEY_CHECKS = 1;

-- Crea lo schema e i vincoli
CREATE TABLE utente (
    username VARCHAR(50) PRIMARY KEY,
    email VARCHAR(100) UNIQUE CHECK (email LIKE '%@%.%'),
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL CHECK (length(password) >= 4),
    privilegi ENUM('Cliente', 'Admin') DEFAULT 'Cliente'
);

CREATE TABLE piatto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descrizione VARCHAR(100),
    -- maybe?
    categoria VARCHAR(20) NOT NULL,
    prezzo DECIMAL(5, 2) NOT NULL CHECK (prezzo >= 0),
    tipologia_menu ENUM('Pranzo', 'Cena', 'Entrambi') NOT NULL,
    tipologia_portata ENUM('AllYouCanEat', 'AllaCarta') NOT NULL
);

CREATE TABLE allergene (
    nome VARCHAR(50),
    piatto INT,
    PRIMARY KEY (nome, piatto),
    FOREIGN KEY (piatto) REFERENCES piatto(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE tavolo (
    id INT PRIMARY KEY,
    posti INT NOT NULL CHECK (posti > 0)
);

CREATE TABLE prenotazione (
    utente VARCHAR(50),
    data_ora TIMESTAMP,
    numero_persone INT NOT NULL CHECK (numero_persone > 0),
    stato ENUM('DaSvolgersi', 'InCorso', 'Terminata') NOT NULL,
    tavolo INT NOT NULL,
    indicazioni_aggiuntive TEXT,
    PRIMARY KEY (utente, data_ora),
    FOREIGN KEY (utente) REFERENCES utente(username) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (tavolo) REFERENCES tavolo(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE ordine (
    utente VARCHAR(50),
    piatto INT,
    data_ora TIMESTAMP,
    data_prenotazione TIMESTAMP NOT NULL,
    quantita INT NOT NULL CHECK (quantita > 0),
    consegnato BOOLEAN NOT NULL,
    PRIMARY KEY (utente, piatto, data_ora),
    FOREIGN KEY (utente, data_prenotazione) REFERENCES prenotazione(utente, data_ora) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (piatto) REFERENCES piatto(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- DATI
INSERT INTO
    utente (
        username,
        email,
        nome,
        cognome,
        password,
        privilegi
    )
VALUES
    (
        'admin',
        'admin@sysadmin.net',
        'Giovanni',
        'Muciaccia',
        'admin',
        'Admin'
    );

INSERT INTO
    utente (
        username,
        email,
        nome,
        cognome,
        password,
        privilegi
    )
VALUES
    (
        'albe',
        'www.da.0502@gmail.com',
        'alberto',
        'dugo',
        'Prova21!',
        'Cliente'
    );

INSERT INTO
    utente (
        username,
        email,
        nome,
        cognome,
        password,
        privilegi
    )
VALUES
    (
        'francesco',
        'www.da.0412@gmail.com',
        'francesco',
        'dugo',
        'Prova21!',
        'Cliente'
    );

INSERT INTO
    utente (
        username,
        email,
        nome,
        cognome,
        password,
        privilegi
    )
VALUES
    (
        'francesco01',
        'www.da.1502@gmail.com',
        'francesco',
        'dugo',
        'Prova21!',
        'Cliente'
    );

INSERT INTO
    utente (
        username,
        email,
        nome,
        cognome,
        password,
        privilegi
    )
VALUES
    (
        'francesco02',
        'www.da.0513@gmail.com',
        'francesco',
        'muciacia',
        'Prova21!',
        'Cliente'
    );

INSERT INTO
    utente (
        username,
        email,
        nome,
        cognome,
        password,
        privilegi
    )
VALUES
    (
        'gianluca',
        'www.da.0102@gmail.com',
        'gianluca',
        'muciacia',
        'Prova21!',
        'Cliente'
    );

INSERT INTO
    utente (
        username,
        email,
        nome,
        cognome,
        password,
        privilegi
    )
VALUES
    (
        'gianluca01',
        'www.da.0504@gmail.com',
        'gianluca',
        'dugo',
        'Prova21!',
        'Cliente'
    );

INSERT INTO
    utente (
        username,
        email,
        nome,
        cognome,
        password,
        privilegi
    )
VALUES
    (
        'luca',
        'www.da.0501@gmail.com',
        'luca',
        'salmaso',
        'Prova21!',
        'Cliente'
    );

INSERT INTO
    utente (
        username,
        email,
        nome,
        cognome,
        password,
        privilegi
    )
VALUES
    (
        'luca01',
        'www.ad.0502@gmail.com',
        'luca',
        'dugo',
        'Prova21!',
        'Cliente'
    );

INSERT INTO
    utente (
        username,
        email,
        nome,
        cognome,
        password,
        privilegi
    )
VALUES
    (
        'marco',
        'www.da.0522@gmail.com',
        'marco',
        'dugo',
        'Prova21!',
        'Cliente'
    );

INSERT INTO
    utente (
        username,
        email,
        nome,
        cognome,
        password,
        privilegi
    )
VALUES
    (
        'user',
        'user@example.net',
        'Pippo',
        'Baudo',
        'user',
        'Cliente'
    );

INSERT INTO
    piatto
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
        'Secondi Piatti',
        11.99,
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
    );

INSERT INTO
    piatto
VALUES
    (
        22,
        'Nigiri di granchio',
        'Granchio fresco su letto di riso',
        'Nigiri',
        12.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        23,
        'Maki Tokyo',
        'Avocado, granchio, tonno avvolti in alga e riso',
        'Uromaki',
        14.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        24,
        'Sashimi di salmone',
        'Salmone fresco su letto di riso',
        'Sashimi',
        10.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        25,
        'Patatine fritte',
        'Patatine fritte con salse varie',
        'Fritti',
        9.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        26,
        'Sushi misto vegano',
        'Sushi di verdure ogni genere',
        'Barche',
        74.52,
        'Pranzo',
        'AllaCarta'
    ),
    (
        27,
        'Tartare di branzino',
        'Branzino crudo tritato con cipolla rossa e avocado',
        'Tartare',
        6.99,
        'Pranzo',
        'AllaCarta'
    ),
    (
        28,
        'Udon con verdure',
        'Spaghetti giapponesi conditi con verdure',
        'Secondi Piatti',
        4.99,
        'Pranzo',
        'AllaCarta'
    );

INSERT INTO
    allergene
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
    ('Pesce', 21);

INSERT INTO
    tavolo (id, posti)
VALUES
    (1, 5);

INSERT INTO
    tavolo (id, posti)
VALUES
    (2, 2);

INSERT INTO
    tavolo (id, posti)
VALUES
    (3, 3);

INSERT INTO
    tavolo (id, posti)
VALUES
    (4, 8);

INSERT INTO
    tavolo (id, posti)
VALUES
    (5, 2);

INSERT INTO
    tavolo (id, posti)
VALUES
    (6, 10);

INSERT INTO
    tavolo (id, posti)
VALUES
    (7, 7);

INSERT INTO
    tavolo (id, posti)
VALUES
    (8, 4);

INSERT INTO
    tavolo (id, posti)
VALUES
    (9, 6);

INSERT INTO
    tavolo (id, posti)
VALUES
    (10, 8);

INSERT INTO
    tavolo (id, posti)
VALUES
    (11, 3);

INSERT INTO
    tavolo (id, posti)
VALUES
    (12, 6);

INSERT INTO
    tavolo (id, posti)
VALUES
    (13, 2);

INSERT INTO
    tavolo (id, posti)
VALUES
    (14, 8);

INSERT INTO
    tavolo (id, posti)
VALUES
    (15, 6);

INSERT INTO
    tavolo (id, posti)
VALUES
    (16, 3);

INSERT INTO
    tavolo (id, posti)
VALUES
    (17, 4);

INSERT INTO
    tavolo (id, posti)
VALUES
    (18, 10);

INSERT INTO
    tavolo (id, posti)
VALUES
    (19, 9);

INSERT INTO
    tavolo (id, posti)
VALUES
    (20, 5);

INSERT INTO
    tavolo (id, posti)
VALUES
    (21, 5);

INSERT INTO
    tavolo (id, posti)
VALUES
    (22, 8);

INSERT INTO
    tavolo (id, posti)
VALUES
    (23, 7);

INSERT INTO
    tavolo (id, posti)
VALUES
    (24, 10);

INSERT INTO
    tavolo (id, posti)
VALUES
    (25, 10);

INSERT INTO
    tavolo (id, posti)
VALUES
    (26, 7);

INSERT INTO
    tavolo (id, posti)
VALUES
    (27, 4);

INSERT INTO
    tavolo (id, posti)
VALUES
    (28, 6);

INSERT INTO
    tavolo (id, posti)
VALUES
    (29, 7);

INSERT INTO
    tavolo (id, posti)
VALUES
    (30, 6);

INSERT INTO
    tavolo (id, posti)
VALUES
    (31, 7);

INSERT INTO
    tavolo (id, posti)
VALUES
    (32, 9);

INSERT INTO
    tavolo (id, posti)
VALUES
    (33, 10);

INSERT INTO
    tavolo (id, posti)
VALUES
    (34, 7);

INSERT INTO
    tavolo (id, posti)
VALUES
    (35, 2);

INSERT INTO
    tavolo (id, posti)
VALUES
    (36, 4);

INSERT INTO
    tavolo (id, posti)
VALUES
    (37, 4);

INSERT INTO
    tavolo (id, posti)
VALUES
    (38, 7);

INSERT INTO
    tavolo (id, posti)
VALUES
    (39, 2);

INSERT INTO
    tavolo (id, posti)
VALUES
    (40, 8);

INSERT INTO
    tavolo (id, posti)
VALUES
    (41, 6);

INSERT INTO
    tavolo (id, posti)
VALUES
    (42, 3);

INSERT INTO
    tavolo (id, posti)
VALUES
    (43, 5);

INSERT INTO
    tavolo (id, posti)
VALUES
    (44, 6);

INSERT INTO
    tavolo (id, posti)
VALUES
    (45, 4);

INSERT INTO
    tavolo (id, posti)
VALUES
    (46, 10);

INSERT INTO
    tavolo (id, posti)
VALUES
    (47, 9);

INSERT INTO
    tavolo (id, posti)
VALUES
    (48, 3);

INSERT INTO
    tavolo (id, posti)
VALUES
    (49, 6);

INSERT INTO
    tavolo (id, posti)
VALUES
    (50, 10);

INSERT INTO
    prenotazione (
        utente,
        data_ora,
        numero_persone,
        stato,
        tavolo,
        indicazioni_aggiuntive
    )
VALUES
    (
        'albe',
        '2024-01-26 15:17:14',
        10,
        'InCorso',
        6,
        ' '
    );

INSERT INTO
    prenotazione (
        utente,
        data_ora,
        numero_persone,
        stato,
        tavolo,
        indicazioni_aggiuntive
    )
VALUES
    (
        'francesco',
        '2024-01-26 15:17:14',
        8,
        'InCorso',
        10,
        'Siamo tutti celiaci'
    );

INSERT INTO
    prenotazione (
        utente,
        data_ora,
        numero_persone,
        stato,
        tavolo,
        indicazioni_aggiuntive
    )
VALUES
    (
        'francesco01',
        '2024-01-26 15:17:14',
        2,
        'InCorso',
        13,
        ' '
    );

INSERT INTO
    prenotazione (
        utente,
        data_ora,
        numero_persone,
        stato,
        tavolo,
        indicazioni_aggiuntive
    )
VALUES
    (
        'francesco02',
        '2024-01-26 15:17:14',
        8,
        'InCorso',
        14,
        'Due forchette'
    );

INSERT INTO
    prenotazione (
        utente,
        data_ora,
        numero_persone,
        stato,
        tavolo,
        indicazioni_aggiuntive
    )
VALUES
    (
        'gianluca',
        '2024-01-26 15:17:14',
        3,
        'InCorso',
        11,
        ' '
    );

INSERT INTO
    prenotazione (
        utente,
        data_ora,
        numero_persone,
        stato,
        tavolo,
        indicazioni_aggiuntive
    )
VALUES
    (
        'gianluca01',
        '2024-01-26 15:17:14',
        6,
        'InCorso',
        12,
        'Mi piace molto il vostro sito web'
    );

INSERT INTO
    prenotazione (
        utente,
        data_ora,
        numero_persone,
        stato,
        tavolo,
        indicazioni_aggiuntive
    )
VALUES
    (
        'luca',
        '2024-01-26 15:17:14',
        6,
        'InCorso',
        9,
        ' '
    );

INSERT INTO
    prenotazione (
        utente,
        data_ora,
        numero_persone,
        stato,
        tavolo,
        indicazioni_aggiuntive
    )
VALUES
    (
        'luca01',
        '2024-01-26 15:17:14',
        7,
        'InCorso',
        7,
        'Con alga o senza'
    );

INSERT INTO
    prenotazione (
        utente,
        data_ora,
        numero_persone,
        stato,
        tavolo,
        indicazioni_aggiuntive
    )
VALUES
    (
        'marco',
        '2024-01-26 15:17:14',
        4,
        'InCorso',
        8,
        ' '
    );

INSERT INTO
    prenotazione (
        utente,
        data_ora,
        numero_persone,
        stato,
        tavolo,
        indicazioni_aggiuntive
    )
VALUES
    (
        'user',
        '2024-01-26 15:17:14',
        8,
        'Terminata',
        40,
        'per favore senza tenia!1!'
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'albe',
        2,
        '2024-01-26 14:49:57',
        '2024-01-26 15:17:14',
        1,
        0
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'albe',
        10,
        '2024-01-26 14:55:49',
        '2024-01-26 15:17:14',
        2,
        1
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'francesco',
        6,
        '2024-01-26 14:49:57',
        '2024-01-26 15:17:14',
        1,
        0
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'francesco',
        14,
        '2024-01-26 14:55:49',
        '2024-01-26 15:17:14',
        2,
        1
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'francesco01',
        9,
        '2024-01-26 14:49:57',
        '2024-01-26 15:17:14',
        2,
        0
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'francesco01',
        17,
        '2024-01-26 14:55:49',
        '2024-01-26 15:17:14',
        1,
        0
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'francesco02',
        10,
        '2024-01-26 14:49:57',
        '2024-01-26 15:17:14',
        1,
        0
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'francesco02',
        18,
        '2024-01-26 14:55:49',
        '2024-01-26 15:17:14',
        2,
        0
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'gianluca',
        7,
        '2024-01-26 14:49:57',
        '2024-01-26 15:17:14',
        2,
        0
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'gianluca',
        15,
        '2024-01-26 14:55:49',
        '2024-01-26 15:17:14',
        3,
        1
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'gianluca01',
        8,
        '2024-01-26 14:49:57',
        '2024-01-26 15:17:14',
        1,
        0
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'gianluca01',
        16,
        '2024-01-26 14:55:49',
        '2024-01-26 15:17:14',
        2,
        1
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'luca',
        5,
        '2024-01-26 14:49:57',
        '2024-01-26 15:17:14',
        2,
        0
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'luca',
        13,
        '2024-01-26 14:55:49',
        '2024-01-26 15:17:14',
        1,
        1
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'luca01',
        3,
        '2024-01-26 14:49:57',
        '2024-01-26 15:17:14',
        2,
        0
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'luca01',
        11,
        '2024-01-26 14:55:49',
        '2024-01-26 15:17:14',
        1,
        1
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'marco',
        4,
        '2024-01-26 14:49:57',
        '2024-01-26 15:17:14',
        1,
        0
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'marco',
        12,
        '2024-01-26 14:55:49',
        '2024-01-26 15:17:14',
        2,
        1
    );

INSERT INTO
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    )
VALUES
    (
        'user',
        1,
        '2024-01-26 15:55:03',
        '2024-01-26 15:17:14',
        2,
        1
    );

INSERT INTO 
    ordine (
        utente,
        piatto,
        data_ora,
        data_prenotazione,
        quantita,
        consegnato
    ) 
VALUES 
    (
        'user', 
        3, 
        '2024-01-26 15:57:03', 
        '2024-01-26 15:17:14', 
        6, 
        1
    );
INSERT INTO
    Categoria (Nome)
VALUES
    ('Nigiri'),
    ('Tartare'),
    ('Sashimi'),
    ('Secondi Piatti'),
    ('Uromaki'),
    ('Fritti', 'Barche');

INSERT INTO
    Piatto (
        IDPiatto,
        NomePiatto,
        Descrizione,
        Categoria,
        Prezzo,
        TipoMenu,
        TipoPortata
    )
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
        'Secondi Piatti' 11.99,
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
    Allergene (NomeAllergene)
VALUES
    ('Uova'),
    ('Soia'),
    ('Pesce'),
    ('Crostacei'),
    ('Sedano'),
    ('Senape');

-- Inserisci dati nella tabella AllergenePiatto
INSERT INTO
    AllergenePiatto (Allergene, Piatto)
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

-- Nigiri di Tonno
INSERT INTO
    Tavolo (IDTavolo, numPosti)
SELECT
    n AS IDTavolo,
    FLOOR(RAND() * (10 - 2 + 1) + 2) AS numPosti
FROM
    (
        SELECT
            ROW_NUMBER() OVER () AS n
        FROM
            information_schema.tables
    ) AS numbers
LIMIT
    50;
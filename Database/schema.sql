-- Tabella Utenti
CREATE TABLE User (
    Username VARCHAR(20) PRIMARY KEY,
    Nome VARCHAR(50),
    Cognome VARCHAR(50),
    Email VARCHAR(100) UNIQUE,
    Password VARCHAR(255)
);

CREATE TABLE Admin(
    Username VARCHAR(20) PRIMARY KEY,
    Password VARCHAR(255)
) -- Tabella Menu
CREATE TABLE Piatto (
    IDPiatto INT PRIMARY KEY,
    NomePiatto VARCHAR(100),
    Descrizione VARCHAR(100),
    Prezzo FLOAT,
    TipoMenu ENUM('Pranzo', 'Cena', 'Entrambi') NOT NULL,
    TipoPortata ENUM('AllYouCanEat', 'AllaCarta') NOT NULL
);

CREATE TABLE Allergene (NomeAllergene VARCHAR(100) PRIMARY KEY);

CREATE TABLE AllergenePiatto (
    Allergene VARCHAR(100),
    Piatto INT,
    PRIMARY KEY (Allergene, Piatto),
    FOREIGN KEY (Allergene) REFERENCES Allergene(NomeAllergene),
    FOREIGN KEY (Piatto) REFERENCES Piatto(IDPiatto)
);

-- Tabella tavoli
CREATE TABLE Tavolo (
    IDTavolo INT PRIMARY KEY,
    numPosti INT
);

-- Tabella Prenotazioni
CREATE TABLE Prenotazione (
    Username VARCHAR(20),
    DataPrenotazione DATETIME,
    NumPersone INT,
    InCorso BOOL,
    Tavolo INT,
    PRIMARY KEY (Username, DataPrenotazione),
    FOREIGN KEY (Username) REFERENCES User(Username),
    FOREIGN KEY (Tavolo) REFERENCES Tavolo(IDTavolo)
);

-- Tabella Ordini
CREATE TABLE Ordine (
    IDOrdine INT PRIMARY KEY,
    Username varchar(20),
    DataPrenotazione DATETIME,
    Quantita INT,
    Consegnato BOOL,
    FOREIGN KEY (Username, DataPrenotazione) REFERENCES Prenotazione(Username, DataPrenotazione)
);

-- Tabella Recensioni
CREATE TABLE Recensioni (
    Username VARCHAR(20) PRIMARY KEY,
    Voto INT,
    Commento TEXT,
    DataRecensione DATE,
    FOREIGN KEY (Username) REFERENCES User(Username)
);


CREATE TABLE `equipes` (
    IDEquipe INT AUTO_INCREMENT PRIMARY KEY,
    NomEquipe VARCHAR(255),
    Statut varchar(50),
    DateCreation DATETIME NOT NULL DEFAULT CURRENT_TIME
);


CREATE TABLE perssonel (
	Id INT AUTO_INCREMENT PRIMARY KEY,
    LastName varchar(255),
    FirstName varchar(255),
    Email varchar(255),
    Passdwd varchar(25),
    Tel varchar(25),
    Role varchar(255),
    IDTeam INT,
    Statut varchar(255),
    DateCreation DATETIME NOT NULL DEFAULT CURRENT_TIME
);

INSERT INTO equipes (NomEquipe, Statut) VALUES ('TEAM1', 'Active');

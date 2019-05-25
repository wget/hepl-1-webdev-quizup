/********************************************************************************/
/* version 2019.03.26                                                           */
/* Si vous utilisez phpMyAdmin, veillez à bien décocher la case                 */
/*  'Activer la vérification des clés étrangères' avant d'exécuter le script    */
/********************************************************************************/

/* Tables Oranges */
CREATE TABLE pays
(
	idPays INT NOT NULL AUTO_INCREMENT,
  libellePays VARCHAR(50) NOT NULL UNIQUE,
  drapeauPays VARCHAR(50),
	PRIMARY KEY (idPays)
) ENGINE = InnoDB;

CREATE TABLE region
(
	idRegion INT NOT NULL AUTO_INCREMENT,
  libelleRegion VARCHAR(50) NOT NULL UNIQUE,
  drapeauRegion VARCHAR(50),
  idPays INT NOT NULL,
	PRIMARY KEY(idRegion),
	FOREIGN KEY(idPays) REFERENCES pays(idPays)
) ENGINE = InnoDB;

CREATE TABLE profil
(
  idProfil INT NOT NULL AUTO_INCREMENT,
  nomProfil VARCHAR(50) NOT NULL,
  photoProfil VARCHAR(50),
  photoFacade VARCHAR(50),
  villeOrigine VARCHAR(50),
  langue VARCHAR(20) NOT NULL,
  bio VARCHAR(255),
  profilPrive TINYINT(1),
  diamants INT NOT NULL,
  idTitre INT,
  idPays INT,
  idRegion INT,
	PRIMARY KEY(idProfil),
	FOREIGN KEY(idPays) REFERENCES pays(idPays),
	FOREIGN KEY(idRegion) REFERENCES region(idRegion),
	FOREIGN KEY(idTitre) REFERENCES titre(idTitre)
) ENGINE = InnoDB;

CREATE TABLE usersession
(
  email VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  lastActivity DATETIME NOT NULL,
  joursConsecutifs TINYINT NOT NULL,
  idProfil INT NOT NULL,
	PRIMARY KEY(email),
	FOREIGN KEY (`idProfil`) REFERENCES `profil`(`idProfil`)
) ENGINE = InnoDB;

CREATE TABLE s_abonner
(
  idProfil INT NOT NULL,
  idProfil_1 INT NOT NULL,
  PRIMARY KEY(idProfil, idProfil_1),
	FOREIGN KEY(idProfil) REFERENCES profil(idProfil),
	FOREIGN KEY(idProfil_1) REFERENCES profil(idProfil)
) ENGINE = InnoDB;

CREATE TABLE bloquer
(
  idProfil INT NOT NULL,
  idProfil_1 INT NOT NULL,
  PRIMARY KEY(idProfil, idProfil_1),
	FOREIGN KEY(idProfil) REFERENCES profil(idProfil),
	FOREIGN KEY(idProfil_1) REFERENCES profil(idProfil)
) ENGINE = InnoDB;

/* Tables Roses */
CREATE TABLE categorie
(
  idCategorie INT NOT NULL AUTO_INCREMENT,
  libelleCategorie VARCHAR(50) NOT NULL,
	PRIMARY KEY(idCategorie)
) ENGINE = InnoDB;

CREATE TABLE theme
(
  idTheme INT NOT NULL AUTO_INCREMENT,
  libelleTheme VARCHAR(50) NOT NULL,
  description VARCHAR(250) NOT NULL,
  logo VARCHAR(50) NOT NULL,
  dateUpdated DATETIME NOT NULL,
  idCategorie INT NOT NULL,
  idProfil INT NOT NULL,
	PRIMARY KEY(idTheme),
	FOREIGN KEY(idCategorie) REFERENCES categorie(idCategorie),
  FOREIGN KEY(idProfil) REFERENCES profil(idProfil)
) ENGINE = InnoDB;

CREATE TABLE question
(
  idQuestion INT NOT NULL AUTO_INCREMENT,
  Illustration VARCHAR(50),
  libelleQuestion VARCHAR(255) NOT NULL,
  answer VARCHAR(255) NOT NULL,
  distracteur01 VARCHAR(255) NOT NULL,
  distracteur02 VARCHAR(255) NOT NULL,
  distracteur03 VARCHAR(255) NOT NULL,
  idTheme INT NOT NULL,
	PRIMARY KEY(idQuestion),
	FOREIGN KEY(idTheme) REFERENCES theme(idTheme)
) ENGINE = InnoDB;

CREATE TABLE titre
(
  idTitre INT NOT NULL AUTO_INCREMENT,
  libelleTitre VARCHAR(250) NOT NULL,
  niveauRequis TINYINT NOT NULL,
  idTheme INT NOT NULL,
	PRIMARY KEY(idTitre),
	FOREIGN KEY(idTheme) REFERENCES theme(idTheme)
) ENGINE = InnoDB;

CREATE TABLE suivre
(
  idProfil INT NOT NULL,
  idTheme INT NOT NULL,
  PRIMARY KEY(idProfil, idTheme),
	FOREIGN KEY(idProfil) REFERENCES profil(idProfil),
	FOREIGN KEY(idTheme) REFERENCES theme(idTheme)
) ENGINE = InnoDB;

/* Tables Bleues */
CREATE TABLE partie
(
  idPartie INT NOT NULL AUTO_INCREMENT,
  timestampPartie DATETIME NOT NULL,
	PRIMARY KEY(idPartie)
) ENGINE = InnoDB;

CREATE TABLE participer
(
  idProfil INT NOT NULL,
  idPartie INT NOT NULL,
	bonusBoost DECIMAL(2,1) NOT NULL,
  PRIMARY KEY(idProfil, idPartie),
	FOREIGN KEY(idProfil) REFERENCES profil(idProfil),
	FOREIGN KEY(idPartie) REFERENCES partie(idPartie)
) ENGINE = InnoDB;

CREATE TABLE integrer
(
  idPartie INT NOT NULL,
  idQuestion INT NOT NULL,
  numero TINYINT NOT NULL,
  ordreReponses CHAR(4) NOT NULL,
  PRIMARY KEY(idPartie, idQuestion),
	FOREIGN KEY(idPartie) REFERENCES partie(idPartie),
	FOREIGN KEY(idQuestion) REFERENCES question(idQuestion)
) ENGINE = InnoDB;

CREATE TABLE repondre
(
  idProfil INT NOT NULL,
  idPartie INT NOT NULL,
  idQuestion INT NOT NULL,
	reponse CHAR(1) NOT NULL,
  points TINYINT NOT NULL,
  PRIMARY KEY(idProfil, idPartie, idQuestion),
	FOREIGN KEY(idProfil) REFERENCES profil(idProfil),
	FOREIGN KEY(idPartie) REFERENCES partie(idPartie),
	FOREIGN KEY(idQuestion) REFERENCES question(idQuestion)
) ENGINE = InnoDB;

CREATE TABLE remporter
(
  idProfil INT NOT NULL,
  idTitre INT NOT NULL,
  PRIMARY KEY(idProfil, idTitre),
	FOREIGN KEY(idProfil) REFERENCES profil(idProfil),
	FOREIGN KEY(idTitre) REFERENCES titre(idTitre)
) ENGINE = InnoDB;

/* Tables Vertes */
CREATE TABLE chat_msg
(
  idChatMsg INT NOT NULL AUTO_INCREMENT,
  timestampMsg DATETIME NOT NULL,
  contenu VARCHAR(250) NOT NULL,
  lu TINYINT(1) NOT NULL,
  idProfil_recepteur INT NOT NULL,
  idProfil_emetteur INT NOT NULL,
	PRIMARY KEY(idChatMsg),
	FOREIGN KEY(idProfil_recepteur) REFERENCES profil(idProfil),
	FOREIGN KEY(idProfil_emetteur) REFERENCES profil(idProfil)
) ENGINE = InnoDB;

CREATE TABLE message
(
  idMessage INT NOT NULL AUTO_INCREMENT,
  timestampMessage DATETIME NOT NULL,
  contenuMessage VARCHAR(250) NOT NULL,
  idMessage_1 INT,
  idTheme INT,
  idProfil INT NOT NULL,
	PRIMARY KEY(idMessage),
	FOREIGN KEY(idMessage_1) REFERENCES message(idMessage),
	FOREIGN KEY(idTheme) REFERENCES theme(idTheme),
	FOREIGN KEY(idProfil) REFERENCES profil(idProfil)
) ENGINE = InnoDB;

CREATE TABLE liker
(
  idProfil INT NOT NULL,
  idMessage INT NOT NULL,
  PRIMARY KEY(idProfil, idMessage),
	FOREIGN KEY(idProfil) REFERENCES profil(idProfil),
	FOREIGN KEY(idMessage) REFERENCES message(idMessage)
) ENGINE = InnoDB;
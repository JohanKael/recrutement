-- Table departements
CREATE SEQUENCE seq_departements START WITH 1 INCREMENT BY 1;
CREATE TABLE departements (
   id_departement VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_departements')::text, 50, '0'),
   nom_departement VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_departement)
);

-- Table categorieEmploie
CREATE SEQUENCE seq_categorieEmploie START WITH 1 INCREMENT BY 1;
CREATE TABLE categorieEmploie (
   id_categorieemploie VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_categorieEmploie')::text, 50, '0'),
   nom_categorieemploie VARCHAR(250) NOT NULL,
   PRIMARY KEY(id_categorieemploie),
   UNIQUE(nom_categorieemploie)
);

-- Table sousCategorie
CREATE SEQUENCE seq_sousCategorie START WITH 1 INCREMENT BY 1;
CREATE TABLE sousCategorie (
   id_sousCategorie VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_sousCategorie')::text, 50, '0'),
   nom_sousCategorie VARCHAR(50) NOT NULL,
   id_categorieemploie VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_sousCategorie),
   FOREIGN KEY(id_categorieemploie) REFERENCES categorieEmploie(id_categorieemploie)
);
   
-- Table poste
CREATE SEQUENCE seq_poste START WITH 1 INCREMENT BY 1;
CREATE TABLE poste (
   id_poste VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_poste')::text, 50, '0'),
   intitule VARCHAR(300) NOT NULL,
   competence VARCHAR(300) NOT NULL,
   conditiontravail VARCHAR(400) NOT NULL,
   mission VARCHAR(300) NOT NULL,
   responsabilite VARCHAR(300) NOT NULL,
   tache VARCHAR(300) NOT NULL,
   remuneration INT NOT NULL,
   avantage VARCHAR(500) NOT NULL,
   id_sousCategorie VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_poste),
   FOREIGN KEY(id_sousCategorie) REFERENCES sousCategorie(id_sousCategorie)
);

-- Table devise
CREATE SEQUENCE seq_devise START WITH 1 INCREMENT BY 1;
CREATE TABLE devise (
   id_devise VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_devise')::text, 50, '0'),
   nom_devise VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_devise)
);

-- Table change
CREATE SEQUENCE seq_change START WITH 1 INCREMENT BY 1;
CREATE TABLE change (
   id_change VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_change')::text, 50, '0'),
   ariary DECIMAL(15,2) NOT NULL,
   valeur_change DECIMAL(15,2) NOT NULL,
   id_devise VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_change),
   FOREIGN KEY(id_devise) REFERENCES devise(id_devise)
);

-- Table Profil
CREATE SEQUENCE seq_profil START WITH 1 INCREMENT BY 1;
CREATE TABLE Profil (
   id_profil VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_profil')::text, 50, '0'),
   experience_min INT NOT NULL,
   experience_max INT NOT NULL,
   id_poste VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_profil),
   UNIQUE(id_poste),
   FOREIGN KEY(id_poste) REFERENCES poste(id_poste)
);

-- Table Diplome
CREATE SEQUENCE seq_diplome START WITH 1 INCREMENT BY 1;
CREATE TABLE Diplome (
   id_diplome VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_diplome')::text, 50, '0'),
   nom_diplome VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_diplome)
);

-- Table detailProfil
CREATE SEQUENCE seq_detailProfil START WITH 1 INCREMENT BY 1;
CREATE TABLE detailProfil (
   id_detailProfil VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_detailProfil')::text, 50, '0'),
   id_diplome VARCHAR(50) NOT NULL,
   id_profil VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_detailProfil),
   FOREIGN KEY(id_diplome) REFERENCES Diplome(id_diplome),
   FOREIGN KEY(id_profil) REFERENCES Profil(id_profil)
);

-- Table besoinGlobal
CREATE SEQUENCE seq_besoinGlobal START WITH 1 INCREMENT BY 1;
CREATE TABLE besoinGlobal (
   id_besoinGlobal VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_besoinGlobal')::text, 50, '0'),
   date_validtion VARCHAR(50),
   quantite_total VARCHAR(50),
   id_profil VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_besoinGlobal),
   FOREIGN KEY(id_profil) REFERENCES Profil(id_profil)
);

-- Table Fournisseur
CREATE SEQUENCE seq_fournisseur START WITH 1 INCREMENT BY 1;
CREATE TABLE Fournisseur (
   id_fournisseur VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_fournisseur')::text, 50, '0'),
   adresse VARCHAR(500) NOT NULL,
   nom VARCHAR(500) NOT NULL,
   nom_entreprise VARCHAR(500) NOT NULL,
   email VARCHAR(250) NOT NULL,
   telephone INT NOT NULL,
   antecedent VARCHAR(900) NOT NULL,
   PRIMARY KEY(id_fournisseur)
);

-- Table DemandeProforma
CREATE SEQUENCE seq_demandeProforma START WITH 1 INCREMENT BY 1;
CREATE TABLE DemandeProforma (
   id_demandeProforma VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_demandeProforma')::text, 50, '0'),
   DateDemande_proforma DATE NOT NULL,
   PRIMARY KEY(id_demandeProforma)
);

-- Table BonCommande
CREATE SEQUENCE seq_bonCommande START WITH 1 INCREMENT BY 1;
CREATE TABLE BonCommande (
   idBonCommande VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_bonCommande')::text, 50, '0'),
   date_bonCommande DATE NOT NULL,
   PRIMARY KEY(idBonCommande)
);

-- Table users
CREATE SEQUENCE seq_users START WITH 1 INCREMENT BY 1;
CREATE TABLE users (
   id_users VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_users')::text, 50, '0'),
   email_user VARCHAR(100) NOT NULL,
   password_user VARCHAR(200) NOT NULL,
   id_poste VARCHAR(50) NOT NULL,
   id_departement VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_users),
   FOREIGN KEY(id_poste) REFERENCES poste(id_poste),
   FOREIGN KEY(id_departement) REFERENCES departements(id_departement)
);

-- Table besoinProfil
CREATE SEQUENCE seq_besoinProfil START WITH 1 INCREMENT BY 1;
CREATE TABLE besoinProfil (
   id_besoinProfil VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_besoinProfil')::text, 50, '0'),
   date_demande DATE,
   quantite VARCHAR(50),
   id_profil VARCHAR(50) NOT NULL,
   id_users VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_besoinProfil),
   UNIQUE(id_users),
   FOREIGN KEY(id_profil) REFERENCES Profil(id_profil),
   FOREIGN KEY(id_users) REFERENCES users(id_users)
);

-- Table besoinChecked
CREATE SEQUENCE seq_besoinChecked START WITH 1 INCREMENT BY 1;
CREATE TABLE besoinChecked (
   id_besoinChecked VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_besoinChecked')::text, 50, '0'),
   dateChecck DATE NOT NULL,
   id_besoinProfil VARCHAR(50) NOT NULL,
   id_besoinGlobal VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_besoinChecked),
   UNIQUE(id_besoinProfil),
   FOREIGN KEY(id_besoinProfil) REFERENCES besoinProfil(id_besoinProfil),
   FOREIGN KEY(id_besoinGlobal) REFERENCES besoinGlobal(id_besoinGlobal)
);

-- Table Proforma
CREATE SEQUENCE seq_proforma START WITH 1 INCREMENT BY 1;
CREATE TABLE Proforma (
   id_proforma VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_proforma')::text, 50, '0'),
   date_emission DATE NOT NULL,
   date_expiration DATE NOT NULL,
   total DECIMAL(15,2) NOT NULL,
   id_fournisseur VARCHAR(50) NOT NULL,
   id_demandeProforma VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_proforma),
   UNIQUE(id_demandeProforma),
   FOREIGN KEY(id_fournisseur) REFERENCES Fournisseur(id_fournisseur),
   FOREIGN KEY(id_demandeProforma) REFERENCES DemandeProforma(id_demandeProforma)
);

-- Table DetailProforma
CREATE SEQUENCE seq_detailProforma START WITH 1 INCREMENT BY 1;
CREATE TABLE DetailProforma (
   id_detailProforma VARCHAR(50) DEFAULT LPAD(NEXTVAL('seq_detailProforma')::text, 50, '0'),
   quantite INT,
   pu VARCHAR

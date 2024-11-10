-- Insertion de données de test pour la table `departements`
INSERT INTO departements (nom_departement) VALUES 
('Informatique'),
('Comptabilite'),
('Technologie'),
('Gestion'),
('Finance'),
('Marketing');

-- Insertion de données de test pour la table `categorieEmploie`
INSERT INTO categorieEmploie (nom_categorieemploie) VALUES 
('A'),
('B'),
('C');

-- Insertion de données de test pour la table `sousCategorie`
INSERT INTO sousCategorie (nom_sousCategorie, id_categorieemploie) VALUES 
('A1', (SELECT id_categorieemploie FROM categorieEmploie WHERE nom_categorieemploie = 'A')),
('A2', (SELECT id_categorieemploie FROM categorieEmploie WHERE nom_categorieemploie = 'A')),
('B1', (SELECT id_categorieemploie FROM categorieEmploie WHERE nom_categorieemploie = 'B')),
('B2', (SELECT id_categorieemploie FROM categorieEmploie WHERE nom_categorieemploie = 'B')),
('C1', (SELECT id_categorieemploie FROM categorieEmploie WHERE nom_categorieemploie = 'C')),
('C2', (SELECT id_categorieemploie FROM categorieEmploie WHERE nom_categorieemploie = 'C')),
('C3', (SELECT id_categorieemploie FROM categorieEmploie WHERE nom_categorieemploie = 'C'));

-- Insertion de données de test pour la table `poste`
INSERT INTO poste (intitule, competence, conditiontravail, mission, responsabilite, tache, remuneration, avantage, id_sousCategorie) VALUES 
('Stagiaire Informatique', 'Connaissances de base en programmation', 'Horaires flexibles', 'Apprendre et aider dans des tâches IT', 'Responsabilité limitée', 'Assister equipe informatique', 500, 'Accès à des formations', 
 (SELECT id_sousCategorie FROM sousCategorie WHERE nom_sousCategorie = 'A1')),

('Comptable Junior', 'Maîtrise des bases comptables', 'Travail en bureau', 'Soutenir l equipe de comptabilité', 'Comptabilité de base', 'Tenir des registres comptables', 2000, 'Mutuelle de santé', 
 (SELECT id_sousCategorie FROM sousCategorie WHERE nom_sousCategorie = 'B1')),

('Chef de Direction', 'Expérience en gestion entreprise', 'Horaires longs et déplacements', 'Diriger entreprise', 'Gestion de toute entreprise', 'Superviser toutes les équipes', 10000, 'Voiture de fonction, primes annuelles', 
 (SELECT id_sousCategorie FROM sousCategorie WHERE nom_sousCategorie = 'C1'));

-- Insertion des devises
INSERT INTO devise (nom_devise) VALUES ('Euro');
INSERT INTO devise (nom_devise) VALUES ('Dollar');
INSERT INTO devise (nom_devise) VALUES ('Ariary');

-- Récupération des ID des devises ajoutées pour référence
SELECT id_devise, nom_devise FROM devise;

-- Insertion des taux de change
-- Remplacez les valeurs de `ariary` et `valeur_change` selon les taux actuels
INSERT INTO change (ariary, valeur_change, id_devise) VALUES (1, 5000, 'DVS000002'); -- Exemple Dollar
INSERT INTO change (ariary, valeur_change, id_devise) VALUES (1, 5400, 'DVS000001'); -- Exemple Euro
INSERT INTO change (ariary, valeur_change, id_devise) VALUES (1, 1, 'DVS000003'); -- Exemple Ariary (base)

-- Insertion de données de test pour la table `diplome`
INSERT INTO diplome (nom_diplome) VALUES 
('CEPE'),
('BEPC'),
('BACC'),
('BACC +1'),
('BACC +2'),
('LICENCE'),
('MASTER 1'),
('MASTER 2');

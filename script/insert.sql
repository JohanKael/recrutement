-- Données de test pour la table departements
INSERT INTO departements (nom_departement) VALUES 
('Ressources Humaines'),
('Technologie de l\''Information'),
('Marketing');

-- Données de test pour la table categorieEmploie
INSERT INTO categorieEmploie (nom_categorieemploie) VALUES 
('Gestion'),
('Technique'),
('Création');

-- Données de test pour la table sousCategorie
INSERT INTO sousCategorie (nom_sousCategorie, id_categorieemploie) VALUES 
('Gestion de Projet', '00000000000000000000000000000000000000000000000001'),
('Développement', '00000000000000000000000000000000000000000000000002'),
('Design', '00000000000000000000000000000000000000000000000003');

-- Données de test pour la table poste
INSERT INTO poste (intitule, competence, conditiontravail, mission, responsabilite, tache, remuneration, avantage, id_sousCategorie) VALUES 
('Chef de Projet', 'Gestion de projets', 'Temps plein', 'Superviser les projets', 'Diriger une équipe', 'Gérer les plannings', 4000, 'Assurance santé', '00000000000000000000000000000000000000000000000004'),
('Développeur Web', 'Programmation web', 'Temps plein', 'Développer des applications', 'Collaborer avec les équipes', 'Coder des fonctionnalités', 3000, 'Assurance santé', '00000000000000000000000000000000000000000000000005'),
('Designer UI/UX', 'Conception graphique', 'Temps plein', 'Concevoir des interfaces', 'Assurer une bonne expérience utilisateur', 'Créer des maquettes', 3500, 'Assurance santé', '00000000000000000000000000000000000000000000000006');

-- Données de test pour la table devise
INSERT INTO devise (nom_devise) VALUES 
('USD'),
('EUR'),
('MGA');

-- Données de test pour la table change
INSERT INTO change (ariary, valeur_change, id_devise) VALUES 
(5000, 1, '000000000000000000000000000000000000000000000001'),
(6000, 1, '000000000000000000000000000000000000000000000002'),
(1, 1, '000000000000000000000000000000000000000000000003');

-- Données de test pour la table Profil
INSERT INTO Profil (experience_min, experience_max, id_poste) VALUES 
(2, 5, '000000000000000000000000000000000000000000000001'),
(1, 3, '000000000000000000000000000000000000000000000002'),
(3, 6, '000000000000000000000000000000000000000000000003');

-- Données de test pour la table Diplome
INSERT INTO Diplome (nom_diplome) VALUES 
('Licence Informatique'),
('Master en Gestion'),
('Diplôme en Design');

-- Données de test pour la table detailProfil
INSERT INTO detailProfil (id_diplome, id_profil) VALUES 
('000000000000000000000000000000000000000000000001', '000000000000000000000000000000000000000000000001'),
('000000000000000000000000000000000000000000000002', '000000000000000000000000000000000000000000000002'),
('000000000000000000000000000000000000000000000003', '000000000000000000000000000000000000000000000003');

-- Données de test pour la table besoinGlobal
INSERT INTO besoinGlobal (date_validtion, quantite_total, id_profil) VALUES 
('2024-10-01', '10', '000000000000000000000000000000000000000000000001'),
('2024-11-15', '5', '000000000000000000000000000000000000000000000002');

-- Données de test pour la table Fournisseur
INSERT INTO Fournisseur (adresse, nom, nom_entreprise, email, telephone, antecedent) VALUES 
('123 rue du Centre', 'Jean Dupont', 'Entreprise A', 'contact@entrepriseA.com', 123456789, 'Fournisseur expérimenté'),
('456 avenue du Marché', 'Marie Durand', 'Entreprise B', 'contact@entrepriseB.com', 987654321, 'Fournisseur fiable');

-- Données de test pour la table DemandeProforma
INSERT INTO DemandeProforma (DateDemande_proforma) VALUES 
('2024-10-01'),
('2024-10-15');

-- Données de test pour la table BonCommande
INSERT INTO BonCommande (date_bonCommande) VALUES 
('2024-10-05'),
('2024-10-20');

-- Données de test pour la table users
INSERT INTO users (email_user, password_user, id_poste, id_departement) VALUES 
('admin@recrutement.com', 'password123', '00000000000000000000000000000000000000000000000010', '00000000000000000000000000000000000000000000000002'),
('user@recrutement.com', 'password123', '00000000000000000000000000000000000000000000000012', '00000000000000000000000000000000000000000000000003');

-- Données de test pour la table besoinProfil
INSERT INTO besoinProfil (date_demande, quantite, id_profil, id_users) VALUES 
('2024-10-01', '3', '000000000000000000000000000000000000000000000001', '000000000000000000000000000000000000000000000001');

-- Données de test pour la table besoinChecked
INSERT INTO besoinChecked (dateChecck, id_besoinProfil, id_besoinGlobal) VALUES 
('2024-10-10', '000000000000000000000000000000000000000000000001', '000000000000000000000000000000000000000000000001');

-- Données de test pour la table Proforma
INSERT INTO Proforma (date_emission, date_expiration, total, id_fournisseur, id_demandeProforma) VALUES 
('2024-10-05', '2024-11-05', 5000, '000000000000000000000000000000000000000000000001', '000000000000000000000000000000000000000000000001');

INSERT INTO departements (nom_departement) VALUES ('Ressources Humaines');
INSERT INTO departements (nom_departement) VALUES ('Informatique');
INSERT INTO departements (nom_departement) VALUES ('Finance');
INSERT INTO departements (nom_departement) VALUES ('Marketing');
INSERT INTO departements (nom_departement) VALUES ('Production');



-- Insertion dans la table categorieEmploie
INSERT INTO categorieEmploie (nom_categorieemploie) VALUES ('Technologie');
INSERT INTO categorieEmploie (nom_categorieemploie) VALUES ('Gestion');
INSERT INTO categorieEmploie (nom_categorieemploie) VALUES ('Finance');
INSERT INTO categorieEmploie (nom_categorieemploie) VALUES ('Marketing');




-- Insertion dans la table sousCategorie
INSERT INTO sousCategorie (nom_sousCategorie, id_categorieemploie) VALUES ('Développement Web', '00001');
INSERT INTO sousCategorie (nom_sousCategorie, id_categorieemploie) VALUES ('Gestion de Projet', '00002');
INSERT INTO sousCategorie (nom_sousCategorie, id_categorieemploie) VALUES ('Comptabilité', '00003');
INSERT INTO sousCategorie (nom_sousCategorie, id_categorieemploie) VALUES ('Analyse de Données', '00001');






-- Insertion dans la table poste
INSERT INTO poste (intitule, competence, conditiontravail, mission, responsabilite, tache, remuneration, avantage, id_sousCategorie) 
VALUES ('Développeur Full Stack', 
        'Compétences en JavaScript, HTML, CSS, et Node.js', 
        'Travail en équipe, horaires flexibles', 
        'Développer des applications web', 
        'Responsabilité des projets de A à Z', 
        'Développement, test et déploiement', 
        60000, 
        'Assurance santé, prime de performance', 
        '00001');

INSERT INTO poste (intitule, competence, conditiontravail, mission, responsabilite, tache, remuneration, avantage, id_sousCategorie) 
VALUES ('Chef de Projet Senior', 
        'Compétences en gestion de projet et planification', 
        'Travail à distance possible', 
        'Superviser la mise en œuvre des projets', 
        'Responsabilité de la gestion des délais', 
        'Suivi de projet et gestion des ressources', 
        70000, 
        'Voiture de fonction, assurance vie', 
        '00002');

INSERT INTO poste (intitule, competence, conditiontravail, mission, responsabilite, tache, remuneration, avantage, id_sousCategorie) 
VALUES ('Comptable', 
        'Compétences en comptabilité et analyse financière', 
        'Travail sous pression', 
        'Gérer les comptes et la comptabilité de l\'entreprise', 
        'Responsabilité de la gestion des états financiers', 
        'Tenue de la comptabilité, préparation des rapports financiers', 
        65000, 
        'Prime annuelle, assurance santé', 
        '00003');






-- Insertion dans la table users
INSERT INTO users (email_user, password_user, id_poste, id_departement) 
VALUES ('johndoe@example.com', 'pass', '00001', '00002');

INSERT INTO users (email_user, password_user, id_poste, id_departement) 
VALUES ('janedoe@example.com', 'pass', '00002', '00001');

INSERT INTO users (email_user, password_user, id_poste, id_departement) 
VALUES ('jeanne@example.com', 'pass', '00001', '00001');

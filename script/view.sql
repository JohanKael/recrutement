CREATE OR REPLACE VIEW v_talentposte AS (
    SELECT 
        tlt.id_demandetalent ,
        tlt.datedemandetalent,
        tlt.description_talent,
        tlt.objectif,
        tlt.qualification,
        tlt.ischecked,
        tlt.datechecktalent,
        pst.id_poste ,
        pst.intitule,
        pst.competence,
        pst.conditiontravail,
        pst.mission,
        pst.responsabilite,
        pst.tache,
        pst.remuneration,
        pst.avantage
    FROM demandetalent AS tlt
    LEFT JOIN poste AS pst ON pst.id_poste = tlt.id_poste
);


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_BonCommande extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dao_model', 'dao');
    }


/* FONCTION POUR CHERCHER UN PROFORMA SI LE FOURNISSEUR A DEJA REPONDU */
    public function bon_commande() {
        $id_demandeProforma = $this->input->post('numerodemandeproforma');          //recup de id de demande de proforma à chercher 
        
        if (empty($id_demandeProforma)) {
            $this->session->set_flashdata('checkValidation', [                      //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                               //int de validation si champ vide = 0
                'message' => "Veuillez remplir au moins un champ les champs !"      //message de validation pour page Validation.php
            ]); 
            redirect('proforma/C_Proforma/page_bonCommande');                       //redirection vers la fonction page_bonCommande
        } else {
            //requete pour avoir ces infos de la view v_info_demandeproforma
            $sql = "SELECT 
                        id_demandeproforma,
                        id_proforma,
                        datedemande_proforma,
                        objetdemandeproforma,
                        nom_entreprise,
                        id_fournisseur 
                    FROM 
                        v_info_demandeproforma
                    WHERE id_proforma IS NOT NULL
                    AND id_demandeproforma = '".$id_demandeProforma."'
                    GROUP BY id_proforma, id_demandeproforma,
                    id_proforma, datedemande_proforma, objetdemandeproforma, nom_entreprise, id_fournisseur";
            $liste_proforma = $this->dao->executeQuery($sql);                       //contient liste des proformas
            
            $tab_detailProforma = array();
            for ($i=0; $i < count($liste_proforma); $i++) {
                $condition = [                                                                          //recup les listes des details de proformas à afficher pour choix de fournisseur
                    'id_proforma'=>trim($liste_proforma[$i]['id_proforma']),
                    'id_fournisseur'=>trim($liste_proforma[$i]['id_fournisseur']) 
                ];
                $list_proforma = $this->dao->select_where('v_info_detailproforma',  $condition);        //infos sur materiels pour choix fournisseur 
                $tab_detailProforma[$i] = $list_proforma;
            }
            
            $data['pageTitle'] = "Bon de Commande";                     //titre de la page de destination
            $data['pageToLoad'] = "boncommande/BonCommande_Add";        //path de a page de destination
            $data['liste_proforma'] = $tab_detailProforma;              //liste des proformAS
            
            $this->load->view('home/Home', $data);                      //page principale où on load les pages
        }
    }

/* FONCTION POUR AVOIR DETAIL DE BON DE COMMANDE POUR LAST CHECKING DES CHOIX DE FOURNISSEURS Où ON VEUT ACHETER LES MATERIELS */
    public function afficher_bonCommande() {
        $size = $this->input->post('size');                             //taille du nombre de materiels à acheter
        $materiel = $this->input->post('materiel');                     //id des matériels à acheter
        $fournisseurs = [];                                             //initiation de table qui contiendra id des fournisseurs
        $selectedProformas = [];                                        //initiation de table qui contiendra id des proformas
    
        $data['liste_detailProforma'] = array();
        for ($i = 0; $i < $size; $i++) {
            $selectedCheckboxes = $this->input->post('selected_proforma_' . $i);    //recup id de fournisseur et id de proforma
            if ($selectedCheckboxes) {                                              //si toutes les checkbox sont cochés 
                foreach ($selectedCheckboxes as $value) {                           
                    list($id_proforma, $id_fournisseur) = explode('|', $value);     //division de id_fournisseur & id_proforma par "|"
                    $selectedProformas[$i] = $id_proforma;                          //stockage des id de proformas
                    $fournisseurs[$i] = $id_fournisseur;                            //stockage des id de fournisseurs
                }
            } else {
                $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                    'intValidation' => 0,                                   //int de validation si tsisy fournisseur
                    'message' => "Veuillez choisir les fournisseurs !"      //message de validation pour page Validation.php
                ]); 
                redirect('proforma/C_Proforma/page_rechercheProforma');     //redirection vers la fonction page_rechercheProforma
            }
        }
        
        $liste_infodetailProforma = $this->getInfoDetailProforma($selectedProformas, $materiel, $fournisseurs);
        $data['pageTitle'] = "Bon de Commande Détail";                      //titre de la page de destination
        $data['pageToLoad'] = "boncommande/BonCommande_Detail";             //path de a page de destination
        $data['liste_detailproforma'] = $liste_infodetailProforma   ;       //liste des proformas correspondant aux achats
        
        $this->load->view('home/Home', $data);                      //page principale où on load les pages
    }

/* FONCTION POUR AVOIR LE id_detailproformas POUR CHAQUE ACAHT CHEZ UN FOURNISSEUR
    Arguments : 
        - $selectedProformas : tableau contenant les id des proformas où on va acheter materiels
        - $materiel : tableau contenant les id des matériels à acheter
*/
    public function getDetailProforma($selectedProformas, $materiel) {
        $detail_proforma = array();
        for ($i=0; $i<count($materiel); $i++) {
            //unique dans table detailproforma
            $condition = [
                'id_materiels' => $materiel[$i],
                'id_proforma' => $selectedProformas[$i]
            ];
            $detail_proforma[$i] = $this->dao->select_where('detailproforma', $condition);
        }
        return $detail_proforma;
    }

/* FONCTION POUR RECUP LES INFOS CONCERNANT LES PRFORMAS CORRESPONDANT AU CHOIX DES FOURNISSEURS Où ON VA ACHETER LES MATERIELS 
    Arguments : 
        - $selectedProformas : tableau contenant les id des proformas où on va acheter materiels
        - $materiel : tableau contenant les id des matériels à acheter
        - $fournisseurs : tableau contenant les id des fournisseurs à qui acheter les materiels
*/
    public function getInfoDetailProforma($selectedProformas, $materiel, $fournisseurs) {
        $detail_proforma = array();
        for ($i=0; $i<count($materiel); $i++) {
            $condition = [                                  //creation de condition pour requete select_where
                'id_materiels' => $materiel[$i],
                'id_proforma' => $selectedProformas[$i],
                'id_fournisseur' => $fournisseurs[$i]
            ];
            $detail_proforma[$i] = $this->dao->select_where('v_info_detailproforma', $condition);   //recup des 3 proformas avec toutes infos où on va acheter materiels
        }
        return $detail_proforma;
    }

/* FONCTION POUR AJOUTER UN BON DE COMMANDE */
    public function ajout_bonCommande() {   
        $materiel = $this->input->post('materiel');                 //recup des id des materiels à acheter
        $proforma = $this->input->post('proforma');                 //recup des id des proformas des matieres pour chercher id detailproforma
        $dateBonCommande = $this->input->post('dateBonCommande');   //date de bon de commande
        
        $checkDateBonCommande = $this->checkLastDateProforma($dateBonCommande, $proforma);                          //checking si date de bon de commande valide
        $checkInsertBonCommande = $this->getIdBonCommande($dateBonCommande);                                        //insertion de bon de commande contient true
        $liste_detailProforma = $this->getDetailProforma($proforma, $materiel);                                     //recup des details proforma
        $checkInsertDetailBonCommande = $this->insert_detailBonCommande($liste_detailProforma, $checkInsertBonCommande);    //insertion des details de bon commande
        
        $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
            'intValidation' => 0,                                   //int de validation si tsisy fournisseur
            'message' => "Enregistrement du bon de commande réussi !"      //message de validation pour page Validation.php
        ]); 
        redirect('proforma/C_Proforma/page_rechercheProforma');     //redirection vers la fonction page_rechercheProforma
    }

/* FONCTION POUR CHECKER SI DATE DE BON DE COMMANDE EST ANTERIEURE A DATE LAST EMISSION DE PROFORMA
    Argument : 
        - $dateBonCommande : date de bon de commande
        - $proforma : liste des id des proformas avec lesquelles on va faire requete pour recup date max(date_emission)
*/
    public function checkLastDateProforma($dateBonCommande, $proforma) {
        $sql = "SELECT max(date_emission) 
                FROM v_infodetail_demandeproforma
                WHERE id_proforma = '";
        foreach ($proforma as $index => $oneproforma) {
            if ($index == count($proforma)-1) {
                $sql = $sql.trim($oneproforma)."'";
            } else {
                $sql = $sql.trim($oneproforma)."' OR id_proforma ='";
            }
        }
        $lastDateEmissionProforma = $this->dao->executeQuery($sql);                     //recup de derniere date d'emission de proforma
        $dateEmissionProformaCast = strtotime($lastDateEmissionProforma[0]['max']);     //cast de date emission de proforma
        $dateBonCommandeCast = strtotime($dateBonCommande);                             //cast de date de bon de commande

        if ($dateBonCommandeCast < $dateEmissionProformaCast) {
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si tsisy fournisseur
                'message' => "La date de bon de commande doit être ultérieure à la date dernière d'emission de proforma !"      //message de validation pour page Validation.php
            ]); 
            redirect('proforma/C_Proforma/page_rechercheProforma');     //redirection vers la fonction page_rechercheProforma
        }
        return true;
    }

/* FONCTION POUR INSERER LE BON DE COMMANDE ET AVOIR L'ID DU BON DE COMMANDE POUR INSERER LES DETAILS BON DE COMMANDES APRES 
    Argument : 
        - $dateBonCommande : date de bon de commande
*/
    public function getIdBonCommande($dateBonCommande) {
        $primaryKey = $this->dao->primaryKeyWithSequence('seq_detailboncommande', 'BNCMD');            //primary key pour la table boncommande
        $to_insert = [                                                                                  //data à insérer dans table boncommande
            'id_boncommande' => $primaryKey,    
            'date_boncommande' => $dateBonCommande
        ];
        $checkInsertBonCommande = $this->dao->saveData('boncommande', $to_insert, 'id_boncommande');    //contient id normalement
        if ($checkInsertBonCommande === false) {
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si tsisy fournisseur
                'message' => "Enregistrement de bon de commande a echoué ! "      //message de validation pour page Validation.php
            ]); 
            redirect('proforma/C_Proforma/page_rechercheProforma');     //redirection vers la fonction page_rechercheProforma
        }
        return $checkInsertBonCommande;                                 //return id de bon de commande
    }

/* FONCTION POUR INSERER LES DETAILS DE CON DE COMMANDE
    Arguments : 
        - $liste_detailProforma : liste des details de proforma
        - $id_bonCommande : id du bon de commande
*/
    public function insert_detailBonCommande($liste_detailProforma, $id_bonCommande) {
        foreach ($liste_detailProforma as $detailProforma) {
            $primaryKey = $this->dao->primaryKeyWithSequence('seq_detailboncommande', 'DTLCMD');            //primary key pour la table detail_boncommande
            $to_insert = [
                'id_detailboncommande' => $primaryKey,
                'id_detailproforma' => $detailProforma[0]['id_detailproforma'],
                'id_boncommande' => $id_bonCommande
            ];
            $checkInsertDetailBonCommande = $this->dao->insert_into('detail_boncommande', $to_insert);       //insertion de detail bon commande
            if ($checkInsertDetailBonCommande === false) {
                $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                    'intValidation' => 0,                                   //int de validation si tsisy fournisseur
                    'message' => "Enregistrement des détails de bon de commande a echoué ! "      //message de validation pour page Validation.php
                ]); 
                redirect('proforma/C_Proforma/page_rechercheProforma');     //redirection vers la fonction page_rechercheProforma
            }
        }
        return true;
    }
}

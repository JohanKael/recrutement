<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Proforma extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dao_model', 'dao');
    }

/*  ========================================================================================================================== A PROPOS DE AJOUT DE DEMANDE DE BESOINS */
/* FONCTION DE REDIRECTION VERS LA PAGE DE LISTE DE BESOINS SANS DEMANDE DE PROFORMA
    ARGUMENTS : 
        - $checkValidation (tableau) : 
            .case 0 : champ vide                                => message : Veiullez remplir tous les champs !
            .case 1 : insertion réussie                         => message : Votre demande a été enregistrée !
            .case 2 : insertion raté                            => message : Votre demande a echoué !
            .case 3 : redirection de page                       => message : Aucun message
            .case 4 : insertion de validation de demande ratée  => message : Date Invalide!
            .case 5 : no fournisseur selected                   => message : Vous devez indiquer au moins 1 fournisseur !   
*/
	public function page_ListBesoinSansDemandeProforma($checkValidation = 3) {                              //initiena 3 par défaut pour la page Validation.php si non erreur
        $data['pageTitle'] = "Liste Demande Proforma";                                                      //titre de la page de destination
        $data['pageToLoad'] = "proforma/DemandeProforma_List";                                              //path de a page de destination
        $data['liste_demandeProforma'] = $this->dao->select_all('v_besoinglobal_sans_demandeprofroma');     //liste des demandes de besoins sans demande de proforma
        $data['checkValidation'] = $checkValidation;                                                        //tableau contenant int de validation avec le message qui lui correspond
        
		$this->load->view('home/Home', $data);                                                              //page principale où on load les pages
	}

/* FONCTION DE REDIRECTION VERS LA PAGE POUR FIRE PLUSIEURS DEMANDE DE PROFORMA
    ARGUMENTS : 
        - $checkValidation (tableau) : 
            .case 0 : champ vide                                => message : Veiullez remplir tous les champs !
            .case 1 : insertion réussie                         => message : Votre demande a été enregistrée !
            .case 2 : insertion raté                            => message : Votre demande a echoué !
            .case 3 : redirection de page                       => message : Aucun message
            .case 4 : insertion de validation de demande ratée  => message : Date Invalide!
            .case 5 : no fournisseur selected                   => message : Vous devez indiquer au moins 1 fournisseur !   
*/
    public function page_AjoutPlusieursDemandeProforma($checkValidation = 3) {                              //initiena 3 par défaut pour la page Validation.php si non erreur
        $data['pageTitle'] = "Liste Demande Proforma";                                                      //titre de la page de destination
        $data['pageToLoad'] = "proforma/DemandeProforma_AddPlusieurs";                                              //path de a page de destination
        $data['liste_demandeProforma'] = $this->dao->select_all('v_besoinglobal_sans_demandeprofroma');     //liste des demandes de besoins sans demande de proforma
        $data['liste_fournisseur'] = $this->dao->select_all('fournisseur');                                 //liste des fournisseurs
        $data['checkValidation'] = $checkValidation;                                                        //tableau contenant int de validation avec le message qui lui correspond
        
        $this->load->view('home/Home', $data);                                                              //page principale où on load les pages
    }

/* FONCTION POUR INSERER UNE DEMANDE DE PROFORMAT */
    public function ajout_plusieursDemandeProforma() {
        $demandeProformaSelectionnees = $this->input->post('demandeProforma');  // Récupérer les valeurs sélectionnées pour les demandes de proforma
        $fournisseursSelectionnes = $this->input->post('fournisseur');          // Récupérer les valeurs sélectionnées pour les fournisseurs
        $dateDemandeProforma = $this->input->post('dateDemandeProforma');       //date de demande de profroma
        $objet = $this->input->post('objet');                                   //objet de la demande de proforma genre global

        if (empty($dateDemandeProforma) || empty($objet)) {
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si champ vide = 0
                'message' => "Veuillez remplir tous les champs !"       //message de validation pour page Validation.php
            ]); 
        } else if (empty($demandeProformaSelectionnees) ||                                  //si une des valeurs dans l'insertion est nulle ou vide
            empty($fournisseursSelectionnes)) {  
                $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                    'intValidation' => 0,                                   //int de validation si champ vide = 0
                    'message' => "Veuillez remplir au moins 1 besoin et 1 fournisseurs !"       //message de validation pour page Validation.php
                ]); 
        } else {
            $checkDateValide = $this->compareDateDemandeProformAndDateValidationBesoin($demandeProformaSelectionnees, $dateDemandeProforma);                    //contient la date valide d'insertion pour insertion de demande de proforma
            $checkInsertDemandeProforma = $this->insertDemandeProforma($checkDateValide, $objet);                                                                       //contient normalement id de demande de proforma qui vient d'etre inserer
            $checkInsertProformaFournisseur = $this->insertDemandeProformaFournisseur($checkInsertDemandeProforma, $fournisseursSelectionnes);                  //contient boolean true sin insertion s'est bien passé
            $checkInsertDemandeProformaBesoinGlobal = $this->insertDemandeProformaBesoinGlobal($checkInsertDemandeProforma, $demandeProformaSelectionnees);     //contient boolean true sin insertion s'est bien passé
            
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si insertion réussi = 0
                'message' => "Demande(s) de proforma enregristée(s) avec succès!"       //message de validation pour page Validation.php
            ]); 
        } 
        redirect('proforma/C_Proforma/page_AjoutPlusieursDemandeProforma');                   //redirection vers la fonction page_AjoutBesoin
    }

/* FONCTION POUR VOIR LA DERNIERE DATE DE VALIDATION DES BESOINS GLOBALS SELECTIONNE
    ARGUMENT : 
        - $demandeProformaSelectionnees : les id des besoins globales selectionnée
*/
    public function getLastDateOfBesoinGlobal($demandeProformaSelectionnees) {
        //CRAFT LA REQUETE POUR AVOIR LA MAX DATE ENTRE LES ID SELECTIONNE
        $sql = "SELECT  
                    MAX(datevalidation) AS derniere_datevalidation
                FROM v_besoinglobal_sans_demandeprofroma
                WHERE ";
        for ($i = 0 ; $i < count($demandeProformaSelectionnees); $i++) {
            if ($i != count($demandeProformaSelectionnees) - 1) {
                $sql = $sql." id_besoinglobal =  '".$demandeProformaSelectionnees[$i]."' OR";
            } else {
                $sql = $sql." id_besoinglobal =  '".$demandeProformaSelectionnees[$i]."'";
            }
        }

        $result = $this->dao->executeQuery($sql);                           //recup de la date mais contenu dans un tableau
        $derniere_datevalidation = $result[0]['derniere_datevalidation'];   //date tsotra
        if ($derniere_datevalidation === false) {                           //si ts date no averiny = tsisy le date
            return false;                                                   //on retourne false
        }
        return $derniere_datevalidation;                                    //sinon averina le date
    }

/* FONCTION POUR COMPARER LA DATE DE DEMANDE DE PROFORMA ET LA DATE DE VALIDATION DU BESOIN GLOBAL
    ARGUMENT : 
        - $demandeProformaSelectionnees : les id des besoins globales selectionnée
        - $dateDemandeProforma : date de demande proforma
*/
    public function compareDateDemandeProformAndDateValidationBesoin($demandeProformaSelectionnees, $dateDemandeProforma) {
        $derniere_datevalidation = $this->getLastDateOfBesoinGlobal($demandeProformaSelectionnees);     //recup de la derniere date de validation de besoin global
        $derniere_datevalidationCast = strtotime($derniere_datevalidation);                                 //cast en date de derniere date de validation de la BDD

        $dateDemandeProformaCast = strtotime($dateDemandeProforma);                                         //cast en date de la date de demande de proforma

        if  ($dateDemandeProformaCast < $derniere_datevalidationCast) { //si date de demande de proforma antérieure à date de derniere validation de besoin
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si Date invalide = 0
                'message' => "Date invalide, la date de demande de proforma doit être ultérieure à la dernière date de validation de besoin !"       //message de validation pour page Validation.php
            ]); 
            redirect('proforma/C_Proforma/page_AjoutPlusieursDemandeProforma');                   //redirection vers la fonction page_AjoutBesoin                                    //alors date non valide
        }

        return $dateDemandeProforma;                                            //date valide
    }

/* FONCTION POUR INSERER LA DEMANDE DE PROFORMA POUR RECUPERER L'ID ENSUITE POUR INSERTION DANS TABLE DE LIAISON 
demandeproforma_fournisseur & besoinglobale_demandeproforma*/
    public function insertDemandeProforma($datedemande_proforma, $objet_demandeproforma) {
        $primaryKey = $this->dao->primaryKeyWithSequence('seq_demandeproforma', 'DMDPRFM');     //primary key de la table demandeproforma
        $to_insert = [
            'id_demandeproforma' => $primaryKey,
            'datedemande_proforma' => $datedemande_proforma,
            'objetdemandeproforma' => $objet_demandeproforma
        ];
        $checkInsertDemandeProforma = $this->dao->saveData('demandeproforma', $to_insert, 'id_demandeproforma');      //insertion de la demande de proforma
        if ($checkInsertDemandeProforma === false) {
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si Date invalide = 0
                'message' => "Echec de l'enregistrement de la demande de proforma  !"       //message de validation pour page Validation.php
            ]); 
            redirect('proforma/C_Proforma/page_AjoutPlusieursDemandeProforma');                   //redirection vers la fonction page_AjoutBesoin                                    //alors date non valide
        }
        return $checkInsertDemandeProforma;
    }

/* FONCTION POUR INSERER DANS TABLE demandeproforma_fournisseur */
    public function insertDemandeProformaFournisseur ($id_demandeProforma, $fournisseursSelectionnes) {
        //craft et insertion dans table demandeproforma_fournisseur
        foreach ($fournisseursSelectionnes as $fournisseurId) {
            $to_insert = [                                 
                'id_fournisseur' => $fournisseurId,                                     //craft des datas à inserer
                'id_demandeproforma' => $id_demandeProforma
            ];
            $checkInsert = $this->dao->insert_into('demandeproforma_fournisseur', $to_insert);  //retourne normalement un int
            if ($checkInsert === false) {
                $this->session->set_flashdata('checkValidation', [                      //on fait revenir vers la page d'insertion avec un popup d'erreur 
                    'intValidation' => 0,                                               //int de validation si insertion ts nety = 0
                    'message' => "Echec proforma fournisseur !"                         //message de validation pour page Validation.php
                ]); 
                redirect('proforma/C_Proforma/page_AjoutPlusieursDemandeProforma');     //redirection vers la fonction page_AjoutBesoin                                    //alors date non valide
            }
        }
        return true;                                                                    //isenrtion réussi            
    }

/* FONCTION POUR INSERER DANS TABLE besoinglobale_demandeproforma */
    public function insertDemandeProformaBesoinGlobal ($id_demandeProforma, $demandeProformaSelectionnees) {
        //craft et insertion dans table besoinglobale_demandeproforma
        foreach ($demandeProformaSelectionnees as $id_besoinglobal) {
            $to_insert = [                          
                'id_besoinglobal' => $id_besoinglobal,                                            //craft des datas à inserer
                'id_demandeproforma' => $id_demandeProforma
            ];
            $checkInsert = $this->dao->insert_into('besoinglobale_demandeproforma', $to_insert);  //retourne normalement un int
            if ($checkInsert === false) {
                $this->session->set_flashdata('checkValidation', [                      //on fait revenir vers la page d'insertion avec un popup d'erreur 
                    'intValidation' => 0,                                               //int de validation si insertion ts nety = 0
                    'message' => "Echec proforma besoin global !"                         //message de validation pour page Validation.php
                ]); 
                redirect('proforma/C_Proforma/page_AjoutPlusieursDemandeProforma');     //redirection vers la fonction page_AjoutBesoin                                    //alors date non valide
            }
        }
        return true;                                                                    //isenrtion réussi            
    }

    
    
/* ======================================================================================================= A PROPOS DE RECHRECHE DE PROFORMA*/
/* FONCTION POUR REDIRIGER VERS LA PAGE DE RECHERCHE DE PROFORMA DEJA FOURNIT PAR FOURNISSEUR
    ARGUMENTS : 
        - $checkValidation (tableau) : 
            .case 3 : redirection de page                       => message : Aucun message  
*/
    public function page_rechercheProforma($checkValidation = 3) {  //initiena 3 par défaut pour la page Validation.php si non erreur
        $data['pageTitle'] = "Proforma Fournisseur";                //titre de la page de destination
        $data['pageToLoad'] = "proforma/Proforma_List";             //path de a page de destination
        $data['checkValidation'] = $checkValidation;                //tableau contenant int de validation avec le message qui lui correspond
        $data['liste_proforma'] = array();                          //initiena vide pour le premier load de la page

        $this->load->view('home/Home', $data);                      //page principale où on load les pages
    }

/* FONCTION POUR CHERCHER UN PROFORMA SI LE FOURNISSEUR A DEJA REPONDU */
    public function recherche_proforma() {
        $id_demandeProforma = $this->input->get('numerodemandeproforma');   //recup de id de demande de proforma à chercher 
        $dateDemandeProforma = $this->input->get('dateDemandeProforma');    //recup de date de demande de proforma à chercher
        
        if (empty($id_demandeProforma) && empty($dateDemandeProforma)) {
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si champ vide = 0
                'message' => "Veuillez remplir au moins un champ les champs !"       //message de validation pour page Validation.php
            ]); 
            redirect('proforma/C_Proforma/page_rechercheProforma');     //redirection vers la fonction page_rechercheProforma
        } else {
            $sql = $this->craftRequestSqlForSearching($id_demandeProforma, $dateDemandeProforma);   //contient requete pour retrouver requete proforma
            $liste_proforma = $this->getListeProforma($sql);                                        //contient liste des proformas
            $this->redirectAfterSearch($liste_proforma);                                      //redirection vers la fonction page_rechercheProforma
        }
    }

/* FONCTION POUR REDIRIGER VERS LA PAGE DE RECHERCHE AVEC LES RESULTAT APRES LA RECHERCHER */
    public function redirectAfterSearch($liste_proforma) {  //liste des resultats des recherches
        $data['pageTitle'] = "Proforma Fournisseur";        //titre de la page de destination
        $data['pageToLoad'] = "proforma/Proforma_List";     //path de a page de destination
        $data['liste_proforma'] = $liste_proforma;          //liste des proformAS

        $this->load->view('home/Home', $data);              //page principale où on load les pages

    }

/* FONCTION POUR CRAFT LA REQUETE POUR RECUPERER LES PROFORMA SI ELLES EXISTENT EN FONCTION DE LA DATE OU DE ID DE DEMANDE DE PROFORMA */
    public function craftRequestSqlForSearching($id_demandeProforma, $dateDemandeProforma) {
        $sql = false;
        if (!empty($id_demandeProforma) && !empty($dateDemandeProforma)) {          //si 2 critères ne sont pas vide
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
                    AND datedemande_proforma = '".$dateDemandeProforma."'
                    GROUP BY id_proforma, id_demandeproforma,
                    id_proforma, datedemande_proforma, objetdemandeproforma, nom_entreprise, id_fournisseur";
        } else if (!empty($id_demandeProforma) && empty($dateDemandeProforma)) {    //si id de proforma pas vide
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
        } else {                                                                     //si date de demande de proforma pas vide
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
                    AND datedemande_proforma = '".$dateDemandeProforma."'
                    GROUP BY id_proforma, id_demandeproforma,
                    id_proforma, datedemande_proforma, objetdemandeproforma, nom_entreprise, id_fournisseur";
        }
        return $sql;
    }
    
/* FONCTION POUR RECUP LES PROFORMAS DEJA EXISTANTS */
    public function getListeProforma($sql) {
        $liste_proforma = $this->dao->executeQuery($sql);       //liste des proformas correspondant à la date et/ou au besoin
        
        if (empty($liste_proforma)) {
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si tsisy proforma
                'message' => "Aucun proforma n'a encore été fourni !"   //message de validation pour page Validation.php
            ]); 
            redirect('proforma/C_Proforma/page_rechercheProforma');     //redirection vers la fonction page_rechercheProforma
        } 
        return $liste_proforma;                                 //si misy alors on retourne la liste
    }

/* FONCTION POUR CHECKER SI IL EXISTE DEJA UN BON DE COMMANDE POUR LA DEMANDE DE PROFORMA EN ARGUMENT */
    public function checkBonCommande($id_demandeProforma) {
        //requete pour check si efa misy bon de commande pour ce demande de proforma
        $sql = "SELECT 
                id_demandeProforma, 
                id_proforma, 
                id_detailProforma,
                id_detailboncommande,
                id_boncommande,
                DateDemande_proforma, 
                objetDemandeProforma, 
                nom_entreprise, 
                id_fournisseur
            FROM v_checkProforma
            WHERE id_proforma IS NOT NULL 
            AND id_detailboncommande IS NOT NULL 
            AND id_demandeProforma = '".$id_demandeProforma."'
            GROUP BY 
                id_demandeProforma, 
                id_proforma, 
                id_detailProforma,
                id_detailboncommande,
                id_boncommande,
                DateDemande_proforma, 
                objetDemandeProforma, 
                nom_entreprise, 
                id_fournisseur";
        $checkBonCommande = $this->dao->executeQuery($sql);     //contient la liste des bon de commnde ou tableau vide
        $isBonCommande = false;                                 //boolean checking pour afficher le bouton pour faire un bon de commande
        if (!empty($checkBonCommande)) {                        //si tableau pas vide -> il existe bon de commande
            $isBonCommande = true;                              //checking pour bouton = true => on n'afiche pas bouton
        }
        return $isBonCommande;
    }

/* FONCTION POUR AVOIR LES DETAILS DES PROFORMAS CONCERNANT 1 BESOIN */
    public function detail_proforma($id_proforma, $id_fournisseur, $id_demandeProforma) {
        $condition = [ 'id_proforma'=>trim($id_proforma),                                   
                        'id_fournisseur'=>$id_fournisseur ];
        $list_proforma = $this->dao->select_where('v_info_detailproforma',  $condition);
        $tva = ($list_proforma[0]['total'] * 20) / 100;
        
          //initiena 3 par défaut pour la page Validation.php si non erreur
        $data['pageTitle'] = "Proforma Detail";                //titre de la page de destination
        $data['pageToLoad'] = "proforma/Proforma_Detail";             //path de a page de destination
        $data['liste_detailProforma'] = $list_proforma;                          //initiena vide pour le premier load de la page
        $data['tva'] = $tva;
        $data['total'] = $tva + $list_proforma[0]['total'];

        $sql = "SELECT 
                    id_fournisseur,
                    nom,
                    id_users,
                    nom_entreprise
                FROM v_info_demandeproforma 
                WHERE id_proforma IS NOT NULL AND id_demandeProforma = '".$id_demandeProforma."'";
        $data['liste_fournisseur'] = $this->dao->executeQuery($sql);
        
        $data['fournisseur_selected'] = $id_fournisseur;
        $data['demandeProforma'] = $id_demandeProforma;

        $data['isBonCommande'] = $this->checkBonCommande($id_demandeProforma);  //check si il y a deja un bon de commande pour ce demande de proforma      
        
        $this->load->view('home/Home', $data);                      //page principale où on load les pages
    }

/* FONCTION POUR AVOIR LES DETAILS DES PROFORMAS CONCERNANT 1 BESOIN */
    public function next_fournisseur() {
        $id_fournisseur = $this->input->get('fournisseur');
        $id_demandeProforma = $this->input->get('demandeproforma');
        $sql = "SELECT id_proforma
                FROM v_info_demandeproforma 
                WHERE id_proforma IS NOT NULL AND id_demandeProforma = '".$id_demandeProforma."'
                AND id_fournisseur = '".$id_fournisseur."'";
        $data['liste_proforma'] = $this->dao->executeQuery($sql);
        
        $id_proforma = $data['liste_proforma'][0]['id_proforma'];

        $condition = [ 'id_proforma'=>trim($id_proforma),
                        'id_fournisseur'=>$id_fournisseur ];
        $list_proforma = $this->dao->select_where('v_info_detailproforma',  $condition);
        $tva = ($list_proforma[0]['total'] * 20) / 100;
        //initiena 3 par défaut pour la page Validation.php si non erreur
        $data['pageTitle'] = "Proforma Detail";                //titre de la page de destination
        $data['pageToLoad'] = "proforma/Proforma_Detail";             //path de a page de destination
        $data['liste_detailProforma'] = $list_proforma;                          //initiena vide pour le premier load de la page
        $data['tva'] = $tva;
        $data['total'] = $tva + $list_proforma[0]['total'];

        $sql = "SELECT 
                    id_fournisseur,
                    nom,
                    id_users,
                    nom_entreprise
                FROM v_info_demandeproforma 
                WHERE id_proforma IS NOT NULL AND id_demandeProforma = '".$id_demandeProforma."'";
        $data['liste_fournisseur'] = $this->dao->executeQuery($sql);
        
        $data['isBonCommande'] = $this->checkBonCommande($id_demandeProforma);  //check si il y a deja un bon de commande pour ce demande de proforma
        
        $data['fournisseur_selected'] = $id_fournisseur;
        $data['demandeProforma'] = $id_demandeProforma;

        $this->load->view('home/Home', $data);                      //page principale où on load les pages
    }



}

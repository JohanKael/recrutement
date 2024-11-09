<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ProformaFournisseur extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dao_model', 'dao');
    }

/*  ========================================================================================================================== A PROPOS DE AJOUT DE DEMANDE DE PROFORMA */
/* FONCTION DE REDIRECTION VERS LA PAGE DE LISTE DE DEMANDE DE PROFORMA
    ARGUMENTS : 
        - $checkValidation (tableau) : 
            .case 0 : champ vide                                => message : Veiullez remplir tous les champs !
            .case 1 : insertion réussie                         => message : Votre demande a été enregistrée !
            .case 2 : insertion raté                            => message : Votre demande a echoué !
            .case 3 : redirection de page                       => message : Aucun message
            .case 4 : insertion de validation de demande ratée  => message : Date Invalide!
            .case 5 : no fournisseur selected                   => message : Vous devez indiquer au moins 1 fournisseur !   
*/
	public function page_ListDemandeProformaFournisseur($checkValidation = 3) {         //initiena 3 par défaut pour la page Validation.php si non erreur
        $data['pageTitle'] = "Liste Demande Proforma";                                  //titre de la page de destination
        $data['pageToLoad'] = "fournisseur/FournisseurDemandeProforma_List";            //path de a page de destination
        $user_info = $this->session->userdata('user_info');

        $sql = "SELECT * FROM v_info_DemandeProforma WHERE id_proforma IS NULL AND id_users = '".$user_info['id_users']."'";    //requete pour avoir la liste des demande de proforma sans proforma
        $data['liste_demandeProformaSansProforma'] = $this->dao->executeQuery($sql);                //liste des fournisseurs
        $data['checkValidation'] = $checkValidation;                                    //tableau contenant int de validation avec le message qui lui correspond
        
		$this->load->view('home/Home', $data);                                          //page principale où on load les pages
	}

/* FONCTION POUR AVOIR LES DETAILS D'UNE DEMANDE DE PROFORMA
    ARGUMENT :
        - $id_demandeproforma : id du demande de proforma pour lequel on veut voir les détails des demandes
*/
    public function detail_demandeproforma($id_demandeproforma) {
        $data['pageTitle'] = "Détail Demande Proforma";                                                             //titre de la page de destination
        $data['pageToLoad'] = "fournisseur/FournisseurDemandeProforma_Detail";                                                    //path de a page de destination

        $user_info = $this->session->userdata('user_info');

        $sql = "SELECT * FROM v_infoDetail_DemandeProforma 
                WHERE id_users = '".$user_info['id_users']."' AND id_demandeproforma = '".$id_demandeproforma."'";      //requete pour avoir l'info sur une demande de proforma
        $data['detail_demandeProforma'] = $this->dao->executeQuery($sql);                                               //infos sur une demande de profroma
        
        $this->load->view('home/Home', $data);                                                                      //page principale où on load les pages
    }

/* FONCTION DE REDIRECTION VERS LA PAGE DE LISTE DE DEMANDE DE PROFORMA
    ARGUMENTS : 
        - $checkValidation (tableau) : 
            .case 0 : champ vide                                => message : Veiullez remplir tous les champs !
            .case 1 : insertion réussie                         => message : Votre demande a été enregistrée !
            .case 2 : insertion raté                            => message : Votre demande a echoué !
            .case 3 : redirection de page                       => message : Aucun message
            .case 4 : insertion de validation de demande ratée  => message : Date Invalide!
            .case 5 : no fournisseur selected                   => message : Vous devez indiquer au moins 1 fournisseur !   
*/
    public function page_ProformaFournisseur($checkValidation = 3) {         //initiena 3 par défaut pour la page Validation.php si non erreur
        $data['pageTitle'] = "Liste Demande Proforma";                       //titre de la page de destination
        $data['pageToLoad'] = "fournisseur/FournisseurProforma_Add";         //path de a page de destination
        $user_info = $this->session->userdata('user_info');
        $id_demandeProforma = $this->input->post('id_demandeProforma');      //id de la demande de proforma pour la requete de select   
        
        $sql = "SELECT * FROM v_infoDetail_DemandeProforma 
        WHERE id_users = '".$user_info['id_users']."' AND id_demandeproforma = '".$id_demandeProforma."'";      //requete pour avoir l'info sur une demande de proforma
        $data['detail_demandeProforma'] = $this->dao->executeQuery($sql);                                       //infos sur une demande de profroma
        $data['checkValidation'] = $checkValidation;                                    //tableau contenant int de validation avec le message qui lui correspond
        
        $this->load->view('home/Home', $data);                                          //page principale où on load les pages
    }


/* FONCTION POUR INSERER UNE DEMANDE DE PROFORMAT */
    public function ajout_proforma() {
        $dateEmission = $this->input->post('dateEmission');                     //date d'emission du proforma 
        $dateExpiration = $this->input->post('dateExpiration');                 //date d'expiration du proforma 
        $id_materiel = $this->input->post('materiel');                          //récupération de id des materiels to give prix unitaire 
        $prix_unitaire = $this->input->post('prixunitaire');                    //récupération des prix unitaires des matériels
        $quantite_materiel = $this->input->post('quantite');                    //récupération de la nombre/quantité du matériel à acheter  
        $id_demandeProforma = $this->input->post('demandeProforma');            //récupération de id de demande de proforma
        $id_fournisseur = $this->input->post('fournisseur');                 //récupération de id du fournisseur qui fait porforma
        
        if (empty($dateEmission) || empty($dateExpiration) ||
            empty($id_materiel) || empty($prix_unitaire)) {
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si champ vide = 0
                'message' => "Veuillez remplir tous les champs !"       //message de validation pour page Validation.php
            ]); 
        } else {
            $checkDateValide = $this->compareDateEmmisionAndExpirationProforma($dateEmission, $dateExpiration);                                 //contient un boolean true
            $checkPrixUnitaire = $this->checkValeurPrixUnitaire($prix_unitaire);                                                                //contient un boolean true     
            $total = $this->calculTotal($prix_unitaire, $quantite_materiel);                                                                    //calcul du total des achats
            $checkInsertProforma = $this->insertProforma($dateEmission, $dateExpiration, $total, $id_demandeProforma, $id_fournisseur);         //contient id de proforma qui vient d'être inséré   
            $checkInsertDetailProforma = $this->insertDetailProforma($checkInsertProforma, $prix_unitaire, $quantite_materiel, $id_materiel);   //contient un boolean true
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si champ vide = 0
                'message' => "Enregistrement de proforma réussi !"       //message de validation pour page Validation.php
            ]); 
        } 
        redirect('proforma/C_ProformaFournisseur/page_ListDemandeProformaFournisseur');                   //redirection vers la fonction page_ListDemandeProformaFournisseur
    }

/* FONCTION POUR COMPARER LA DATE DE DEMANDE DE PROFORMA ET LA DATE DE VALIDATION DU BESOIN GLOBAL
    ARGUMENT : 
        - $dateEmission : date d'émission du proforma par le fournisseur
        - $dateExpiration : date d'expiration du proforma
*/
    public function compareDateEmmisionAndExpirationProforma($dateEmission, $dateExpiration) {
        $dateEmissionCast = strtotime($dateEmission);                   //cast en date de date d'émission du proforma par le fournisseur
        $dateExpirationCast = strtotime($dateExpiration);               //cast en date de date d'expiration du proforma

        if  ($dateExpirationCast < $dateEmissionCast) { //si date de demande de proforma antérieure à date de derniere validation de besoin
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si Date invalide = 0
                'message' => "Date invalide, la date d'expiration doit être ultérieure à la date d'émission du proforma !"       //message de validation pour page Validation.php
            ]); 
            redirect('proforma/C_ProformaFournisseur/page_ListDemandeProformaFournisseur');                   //redirection vers la fonction page_ListDemandeProformaFournisseur                        
        }

        return true;                                                    //date valide
    }

/* FONCTION SI TOUS LES PRIX UNITAIRES SONT DES CHIFFRES ET NON DES TEXTES */
    public function checkValeurPrixUnitaire($prix_unitaire) {
        foreach ($prix_unitaire as $prix) {
            if (is_numeric($prix) === false) {                              //si prix unitaire pas un nombre
                $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                    'intValidation' => 0,                                   //int de validation si Date invalide = 0
                    'message' => "Tous prix unitaire doit être un nombre !"       //message de validation pour page Validation.php
                ]); 
                redirect('proforma/C_ProformaFournisseur/page_ListDemandeProformaFournisseur');                   //redirection vers la fonction page_ListDemandeProformaFournisseur      
            }
        }
        return true;
    }

/* FONCTION POUR CALCULER LE TOTAL DES ACHATS */
    public function calculTotal($prix_unitaire, $quantite_materiel) {
        $total = 0;                                                     //initiation total = 0
        for ($i=0; $i < count($quantite_materiel); $i++) {
            $total = $total + ($quantite_materiel[$i] * $prix_unitaire[$i]);     //total = total precedent + quantite * prix unitaire
        }
        return $total;
    }

/* FONCTION POUR INSERER LE PROFORMA POUR LA TABLE DE DETAIL PROFORMA */
    public function insertProforma($dateEmission, $dateExpiration, $total, $id_demandeProforma, $id_fournisseur) {
        $primaryKey = $this->dao->primaryKeyWithSequence('seq_proforma', 'PRFM');     //primary key de la table proforma
        $to_insert = [
            'id_proforma' => $primaryKey,
            'date_emission' => $dateEmission,
            'date_expiration' => $dateExpiration,
            'total' => $total,
            'id_fournisseur' => $id_fournisseur,
            'id_demandeproforma' => $id_demandeProforma
        ];
        $checkInsertProforma = $this->dao->saveData('proforma', $to_insert, 'id_proforma');      //insertion de proforma
        if ($checkInsertProforma === false) {
            $this->session->set_flashdata('checkValidation', [                  //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                           //int de validation si Date invalide = 0
                'message' => "Echec de l'enregistrement de proforma  !"         //message de validation pour page Validation.php
            ]); 
            redirect('proforma/C_ProformaFournisseur/page_ListDemandeProformaFournisseur');                   //redirection vers la fonction page_AjoutBesoin                                    //alors date non valide
        }
        return $checkInsertProforma;
    }

/* FONCTION POUR INSERER DANS TABLE DETAIL PROFORMA */
    public function insertDetailProforma($id_proforma, $prix_unitaire, $quantite_materiel, $id_materiel) {
        //craft et insertion dans table detail_proforma
        for ($i=0; $i < count($id_materiel); $i++) {
            $primaryKey = $this->dao->primaryKeyWithSequence('seq_detailproforma', 'DTLPRFM');     //primary key de la table detailproforma
            $to_insert = [                                 //craft des datas à inserer
                'id_detailprofoma' => $primaryKey,  
                'quantite' => $quantite_materiel[$i],  
                'pu' => $prix_unitaire[$i],  
                'id_materiels' => $id_materiel[$i],  
                'id_proforma' => $id_proforma
            ];
            $checkInsert = $this->dao->insert_into('detailproforma', $to_insert);       //retourne normalement un int
            if ($checkInsert === false) {
                $this->session->set_flashdata('checkValidation', [                      //on fait revenir vers la page d'insertion avec un popup d'erreur 
                    'intValidation' => 0,                                               //int de validation si insertion ts nety = 0
                    'message' => "Echec enregistrement détail proforma !"               //message de validation pour page Validation.php
                ]); 
                redirect('proforma/C_ProformaFournisseur/page_ListDemandeProformaFournisseur');     //redirection vers la fonction page_AjoutBesoin                                    //alors date non valide
            }
        }
        return true;                                                                    //isenrtion réussi            
    }

}

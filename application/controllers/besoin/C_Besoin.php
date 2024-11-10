<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Besoin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dao_model', 'dao');
    }

/*  ========================================================================================================================== A PROPOS DE AJOUT DE DEMANDE DE BESOINS */
/* FONCTION DE REDIRECTION VERS LA PAGE D'AJOUT DE BESOIN 
    ARGUMENTS : 
        - $checkValidation (tableau) : 
            .case 3 : redirection de page   => message : Aucun message
*/
	public function page_AjoutBesoin($checkValidation = 3) {        //initiena 3 par défaut pour la page Validation.php si non erreur
        $data['pageTitle'] = "Ajout Besoin";                        //titre de la page de destination
        $data['pageToLoad'] = "besoin/Besoin_Add";                  //path de a page de destination
        $data['poste'] = $this->dao->select_all('poste');           //liste des poste achetable pour faire les demandes
        $data['checkValidation'] = $checkValidation;                //tableau contenant int de validation avec le message qui lui correspond

		$this->load->view('home/Home', $data);                      //page principale où on load les pages
	}

/* FONCTION D'INSERTION D'UN BESOIN */
    public function ajout_besoin() {
        $id_poste = $this->input->post('poste');                        //récupération de id de poste à acheter 
        $datedemande = $this->input->post('datedemande');               //récupération de date quand on a fait la demande de besoin de talent
        $description = $this->input->post('description');               //récupération de;la description du poste
        $qualification = $this->input->post('qualification');           //récupération des qualifications de la demande de talent
        $objectif = $this->input->post('objectif');                     //récupération de l'objectif de la demande de talent

        if (empty($id_poste) ||                                  //si une des valeurs dans l'insertion est nulle ou vide
            empty($datedemande) ||
            empty($qualification) ||
            empty($objectif)) {   
            $this->session->set_flashdata('checkValidation', [      //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                               //int de validation si champ vide = 0
                'message' => "Veuillez remplir tous les champs !"   //message de validation pour page Validation.php
            ]); 
        } else {                                                    //si aucune valeur n'est vide ou nulle
            $checkInsertDemandeTalent = $this->insertDemandeTalent($id_poste, $datedemande, $description, $qualification, $objectif);   //insertion de la demande de talent
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si champ vide = 0
                'message' => "Demande de talent enregirstrée !"     //message de validation pour page Validation.php
            ]); 
        }
        redirect('besoin/C_Besoin/page_AjoutBesoin');                   //redirection vers la fonction page_AjoutBesoin
    }
    
/* FONCTION POUR CHECKER L'INSERTION DE LA DEMANDE DE TALENT 
    Arguments : 
        - $id_poste : id du poste pour la demande de talent
        - $datedemande : date quand la demande de talent est fait
        - $qualification : les qualifications requise du le talent
        - $objectif : objectif de la demande du recrutement
*/
    public function insertDemandeTalent($id_poste, $datedemande, $description, $qualification, $objectif) {
        $to_insert = [  //creation des datas à insérer sans la sequence piske la sequence se fait auto
            'datedemandetalent' => $datedemande,
            'description_talent'=> $description,
            'objectif' => $objectif,
            'qualification' => $qualification,
            'id_poste'=> $id_poste,
            'ischecked' => false                    //false satria refa insertion de mbola ts checked
        ];
        $checkInsertDemandeTalent = $this->dao->insert_into('demandetalent', $to_insert);   //insertion de demande de talent
        if ($checkInsertDemandeTalent === false) {
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si champ vide = 0
                'message' => "Echec de l'enregistrement de la demande de talent !"     //message de validation pour page Validation.php
            ]); 
        }
        return true;
    }

/*  ========================================================================================================================== A PROPOS DE LISTER LES DEMNDES DE BESOINS*/
/* FONCTION POUR AVOIR LA LISTE DES BESOINS DE TALENT ENCORE NON VALIDER 
    ARGUMENTS : 
        - $checkValidation (tableau)
*/
    public function liste_besoins($checkValidation = 3){
        $data['pageTitle'] = "Liste Besoins";                       //titre de la page de destination
        $data['pageToLoad'] = "besoin/Besoin_List";                 //path de a page de destination
        $data['checkValidation'] = $checkValidation;                //tableau contenant int de validation avec le message qui lui correspond
        $sql = "SELECT *
                FROM v_talentposte
                WHERE ischecked = false";
        $data['liste_talent'] = $this->dao->executeQuery($sql);     //liste des besoins de materiel
		$this->load->view('home/Home', $data);                      //page principale où on load les pages
    }
    
/* ========================================================================================================================== A PROPOS DE VALIDATION DE BESOINS PAR DG */
/* FONCTION POUR AVOIR LES DETAILS D'UNE DEMANDE DE BESOIN SUR UN TALENT
    ARGUMENT :
        - $id_demandetalent : id de la demande de talent
*/
    public function detail_besoin($id_demandetalent) {
        $data['pageTitle'] = "Détails Besoins";                         //titre de la page de destination
        $data['pageToLoad'] = "besoin/Besoin_Detail";                   //path de a page de destination
        $sql = "SELECT *
                FROM v_talentposte
                WHERE ischecked = false
                AND id_demandetalent = '".$id_demandetalent."'";
        $data['detail_talent'] = $this->dao->executeQuery($sql);        //liste des besoins de materiel
		$this->load->view('home/Home', $data);                          //page principale où on load les pages
    } 

/* FONCTION POUR REDIRIGER VERS LA PAGE DE VALIDATION DE BESOIN */
    public function validation_besoin() {
        $data['pageTitle'] = "Détails Besoins";                         //titre de la page de destination
        $data['pageToLoad'] = "besoin/Besoin_Validation";               //path de a page de destination
        
        $id_demandetalent = $this->input->post('demandetalent');        //récupération de id de demande de talent à valider 
        $datedemande = $this->input->post('datedemande');               //récupération de date quand on a fait la demande de besoin de talent
        $datevalidation = $this->input->post('datevalidation');         //récupération de date quand on a fait la demande de besoin de talent
        
        if (empty($datevalidation)) {                                  //si une des valeurs dans l'insertion est nulle ou vide   
            $this->session->set_flashdata('checkValidation', [              //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                       //int de validation si champ vide = 0
                'message' => "Veuillez indiquer une date de validation !"   //message de validation pour page Validation.php
            ]); 
        } else {                                                    //si aucune valeur n'est vide ou nulle
            $checkInsertDemandeTalent = $this->checkoutDateValidation($datedemande, $datevalidation);                           //insertion de la demande de talent
            $checkUpdateDemandeTalent = $this->checkUpdateDateValidation($id_demandetalent, $datedemande, $datevalidation);     //updaate des valeurs
            
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si champ vide = 0
                'message' => "Succès de la validation de la demande de talent !"     //message de validation pour page Validation.php
            ]); 
        }
        redirect('besoin/C_Besoin/liste_besoins');                   //redirection vers la fonction page_AjoutBesoin
    }

/* FONCTION POUR CHECKER LA DATE DE VALIDATION QUI DOIT ETRE SUPERIEUR OU EGAL A LA DATE DE DEMANDE DE BESOIN DE TALENT
    ARGUMENT : 
        - $dateDemande : date de demande de la demande de besoin de talent
        - $dateValidation : date de validation de la demande de besoin de talent
*/
    public function checkoutDateValidation($datedemande, $datevalidation) {
        $dateValidationDemandeCast = strtotime($datevalidation);        //cast de date de validation de front end
        $dateDemandeCast = strtotime($datedemande);                     //cast en date de la date de demande de besoin pour chaque demande
            if ($dateDemandeCast > $dateValidationDemandeCast) {        //si la date de validation est antérieure à la date de demande de besoin      
                $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                    'intValidation' => 0,                                   //int de validation si champ vide = 0
                    'message' => "Date validation besoin invalide !"     //message de validation pour page Validation.php
                ]);                                         //alors validation de demande impossible
                redirect('besoin/C_Besoin/liste_besoins');                   //redirection vers la fonction page_AjoutBesoin
            }

        return true;                                                //si date supérieur alors mety
    }

/* FONCTION POUR CRAFT UNE OU LES TABLEAUX DE VALIDATION DE DEMANDES DE BESOINS POUR UN MATERIEL 
    ARGUMENT : 
        - $id_materiel : id du materiel dont on va valider la demande d'achat
        - $dateValidation : date de validation de la demande d'achat de besoin
        - $liste_besoins : liste des besoins à checker
        - $id_besoinGlobal : id de besoin global qui met en commun les besoins checked
*/
    public function checkUpdateDateValidation($id_demandetalent, $datedemande, $datevalidation) {
        $condition = [ 'id_demandetalent' => $id_demandetalent ];   //condition pour update where
        var_dump($condition);
        $newData = [                                                //nouvelles données à update
            'ischecked' => true,
            'datechecktalent' => $datevalidation
        ];

        /* update des nouvelles valeurs : il y a date de validation et isChecked = true */
        $checkUpdateDemandeTalent = $this->dao->update('demandetalent', $newData, $condition);
        if ($checkUpdateDemandeTalent === false) {
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si champ vide = 0
                'message' => "Echec de la validation de la demande de talent !"     //message de validation pour page Validation.php
            ]); 
            redirect('besoin/C_Besoin/liste_besoins');                   //redirection vers la fonction page_AjoutBesoin
        }

        return $checkUpdateDemandeTalent;                            //return tableau 2 dimensions
    }

/*  ========================================================================================================================== A PROPOS DE LISTER LES DEMNDES DE BESOINS*/
/* FONCTION POUR AVOIR LA LISTE DES BESOINS DE TALENT ENCORE DEJA VALIDE
    ARGUMENTS : 
        - $checkValidation (tableau)
*/
public function liste_besoinValide($checkValidation = 3){
    $data['pageTitle'] = "Liste Besoins";                       //titre de la page de destination
    $data['pageToLoad'] = "besoin/BesoinValide_List";                 //path de a page de destination
    $data['checkValidation'] = $checkValidation;                //tableau contenant int de validation avec le message qui lui correspond
    $sql = "SELECT *
            FROM v_talentposte
            WHERE ischecked = true";
    $data['liste_talent'] = $this->dao->executeQuery($sql);     //liste des besoins de materiel
    $this->load->view('home/Home', $data);                      //page principale où on load les pages
}

}

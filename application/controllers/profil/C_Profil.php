<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Profil extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dao_model', 'dao');
    }

/*  ========================================================================================================================== A PROPOS DE AJOUT DE DEMANDE DE BESOINS */
/* FONCTION DE REDIRECTION VERS LA PAGE DE DETAIL DE PROFIL VALIDE */
	public function page_DetailProfilValide($id_demandetalent) {        
        $data['pageTitle'] = "Détail Besoin Valide";                        //titre de la page de destination
        $data['pageToLoad'] = "besoin/BesoinValide_Detail";                  //path de a page de destination
        
        $sql = "SELECT *
                FROM v_talentposte
                WHERE id_demandetalent = '".$id_demandetalent."'";
        $data['detail_talent'] = $this->dao->executeQuery($sql);           //liste des besoins de materiel

		$this->load->view('home/Home', $data);                      //page principale où on load les pages
	}

/* FONCTION DE REDIRECTION VERS LA PAGE DE DRESSAGE DE PROFIL */
	public function page_DressserProfil($id_demandetalent) {        
        $data['pageTitle'] = "Ajout Profil";                        //titre de la page de destination
        $data['pageToLoad'] = "profil/Profil_Add";                  //path de a page de destination
        
        $sql = "SELECT *
                FROM v_talentposte
                WHERE id_demandetalent = '".$id_demandetalent."'";
        $data['detail_talent'] = $this->dao->executeQuery($sql);           //liste des besoins de materiel
        $data['diplome'] = $this->dao->select_all('diplome');              //liste des diplomes

		$this->load->view('home/Home', $data);                      //page principale où on load les pages
	}

/* FONCTION D'INSERTION D'UN PROFIL */
    public function ajout_profil() {
        $id_demandetalent = $this->input->post('demandetalent');                            //récupération de id de poste à de demande de talent
        $datevalidation = $this->input->post('datevalidation');               //récupération de date quand on a fait la demande de besoin de talent
        $datedemande_profil = $this->input->post('datedemande_profil');     //récupération de date quand on a fait la demande de dressage de profil du matériel à acheter
        $diplome = $this->input->post('diplome');                           //récupération de id de utilisateur qui fait demande de besoin du matériel à acheter 
        $minexp = $this->input->post('minexp');                             //récupération de minimum d'experience
        $minage = $this->input->post('minage');                             //récupération de minimum d'age
        $maxage = $this->input->post('maxage');                             //récupération de maximum d'age
       
        if (empty($datedemande_profil) ||                                  //si une des valeurs dans l'insertion est nulle ou vide
            empty($diplome) ||
            empty($minexp) ||
            empty($minage) ||
            empty($maxage)) {   
            $this->session->set_flashdata('checkValidation', [      //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                               //int de validation si champ vide = 0
                'message' => "Veuillez remplir tous les champs !"   //message de validation pour page Validation.php
            ]); 
        } else {                                                        //si aucune valeur n'est vide ou nulle
            $checkDateValidation = $this->checkoutDateValidation($datedemande_profil, $datevalidation);    //date valide contient true maintenant
            $checkAgeMin = $this->checkOutAgeMin($minage); //contient true si age valide
            $checkSaveProfil = $this->insert_profil($id_demandetalent, $datedemande_profil, $minexp, $minage, $maxage, $diplome);    //contient id de profil qui vient d'etre inseré si insertion done
        }
        redirect('besoin/C_Besoin/liste_besoinValide');                   //redirection vers la fonction page contenant liste des demandes valides
    }
    
/* FONCTION POUR CHECKER LA DATE DE VALIDATION QUI DOIT ETRE SUPERIEUR OU EGAL A LA DATE DE VALIDATION DE DEMANDE DE TALENT
    ARGUMENT : 
        - $dateDemande : date de validation de demande de la demande de besoin de talent
        - $dateValidation : date de validation de la demande de besoin de talent
*/
    public function checkoutDateValidation($datedemande_profil, $datevalidation) {
        $dateValidationDemandeCast = strtotime($datevalidation);        //cast de date de validation de front end
        $dateDemandeCast = strtotime($datedemande_profil);                     //cast en date de la date de demande de besoin pour chaque demande
            if ($dateValidationDemandeCast > $dateDemandeCast) {        //si la date de validation est antérieure à la date de demande de besoin      
                $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                    'intValidation' => 0,                                   //int de validation si champ vide = 0
                    'message' => "Date validation d'annonce invalide !"     //message de validation pour page Validation.php
                ]);  
                redirect('besoin/C_Besoin/liste_besoinValide');                   //redirection vers la fonction page contenant liste des demandes valides
            }

        return true;                                                //si date supérieur alors mety
    }

/* FONCTION POUR CHECK QU'ON NE FASSE PAS DES ANNONCES POUR DES MINEURS
    Argument : 
        - $minage : age minimum dans dressage de profil
*/
    public function checkOutAgeMin($minage) {
        if ($minage < 18) {
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si champ vide = 0
                'message' => "Age minimum invalide !"     //message de validation pour page Validation.php
            ]);  
            redirect('besoin/C_Besoin/liste_besoinValide');                   //redirection vers la fonction page contenant liste des demandes valides
        }
        return true;
    }

/* FONCTION POUR CHECKER L'INSERTION DE PROFIL 
    Argument : 
        - $id_demandetalent : id de la demande de talent concerné pas annonces
        - $datedemande_profil : date de demande de profil
        - $minexp : nombre d'année d'expérience minimum recquis pour le poste
        - $minage : age minimum dans dressage de profil
        - $maxage : age maximum recquis pour le poste
*/
    public function insert_profil($id_demandetalent, $datedemande_profil, $minexp, $minage, $maxage, $diplome) {
        $to_insert = [
            'experience_min' => $minexp,
            'age_min' => $minage,
            'age_max' => $maxage,
            'datedemande_profil' => $datedemande_profil,
            'id_diplome' => $diplome,
            'id_demandetalent' =>$id_demandetalent
        ];
        
        $checkSaveProfil = $this->dao->saveData('profil', $to_insert, 'id_profil'); //checking insertion de profil
        if ($checkSaveProfil === false) {
            $this->session->set_flashdata('checkValidation', [          //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                                   //int de validation si champ vide = 0
                'message' => "Echec enregistrement de profil !"     //message de validation pour page Validation.php
            ]);  
            redirect('besoin/C_Besoin/liste_besoinValide');                   //redirection vers la fonction page contenant liste des demandes valides
        }
        return true;
    }
}

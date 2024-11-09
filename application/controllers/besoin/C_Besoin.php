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
            .case 0 : champ vide            => message : Veiullez remplir tous les champs !
            .case 1 : insertion réussie     => message : Votre demande a été enregistrée !
            .case 2 : insertion raté        => message : Votre demande a echoué !
            .case 3 : redirection de page   => message : Aucun message
*/
	public function page_AjoutBesoin($checkValidation = 3) {        //initiena 3 par défaut pour la page Validation.php si non erreur
        $data['pageTitle'] = "Ajout Besoin";                        //titre de la page de destination
        $data['pageToLoad'] = "besoin/Besoin_Add";                  //path de a page de destination
        $data['materiels'] = $this->dao->select_all('materiels');   //liste des matériels achetable pour faire les demandes
        $data['checkValidation'] = $checkValidation;                //tableau contenant int de validation avec le message qui lui correspond

		$this->load->view('home/Home', $data);                      //page principale où on load les pages
	}

/* FONCTION D'INSERTION D'UN BESOIN */
    public function ajout_besoin() {
        $id_materiel = $this->input->post('materiel');                      //récupération de id de matériel à acheter 
        $quantite_materiel = $this->input->post('quantite');                //récupération de la nombre/quantité du matériel à acheter 
        $datedemande = $this->input->post('datedemande');                   //récupération de date quand on a fait la demande de besoin du matériel à acheter
        $user_info = $this->session->userdata('user_info');                 //récupération de id de utilisateur qui fait demande de besoin du matériel à acheter 

        $checkPlusieursBesoins = $this->input->post('multipleInsertion');   //récupération de valeur de mulitpleinsertion pour check si on doit faire plusieurs isnertions ou non
        
        if (empty($id_materiel) ||                                  //si une des valeurs dans l'insertion est nulle ou vide
            empty($quantite_materiel) ||
            empty($datedemande) ||
            empty($user_info)) {   
            $this->session->set_flashdata('checkValidation', [      //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                               //int de validation si champ vide = 0
                'message' => "Veuillez remplir tous les champs !"   //message de validation pour page Validation.php
            ]); 
        } else {                                                        //si aucune valeur n'est vide ou nulle
            if (ctype_digit($quantite_materiel)) {
                $primaryKeyBesoin = $this->dao->primaryKeyWithSequence('seq_besoins', 'BSN');       //id de la table besoins
                $condition = ['id_materiels' => $id_materiel];                                  //condition pour trouver unite de materiel à acheter
                $unite = $this->dao->select_where('v_materielcategorie', $condition);           //une ligne de materiels de la view v_materielcategorie
                $to_insert = [                                                                  //on craft le tableau qui va servir à l'insertion
                    'id_besoin' => $primaryKeyBesoin,
                    'quantite_materiel' => $quantite_materiel,
                    'resolu' => false,
                    'datedemande' => $datedemande,
                    'unite' => $unite[0]['unite_materiel'],
                    'id_materiels' => $id_materiel,        
                    'id_users' => $user_info['id_users']
                ];
                $inserted = $this->insert_TabBesoin($checkPlusieursBesoins, $to_insert);        //retour de id de insertion si insertion réussi ($inserted != null)
                
                if ($inserted == true) {                                            //si la valeur de $inserted n'est pas null alors insertion réussi
                    $this->session->set_flashdata('checkValidation', [          //redirect vers page d'insertion + popup de validation de insertion réussi
                        'intValidation' => 1,                                   //int de validation si insertion réussi
                        'message' => "Votre demande a été enregistrée !"        //message de validation pour page Validation.php
                    ]);
                } else {                                                    //si la valeur de $inserted est pas null alors insertion raté                
                    $this->session->set_flashdata('checkValidation', [          //redirect vers page d'insertion + popup de validation de insertion raté
                        'intValidation' => 2,                                   //int de validation si insertion raté
                        'message' => "Votre demande a échoué !"                 //message de validation pour page Validation.php
                    ]);
                }
            } else {   
                $this->session->set_flashdata('checkValidation', [      //on fait revenir vers la page d'insertion avec un popup d'erreur 
                    'intValidation' => 4,                               //int de validation si tsy entier le commande
                    'message' => "Aza ko hisy tapaka zavatra zany e !"   //message de validation pour page Validation.php
                ]); 
            }
        }
        redirect('besoin/C_Besoin/page_AjoutBesoin');                   //redirection vers la fonction page_AjoutBesoin
    }
    
/* FONCTION CRAFT DE TABLEAU DE BESOIN POUR INSERTION */
    public function craftTabBesoin() {
        // Récupération des données envoyées par le formulaire
        $materiels = $this->input->post('materiels');               //Tableau des matériels
        $quantites = $this->input->post('quantites');               //Tableau des quantités
        $dates_demande = $this->input->post('datedemandes');        //Tableau des dates
        $user_info = $this->session->userdata('user_info');         //récupération de id de utilisateur qui fait demande de besoin du matériel à acheter 

        $tableau_besoin = array();

        // Boucle sur les données récupérées
        foreach ($materiels as $index => $id_materiel) {
            $quantite = $quantites[$index];
            $date_demande = $dates_demande[$index];
            if (empty($id_materiel) ||                              //si une des valeurs dans l'insertion est nulle ou vide
                empty($quantite) ||
                empty($date_demande)) {   
                    $this->session->set_flashdata('checkValidation', [      //on fait revenir vers la page d'insertion avec un popup d'erreur 
                        'intValidation' => 0,                               //int de validation si champ vide = 0
                        'message' => "Veuillez remplir tous les champs !"   //message de validation pour page Validation.php
                    ]);         
                    redirect('besoin/C_Besoin/page_AjoutBesoin');           //redirection vers la fonction page_AjoutBesoin
            } else {
                $primaryKeyBesoins = $this->dao->primaryKeyWithSequence('seq_besoins', 'BSN');  //id de la table besoins
                $condition = ['id_materiels' => $id_materiel];                                  //condition pour trouver unite de materiel à acheter
                $unite = $this->dao->select_where('v_materielcategorie', $condition);           //une ligne de materiels de la view v_materielcategorie
                $to_insert = [                                                                  //on craft le tableau qui va servir à l'insertion
                    'id_besoin' => $primaryKeyBesoins,
                    'quantite_materiel' => $quantite,
                    'resolu' => false,
                    'datedemande' => $date_demande,
                    'unite' => $unite[0]['unite_materiel'],
                    'id_materiels' => $id_materiel,        
                    'id_users' => $user_info['id_users']
                ];
                $tableau_besoin[] = $to_insert;
            }
        }

        return $tableau_besoin;
    }    

/* FONCTION POUR INSERER TOUTES LES VALEURS DANS LES TABLEAUX DE BESOIN */
    public function insert_TabBesoin($checkPlusieursBesoins, $one_besoin) {
        if ($checkPlusieursBesoins == false) {
            $checkInsert = $this->dao->insert_into('besoins', $one_besoin);
            if ($checkInsert == false) {                                            //si une insertion s'est mal passée alors on retourne false de ts nety direct
                return $checkInsert;
            }
        } else {
            $checkInsertOneBesoin = $this->dao->insert_into('besoins', $one_besoin);
            if ($checkInsertOneBesoin == false) {                                            //si une insertion s'est mal passée alors on retourne false de ts nety direct
                return $checkInsertOneBesoin;
            }
            $tab_besoin = $this->craftTabBesoin();                                      //craft de tous les tableaux pour insertions de besoins
            foreach ($tab_besoin as $oneTab_besoin) {
                $checkInsert = $this->dao->insert_into('besoins', $oneTab_besoin);      //retour de id de insertion si insertion réussi ($inserted != null)
                if ($checkInsert == false) {                                            //si une insertion s'est mal passée alors on retourne false de ts nety direct
                    return $checkInsert;
                }
            }
        }

        return true;                                                                    //si toutes les insertions se sont bien passées alors true
    }




/*  ========================================================================================================================== A PROPOS DE LISTER LES DEMNDES DE BESOINS*/
/* FONCTION POUR AVOIR LA LISTE DES BESOINS ENCORE NON VALIDER 
    ARGUMENTS : 
        - $checkValidation (tableau) : 
            .case 0 : champ vide            => message : Veiullez remplir tous les champs !
            .case 1 : insertion réussie     => message : Votre demande a été enregistrée !
            .case 2 : insertion raté        => message : Votre demande a echoué !
            .case 3 : redirection de page   => message : Aucun message
            .case 4 : insertion de validation de demande ratée => message : Date Invalide!
*/
    public function liste_besoins($checkValidation = 3){
        $data['pageTitle'] = "Liste Besoins";                       //titre de la page de destination
        $data['pageToLoad'] = "besoin/Besoin_List";                 //path de a page de destination
        $data['checkValidation'] = $checkValidation;                //tableau contenant int de validation avec le message qui lui correspond
        $sql = "SELECT
                    id_materiels,
                    nom_materiel,
                    SUM(quantite_materiel) AS total_quantite,
                    COUNT(id_besoin) AS nombre_besoins,
                    unite_materiel
                FROM v_besoins AS b
                WHERE b.datecheck IS NULL
                GROUP BY id_materiels, nom_materiel, unite_materiel";
        $data['liste_besoin'] = $this->dao->executeQuery($sql);     //liste des besoins de materiel
		$this->load->view('home/Home', $data);                      //page principale où on load les pages
    }



    
/* ========================================================================================================================== A PROPOS DE VALIDATION DE BESOINS PAR DG */
/* FONCTION POUR AVOIR LES DETAILS D'UNE DEMANDE DE BESOIN SUR UN MATERIEL 
    ARGUMENT :
        - $id_materiel : id du matériel pour lequel on veut voir les détails des demandes
*/
    public function detail_besoin($id_materiel) {
        $data['pageTitle'] = "Détails Besoins";                         //titre de la page de destination
        $data['pageToLoad'] = "besoin/Besoin_Detail";                   //path de a page de destination
        $sql = "SELECT
                    id_besoin,
                    id_materiels,
                    nom_materiel,
                    id_departement,
                    nom_departement,
                    SUM(quantite_materiel) AS total_quantite,
                    COUNT(id_besoin) AS nombre_besoins,
                    datedemande,
                    unite_materiel
                FROM v_besoins AS b
                WHERE b.datecheck IS NULL
                AND b.id_materiels = '".$id_materiel."'
                GROUP BY id_besoin, id_materiels, nom_materiel, id_departement, nom_departement, datedemande, unite_materiel
                ORDER BY datedemande";
        $data['detail_besoin'] = $this->dao->executeQuery($sql);        //liste des besoins de materiel
		$this->load->view('home/Home', $data);                          //page principale où on load les pages
    } 

/* FONCTION POUR REDIRIGER VERS LA PAGE DE VALIDATION DE BESOIN */
    public function validationPage_besoin($id_materiel) {
        $data['pageTitle'] = "Détails Besoins";                         //titre de la page de destination
        $data['pageToLoad'] = "besoin/Besoin_Validation";               //path de a page de destination

        $sql = "SELECT
                    id_materiels,
                    nom_materiel,
                    SUM(quantite_materiel) AS total_quantite,
                    COUNT(id_besoin) AS nombre_besoins,
                    unite_materiel
                FROM v_besoins AS b
                WHERE b.datecheck IS NULL
                AND b.id_materiels = '".$id_materiel."'
                GROUP BY id_materiels, nom_materiel, unite_materiel";
        $data['liste_besoinMateriel'] = $this->dao->executeQuery($sql); //liste des besoins de materiel

        //date de la derniere demande pour le check de date ulterieure
        $sqlDateLastDemande = "SELECT
                                    MAX(datedemande) AS derniere_demande
                                FROM v_besoins AS b
                                WHERE b.datecheck IS NULL
                                AND b.id_materiels = '".$id_materiel."'";
        $data['last_date'] = $this->dao->executeQuery($sqlDateLastDemande);            //liste des besoins de materiel

		$this->load->view('home/Home', $data);                          //page principale où on load les pages
    }

/* FONCTION POUR CHECKER LA DTE DE VALIDATION QUI DOIT ETRE SUPERIEUR OU EGAL A LA DATE DE DEMANDE DE BESOIN 
    ARGUMENT : 
        - $id_materiel : id du materiel dont on va valider la demande d'achat
        - $dateValidation : date de validation de la demande d'achat de besoin
        - $liste_besoins : liste des besoins à checker
*/
    public function checkoutDateValidation($id_materiel, $dateValidation, $liste_besoins) {
        $dateValidationDemande = strtotime($dateValidation);        //cast de date de validation de front end
        foreach ($liste_besoins as $besoin) {                       //boucler la liste des dates de demande des besoins
            $dateDemande = strtotime($besoin['datedemande']);       //cast en date de la date de demande de besoin pour chaque demande
            if ($dateDemande > $dateValidationDemande) {            //si la date de validation est antérieure à la date de demande de besoin
                return false;                                       //alors validation de demande impossible
            }
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
    public function craftTabValidationBesoin($id_materiel, $dateValidation, $liste_besoins, $id_besoinGlobal) {
        $checkoutDateValidation = $this->checkoutDateValidation($id_materiel, $dateValidation, $liste_besoins);     //checking si date de validation de demande est valide
        $tab_insertBesoinchecked = array();                         //initiation de tableau multiDimensionel pour contenir les tableau pounr insertion de besoinchecked
        if ($checkoutDateValidation == true) {                      //si date Validation d'achat de demande valide
            foreach ($liste_besoins AS $besoin) {                   //boucle de tous les besoins à valider
                $oneBesoinChecked = [                               //tableau pour insertion de besoin checked
                    'datecheck' => $dateValidation,                 //date de validation de la demande d'achat
                    'id_besoin' => $besoin['id_besoin'],            //id du besoin à valider
                    'id_besoinglobal' => $id_besoinGlobal           //date de validation de la demande d'achat
                ];  
                $tab_insertBesoinchecked[] = $oneBesoinChecked;     //tableau d'insertion dans tableau 2 dimension
            } 
        } else {                                                    //si date invalide
            $this->session->set_flashdata('checkValidation', [      //on fait revenir vers la page de liste des besoins avec un popup d'erreur 
                'intValidation' => 4,                               //int de validation si date invalide = 4
                'message' => "La date de validation de demande de besoin doit être ultérieure à la dernière demande !"   //message de validation pour page Validation.php
            ]);       
            redirect('besoin/C_Besoin/liste_besoins');              //redirection vers page de liste des besoins
        }

        return $tab_insertBesoinchecked;                            //return tableau 2 dimensions
    }
    
/* FONCTION POUR INSERER UNE OU LES DEMANDES DE BESOINS POUR UN MATERIEL
    ARGUMENT : 
        - $id_materiel : id du materiel dont on va valider la demande d'achat
        - $dateValidation : date de validation de la demande d'achat de besoin
        - $liste_besoins : liste des besoins à checker
*/
    public function insert_besoinChecked($id_materiel, $dateValidation, $liste_besoins, $id_besoinGlobal) {
        $tab_insertionBesoinChecked = $this->craftTabValidationBesoin($id_materiel, $dateValidation, $liste_besoins, $id_besoinGlobal);
        if (is_array($tab_insertionBesoinChecked)) {
            foreach ($tab_insertionBesoinChecked as $one_besoinChecked) {
                $checkInsert = $this->dao->insert_into('besoinchecked', $one_besoinChecked);        //retour de id de insertion si insertion réussi ($inserted != null)
                if ($checkInsert == false) {                                                        //si une insertion s'est mal passée alors on retourne false de ts nety direct
                    return $checkInsert;                                
                }
            }
        } else {
            return $tab_insertionBesoinChecked;                                                     //si date non valide contenu = false
        }
        return true;                                                                                //si toutes les insertions sont buenos lors return true
    }

/* FONCTION POUR INSERER LE BESOIN GLOBAL DE L'ENTREPRISE
    ARGUMENT : 
        - $id_materiel : id du materiel dont on va valider la demande d'achat
        - $dateValidation : date de validation de la demande d'achat de besoin
        - $liste_besoins : liste des besoins à checker
*/
    public function insert_BesoinGlobal($id_materiel, $dateValidation, $quantite, $objet, $liste_besoins) {
        $checkoutDateValidation = $this->checkoutDateValidation($id_materiel, $dateValidation, $liste_besoins);     //checking si date de validation de demande est valide
        if ($checkoutDateValidation == true) {
            $primaryKeyBesoinGlobal = $this->dao->primaryKeyWithSequence('seq_besoinGlobale', 'BSNGLBL');           //PK pour table besoin global
            $besoinGlobal = [
                'id_besoinglobal' => $primaryKeyBesoinGlobal,
                'quantite' => $quantite,
                'datevalidation' => $dateValidation,
                'objetdemande' => $objet,
                'id_materiels' => $id_materiel
            ];

            $inserted_BesoinGlobal = $this->dao->saveData('besoinglobal', $besoinGlobal, 'id_besoinglobal');        //retourne la valeur de idBesoinGlobal inséré ou false
            if ($inserted_BesoinGlobal == false) {                              //si insertion echoue
                $this->session->set_flashdata('checkValidation', [              //on fait revenir vers la page de liste des besoins avec un popup d'erreur 
                    'intValidation' => 5,                                       //int de validation si date invalide = 5
                    'message' => "Echec de enregistrement du besoin global !"   //message de validation pour page Validation.php
                ]);       
                redirect('besoin/C_Besoin/liste_besoins');                      //redirection vers page de liste des besoins
            } else {                                                            //si insertion succes
                return $inserted_BesoinGlobal;                                  //retourne id de besoin globale qui vient d'être inséré
            }
        } else {                                                    //si date invalide
            $this->session->set_flashdata('checkValidation', [      //on fait revenir vers la page de liste des besoins avec un popup d'erreur 
                'intValidation' => 4,                               //int de validation si date invalide = 4
                'message' => "La date de validation de demande de besoin doit être ultérieure à la dernière demande !"   //message de validation pour page Validation.php
            ]);       
            redirect('besoin/C_Besoin/liste_besoins');              //redirection vers page de liste des besoins
        }
    }

/* FONCTION POUR VALIDER LES INSERTIONS DE BESOIN CHECKED ET REDIRIGER VERS LISTE D'AUTRES BESOINS A CHECKER
    ARGUMENT : 
        - $id_materiel : id du materiel dont on va valider la demande d'achat
        - $dateValidation : date de validation de la demande d'achat de besoin
        - $liste_besoins : liste des besoins à checker
*/
    public function valider_besoinChecked() {
        $id_materiel = $this->input->post('id_materiel');                           //id de matériel qu'il faut valider
        $dateValidationDemande = $this->input->post('datevalidationdemande');       //date de validation de la demande en question
        $quantite = $this->input->post('quantite');                                 //somme des besoins sur un materiel
        $objet = $this->input->post('objet');                                       //objet de la demande

        //requete pour avoir les infos sur les besoins à checker
        $sql = "SELECT                                                          
                    id_besoin,
                    id_materiels,
                    nom_materiel,
                    id_departement,
                    nom_departement,
                    SUM(quantite_materiel) AS total_quantite,
                    COUNT(id_besoin) AS nombre_besoins,
                    datedemande,
                    unite_materiel
                FROM v_besoins AS b
                WHERE b.datecheck IS NULL
                AND b.id_materiels = '".$id_materiel."'
                GROUP BY id_besoin, id_materiels, nom_materiel, id_departement, nom_departement, datedemande, unite_materiel
                ORDER BY datedemande";
        $liste_besoins = $this->dao->executeQuery($sql);

        if (empty($id_materiel) ||                              //si une des valeurs dans l'insertion est nulle ou vide
            empty($dateValidationDemande)) {
                $this->session->set_flashdata('checkValidation', [      //on fait revenir vers la page d'insertion avec un popup d'erreur 
                    'intValidation' => 0,                               //int de validation si champ vide = 0
                    'message' => "Veuillez remplir tous les champs !"   //message de validation pour page Validation.php
                ]);         
        } else {
            $id_besoinGlobal = $this->insert_BesoinGlobal($id_materiel, $dateValidationDemande, $quantite, $objet, $liste_besoins);                 //insertion de besoin globale
            $checkInsertedBesoinChecked = $this->insert_besoinChecked($id_materiel, $dateValidationDemande, $liste_besoins, $id_besoinGlobal);      //insertion de besoin checked
            if ($checkInsertedBesoinChecked == true) {                  //si la valeur de $checkInsertedBesoinChecked = true alors insertion réussi
                $this->session->set_flashdata('checkValidation', [                              //redirect vers page liste de demandes de besoins encore non validé + popup de validation de insertion réussi
                    'intValidation' => 1,                                                       //int de validation si insertion réussi
                    'message' => "Les demandes d'achat de besoins ont été validée !"            //message de validation pour page Validation.php
                ]);
            } else {                                                    //si la valeur de $checkInsertedBesoinChecked = false alors insertion raté                
                $this->session->set_flashdata('checkValidation', [                              //redirect vers page liste de demandes de besoins encore non validé + popup de validation de insertion raté
                    'intValidation' => 2,                                                       //int de validation si insertion raté
                    'message' => "La validation des demandes d'achat des besoins a échoué !"    //message de validation pour page Validation.php
                ]);
            }
        }
        redirect('besoin/C_Besoin/liste_besoins');                      //redirection vers page de liste des besoins
    }
}

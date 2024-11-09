<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Materiel extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dao_model', 'dao');
    }

/* FONCTION DE REDIRECTION VERS LA PAGE D'AJOUT DE MATERIEL 
    ARGUMENTS : 
        - $checkValidation (tableau) : 
            .case 0 : champ vide            => message : Veiullez remplir tous les champs !
            .case 1 : insertion réussie     => message : Votre demande a été enregistrée !
            .case 2 : insertion raté        => message : Votre demande a echoué !
            .case 3 : redirection de page   => message : Aucun message
*/
	public function page_AjoutMateriel($checkValidation = 3) {                              //initiena 3 par défaut pour la page Validation.php si non erreur
        $data['pageTitle'] = "Ajout Materiel";                                              //titre de la page de destination
        $data['pageToLoad'] = "materiel/Materiel_Add";                                      //path de a page de destination
        $data['checkValidation'] = $checkValidation;                                        //tableau contenant int de validation avec le message qui lui correspond
        $data['liste_categoriemateriel'] = $this->dao->select_all('categoriemateriel');     //liste des categories de matériels
        $data['liste_unite'] = $this->dao->select_all('unite');                             //liste des categories de matériels

		$this->load->view('home/Home', $data);                                              //page principale où on load les pages
	}

/* FONCTION D'INSERTION D'UN MATERIEL */
    public function ajout_Materiel() {
        $idCategorie = $this->input->post('categorie');             //récupération de id de catégorie de materiel
        $nom = $this->input->post('nom');                           //récupération de nom de nom à créer 
        $unite = $this->input->post('unite');                       //récupération unite de materiel pour gestion stock

        if (empty($idCategorie) ||                                  //si une des valeurs dans l'insertion est nulle ou vide 
            empty($nom) ||
            empty($unite)) {
            $this->session->set_flashdata('checkValidation', [      //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                               //int de validation si champ vide = 0
                'message' => "Veuillez remplir tous les champs !"   //message de validation pour page Validation.php
            ]); 
        } else {                                                    //si aucune valeur n'est vide ou nulle
            $primaryKey = $this->dao->primaryKeyWithSequence('seq_materiels', 'MTRL');              //id de la materiel qu'on va créer
            
            //nom de colone => valeur de la colonne
            $to_insert = [                                          //on craft le tableau qui va servir à l'insertion
                'id_materiels' => $primaryKey,                      //id de materiel
                'nom_materiel' => $nom,                             //nom de materiel
                'unite_materiel' => $unite,                         //unite de materiel
                'id_categoriemateriel' => $idCategorie              //id de catégorie de materiel
            ];
            
            $inserted = $this->dao->insert_into('materiels', $to_insert);       //retour de id de insertion si insertion réussi ($inserted != null)
            
            if ($inserted) {                                            //si la valeur de $inserted n'est pas null alors insertion réussi
                $this->session->set_flashdata('checkValidation', [              //redirect vers page d'insertion + popup de validation de insertion réussi
                    'intValidation' => 1,                                       //int de validation si insertion réussi
                    'message' => "Matériel créée avec succès !"                 //message de validation pour page Validation.php
                ]);
            } else {                                                    //si la valeur de $inserted est pas null alors insertion raté                
                $this->session->set_flashdata('checkValidation', [              //redirect vers page d'insertion + popup de validation de insertion raté
                    'intValidation' => 2,                                       //int de validation si insertion raté
                    'message' => "Echec de la création de la matériel !"        //message de validation pour page Validation.php
                ]);
            }
        }
        redirect('materiel/C_Materiel/page_AjoutMateriel');             //redirection vers la fonction page_AjoutBesoin
    }

/* FONCTION POUR AVOIR LA LISTE DES MATERIELS */
    public function getListeMateriel(){
        $data['pageTitle'] = "Liste Materiel";                                      //titre de la page de destination
        $data['pageToLoad'] = "materiel/Materiel_List";                             //path de a page de destination
        $data['liste_materiel'] = $this->dao->select_all('v_materielcategorie');    //liste des materiels
		$this->load->view('home/Home', $data);                                      //page principale où on load les pages
    }
}

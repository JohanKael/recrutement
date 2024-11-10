<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Categorie extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dao_model', 'dao');
    }

/* FONCTION DE REDIRECTION VERS LA PAGE D'AJOUT DE CATEGORIE 
    ARGUMENTS : 
        - $checkValidation
*/
	public function page_AjoutCategorieMateriel($checkValidation = 3) {         //initiena 3 par défaut pour la page Validation.php si non erreur
        $data['pageTitle'] = "Ajout Sous Categorie";                            //titre de la page de destination
        $data['pageToLoad'] = "souscategorie/SousCategorie_Add";                //path de a page de destination
        $data['checkValidation'] = $checkValidation;                            //tableau contenant int de validation avec le message qui lui correspond

		$this->load->view('home/Home', $data);                                  //page principale où on load les pages
	}

/* FONCTION D'INSERTION D'UN CATEGORIE */
    public function ajout_SousCategorie() {
        $idCategorie = $this->input->post('categorie');            //récupération de id de catégorie
        $nomSousCategorie = $this->input->post('souscategorie');   //récupération de nom de 

        if (empty($nomCategorie)) {                                 //si une des valeurs dans l'insertion est nulle ou vide 
            $this->session->set_flashdata('checkValidation', [      //on fait revenir vers la page d'insertion avec un popup d'erreur 
                'intValidation' => 0,                               //int de validation si champ vide = 0
                'message' => "Veuillez remplir tous les champs !"   //message de validation pour page Validation.php
            ]); 
        } else {                                                    //si aucune valeur n'est vide ou nulle
            $primaryKey = $this->dao->primaryKeyWithSequence('seq_categoriemateriel', 'CTGR');      //id de la categorie qu'on va créer
            
            //nom de colone => valeur de la colonne
            $to_insert = [                                                                          //on craft le tableau qui va servir à l'insertion
                'id_categorieemploie' => $primaryKey,                                              //id de categorie
                'nom_categorieemploie' => $nomCategorie                                            //nom de categorie => valeur de la colonne
            ];
            
            $inserted = $this->dao->insert_into('categorieEmploie', $to_insert);     //retour de id de insertion si insertion réussi ($inserted != null)
            
            if ($inserted) {                                            //si la valeur de $inserted n'est pas null alors insertion réussi
                $this->session->set_flashdata('checkValidation', [              //redirect vers page d'insertion + popup de validation de insertion réussi
                    'intValidation' => 0,                                       //int de validation si insertion réussi
                    'message' => "Catégorie d'employé créée avec succès !"      //message de validation pour page Validation.php
                ]);
            } else {                                                    //si la valeur de $inserted est pas null alors insertion raté                
                $this->session->set_flashdata('checkValidation', [              //redirect vers page d'insertion + popup de validation de insertion raté
                    'intValidation' => 0,                                       //int de validation si insertion raté
                    'message' => "Echec de la création de la catégorie !"       //message de validation pour page Validation.php
                ]);
            }
        }
        redirect('categorie/C_Categorie/page_AjoutCategorie');          //redirection vers la fonction page_AjoutBesoin
    }

/* FONCTION POUR VERIFIER SI LE NOM DE SOUS CATEGORIE N'EST PAS VIDE */
    // public function checkChampVide($) {

    // }

/* FONCTION POUR AVOIR LA LISTE DES CATEGORIES DES MATERIELS */
    public function getListeCategorie(){
        $data['pageTitle'] = "Liste Categorie";                                     //titre de la page de destination
        $data['pageToLoad'] = "categorie/Categorie_List";                           //path de a page de destination
        $data['liste_categorie'] = $this->dao->select_all('categorieEmploie');      //liste des categories de materiel
		$this->load->view('home/Home', $data);                                      //page principale où on load les pages
    }
}

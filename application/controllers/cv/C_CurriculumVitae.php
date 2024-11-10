<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_CurriculumVitae extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('dao_model', 'dao');
        $this->load->model('Pdf_model');
        $this->load->helper(array('form', 'url'));
    }

    public function page_AjoutCv($checkValidation = 3) {         //initiena 3 par défaut pour la page Validation.php si non erreur
        $data['pageTitle'] = "Ajout CurriculumVitae";                            //titre de la page de destination
        $data['pageToLoad'] = "cv/AddCv";                //path de a page de destination
        $data['checkValidation'] = $checkValidation;                            //tableau contenant int de validation avec le message qui lui correspond

		$this->load->view('home/Home', $data);                                  //page principale où on load les pages
	}

    public function showCvListe($checkValidation = 3) {    
        $data['cvs'] = $this->Pdf_model->getAllCvs();     
        $data['pageTitle'] = "Liste des CurriculumVitae";                            
        $data['pageToLoad'] = "cv/ListeCv";                
        $data['checkValidation'] = $checkValidation;                            
		$this->load->view('home/Home', $data);                                  
	}

    

    public function upload() {
        // Configuration pour l'upload
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 10000;  // taille max en KB
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('pdf_file')) {
            // En cas d'erreur
            $error = array('error' => $this->upload->display_errors());
            echo "Erreur d'upload : " . implode(', ', $error);
        } else {
            // En cas de succès
            $upload_data = $this->upload->data();
            $file_path = './uploads/' . $upload_data['file_name'];
    
            // Enregistrement dans la base de données
            $title = $this->input->post('title');
            $this->Pdf_model->savePdf($title, $file_path);  // Enregistre le chemin du fichier
            
            echo "success";
        }
    }

    public function viewPdf($id) {
        $cv = $this->Pdf_model->getPdfById($id);
        
        if ($cv) {
            // Récupérer le chemin du fichier PDF
            $file_path = $cv->pdf_content;
            
            // Vérifier si le fichier existe
            if (file_exists($file_path)) {
                // Forcer l'affichage du PDF
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="cv_' . $cv->id . '.pdf"');
                readfile($file_path);  // Afficher le fichier PDF
            } else {
                echo 'Le fichier PDF est introuvable.';
            }
        } else {
            echo 'CV non trouvé.';
        }
    }
    
    

    /*public function viewPdf($id) {
        $cv = $this->Pdf_model->getPdfById($id);
    
        if ($cv) {
            // Décoder le contenu du PDF
            $pdf_content = $cv->pdf_content;
    
            // Vérifier si le contenu commence bien par "%PDF-"
            if (strpos($pdf_content, '%PDF-') !== false) {
                // Forcer le téléchargement du PDF
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="cv_' . $cv->id . '.pdf"');
                echo $pdf_content;  // Afficher le contenu PDF
            } else {
                echo 'Le fichier PDF n\'est pas valide.'; // Message si le contenu n'est pas valide
            }
        } else {
            echo 'CV non trouvé.';
        }
    }*/
    

    
    
}
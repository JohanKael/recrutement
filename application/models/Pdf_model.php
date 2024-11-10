<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_model extends CI_Model {
    public function savePdf($title, $pdf_content) {
        $data = array(
            'title' => $title,
            'pdf_content' => $pdf_content
        );
        $this->db->insert('pdf_files', $data);
    }

    public function getPdfById($id) {
        return $this->db->where('id', $id)->get('pdf_files')->row();
    }

    public function getAllCvs() {
        $query = $this->db->get('pdf_files'); // Récupère tous les CVs
        return $query->result_array(); // Retourne les résultats sous forme de tableau
    }
}
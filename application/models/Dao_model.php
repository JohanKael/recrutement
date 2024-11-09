<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

class Dao_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

/* FONCTION POUR CRAFT LA PRIMARY KEY AVEC UNE SEQUENCE
     @params : 
        - $nom_sequence : nom de la sequence 
        - $prefixe : prefixe de la primary specifique pour chaque table 
*/
     public function primaryKeyWithSequence($nom_sequence, $prefixe){
        $sequence = $this->dao->sequence($nom_sequence);        //valeur de la nextval de la sequence
        $tailleSequenceString = strlen(strval($sequence));      //taille de la sequence
        $primaryKey = "vide";
        if ($tailleSequenceString == 1) { $primaryKey = $prefixe."00000".$sequence; }
        else if ($tailleSequenceString == 2) { $primaryKey = $prefixe."0000".$sequence; }
        else if ($tailleSequenceString == 3) { $primaryKey = $prefixe."000".$sequence; }
        else if ($tailleSequenceString == 4) { $primaryKey = $prefixe."00".$sequence; }
        else if ($tailleSequenceString == 5) { $primaryKey = $prefixe."0".$sequence; }
        else if ($tailleSequenceString == 6) { $primaryKey = $prefixe."".$sequence; }
        return $primaryKey;
    }

/* FONCTION POUR RECUPERER LA VALEUR D'UNE SEQUENCE
     @params : nom de la sequence */
    public function sequence($nom_sequence){
        $sql = "select nextval('".$nom_sequence."')";
        $query = $this->db->query($sql);

        if ($query) {
            $tab_sequence = $query->result_array();
            return $tab_sequence[0]['nextval'];
        }
        return false;
    }


    // fonction qui select tout dans une table
    // @params : nom de la table
    public function select_all($nom_table){
        $query = $this->db->get($nom_table);
        return $query->result_array();
    }





    // fonction qui select where avec des conditions
    // @params : nom de la table, conditions de la forme : $conditions = [
    //                                                                       'id' => 1,
    //                                                                       'nom' => 'Jean'
    //                                                                   ];
    public function select_where($nom_table, $conditions){
        $this->db->where($conditions);
        $query = $this->db->get($nom_table);
        return $query->result_array();
    }




    // fonction qui insert une entité dans une table et retourne l'id de l'entité inséré(peut être utile)
    // @params : nom de la table,  données de la forme : $donnees = [
    //                                                                  'nom' => 'Jean',
    //                                                                  'email' => 'jean@jean.com'
    //                                                              ];
    public function insert_into($nom_table, $data_to_insert){
        if ($this->db->insert($nom_table, $data_to_insert)) {
            return $this->db->insert_id();
        }
        return false;
    }


    public function saveData($nom_table, $data_to_insert, $columnId) {
        // Insérer les données
        if ($this->db->insert($nom_table, $data_to_insert)) {
            // Récupérer la dernière ligne insérée en utilisant les mêmes valeurs que dans l'insertion
            $this->db->select($columnId); // Remplacez `id` par le nom de votre colonne d'ID
            $this->db->from($nom_table);
    
            // Appliquer les conditions pour les valeurs uniques de `$data_to_insert`
            foreach ($data_to_insert as $column => $value) {
                $this->db->where($column, $value);
            }
    
            // Trier par ID dans l'ordre décroissant et limiter à un seul résultat
            $this->db->order_by($columnId, 'DESC'); // Assurez-vous que `id` est bien le nom de la colonne ID
            $this->db->limit(1);
    
            $query = $this->db->get();
    
            if ($query->num_rows() > 0) {
                return $query->row()->$columnId; // Remplacez `id` par le nom de votre colonne d'ID
            }
        }
        return false;
    }
    


    // fonction qui update une ligne d'une table
    //  @params : nom de la table, nouvelles données, conditions d'update
    // $to_update = [
    //     'nom' => 'Maxime Modifié',
    //     'email' => 'maxime_modifie@example.com'
    // ];
    // $conditions = [
    //     'id' => $id
    // ];
    public function update($nom_table, $to_update, $conditions){
        $this->db->where($conditions);
        
        if ($this->db->update($nom_table, $to_update)) {
            return $this->db->affected_rows();
        }
        
        return false;
    }




    // fonction qui delete une ou des lignes dans une table selon la condition mise
    // @params : nom de la table, conditions de suppression
    // $conditions = [
    //                  'email' => $email
    //               ];
    public function delete($nom_table, $conditions){
        $this->db->where($conditions);

        if ($this->db->delete($nom_table)) {
            return $this->db->affected_rows();
        }

        return false;
    }




    // fonction qui exécute n'importe quel commande sql
    // @params : une commande sql comme : $sql = "SELECT * FROM users WHERE nom = 'Jean'";
    public function executeQuery($sql) {
        $query = $this->db->query($sql);

        if ($query) {
            return $query->result_array();
        }

        return false;
    }



}
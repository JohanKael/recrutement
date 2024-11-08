<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

class Dao_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
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
        return null;
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
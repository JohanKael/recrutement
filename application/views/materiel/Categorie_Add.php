    <h2>Ajout d'une catégorie de matériel</h2>
    <form action="<?php echo base_url('materiel/C_Categorie/ajout_CategorieMateriel') ?>" method="POST">   
        <div class="col-md-10 achatMatiere">
            <div class="quantite">
                <h4 class="titleMatiere">Nom :</h4>
                <input type="text" name="categorie" class="selectMats">
                <div class="titleMatiere"></div>
            </div>  
            <div class="submitButton">
                <input type="submit" value="CONFIRMER">
            </div>
        </div>
    </form>
<?php $this->load->view('component/validation/Validation'); ?>
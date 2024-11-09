    <h2>Ajout d'un matériel</h2>
    <form action="<?php echo base_url('materiel/C_Materiel/ajout_Materiel') ?>" method="POST">   
        <div class="col-md-10 achatMatiere">
            <div class="quantite"> 
                <div class="titleMatiere"><h4>Catégorie : </h4></div>
                <select class="selectMats" name="categorie">
                    <?php foreach($liste_categoriemateriel as $categorie) { ?>
                        <option value="<?php echo $categorie['id_categoriemateriel'] ?>"><?php echo $categorie['nom_categoriemateriel'] ?></option>
                    <?php } ?>
                </select>
                <div class="titleMatiere"></div>
            </div>
            <div class="quantite">
                <h4 class="titleMatiere">Nom :</h4>
                <input type="text" name="nom" class="selectMats">
                <div class="titleMatiere"></div>
            </div>  
            <div class="quantite"> 
                <div class="titleMatiere"><h4>Unité : </h4></div>
                <select class="selectMats" name="unite">
                    <?php foreach($liste_unite as $unite) { ?>
                        <option value="<?php echo $unite['nom'] ?>"><?php echo $unite['nom'] ?></option>
                    <?php } ?>
                </select>
                <div class="titleMatiere"></div>
            </div>
            <div class="submitButton">
                <input type="submit" value="CONFIRMER">
            </div>
        </div>
    </form>
<?php $this->load->view('component/validation/Validation'); ?>
    <style>
        .moreBesoin {
            margin-top : 2.5%;
        }
    </style>
    <h2>Ajout d'une demande de besoin de talent</h2>
    <form action="<?php echo base_url('besoin/C_Besoin/ajout_besoin') ?>" method="POST">   
        <div class="col-md-10 achatMatiere">
            <div class="quantite"> 
                <div class="titleMatiere"><h4>Poste : </h4></div>
                <select class="selectMats" name="poste">
                    <?php foreach($poste as $oneposte) { ?>
                        <option value="<?php echo $oneposte['id_poste'] ?>"><?php echo $oneposte['intitule'] ?></option>
                    <?php } ?>
                </select>
                <div class="titleMatiere"></div>
            </div>
            <div class="quantite">
                <h4 class="titleMatiere">Date de demande :</h4> 
                <input type="date" name="datedemande" class="selectMats">
                <div class="titleMatiere"></div>
            </div>
            <div class="quantite">
                <h4 class="titleMatiere">Description :</h4>
                <input type="text" name="description" class="selectMats">
                <div class="titleMatiere"></div>
            </div>  
            <div class="quantite">
                <h4 class="titleMatiere">Objectif :</h4>
                <input type="text" name="objectif" class="selectMats">
                <div class="titleMatiere"></div>
            </div>  
            <div class="quantite">
                <h4 class="titleMatiere">Qualification :</h4>
                <input type="text" name="qualification" class="selectMats">
                <div class="titleMatiere"></div>
            </div>  
            <div class="submitButton">
                <input type="submit" value="CONFIRMER">
            </div>
        </div>

    </form>
<?php $this->load->view('component/validation/Validation'); ?>

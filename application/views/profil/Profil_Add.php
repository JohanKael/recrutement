<style>
        .moreBesoin {
            margin-top : 2.5%;
        }
    </style>
    <style>
        .checkBox {
            margin-top : 20px;
        }

        .checkBoxDisplay {
            display: flex;
            justify-content: space-between;
        }

        .checkBoxContent {
            font-size: 16px;
            display: flex;
            align-items: baseline;
            margin: 6px 0 0 -70px;
        }

        .checkBoxInput {
            transform: scale(1.5);
        }

        .checkBoxLabel {
            font-weight: inherit;
        }

        .titreLabel {
            width: 100%;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: -85px; 
        }

        .moreInsertion {
            margin-top : 2%;
        }
    </style>
    <h2>Dresser un profil</h2>
    <form action="<?php echo base_url('profil/C_Profil/ajout_profil') ?>" method="POST">   
        <div class="col-md-10 achatMatiere">         
            <div class="quantite">
                <h4 class="titleMatiere">Poste :</h4>
                <input type="text" class="selectMats" value="<?php echo $detail_talent[0]['intitule'] ?>" readonly>
                <input type="hidden" name="demandetalent" class="selectMats" value="<?php echo $detail_talent[0]['id_demandetalent'] ?>">
                <div class="titleMatiere"></div>
            </div>  
            <div class="quantite">
                <h4 class="titleMatiere">Date validation de demande :</h4> 
                <input type="date" name="datevalidation" class="selectMats" value="<?php echo $detail_talent[0]['datechecktalent'] ?>">
                <div class="titleMatiere"></div>
            </div>
            <div class="quantite">
                <h4 class="titleMatiere">Date de demande :</h4> 
                <input type="date" name="datedemande_profil" class="selectMats">
                <div class="titleMatiere"></div>
            </div>
            <div class="checkBox">
                <div class="titleMatiere"><h4>Diplome : </h4>
                    <?php foreach ($diplome as $onediplome) { ?>
                        <div class="checkBoxContent">
                            <input class="checkBoxInput" type="radio" name="diplome" value="<?php echo $onediplome['id_diplome']; ?>">
                            <label class="checkBoxLabel"><?php echo $onediplome['nom_diplome']; ?></label>
                        </div>
                    <?php } ?>
                </div>   
            </div>
            <div class="quantite">
                <h4 class="titleMatiere">Experience minimum :</h4>
                <input type="text" name="minexp" class="selectMats">
                <div class="titleMatiere"></div>
            </div>  
            <div class="quantite">
                <h4 class="titleMatiere">Age minimum :</h4>
                <input type="text" name="minage" class="selectMats">
                <div class="titleMatiere"></div>
            </div>  
            <div class="quantite">
                <h4 class="titleMatiere">Age maximum :</h4>
                <input type="text" name="maxage" class="selectMats">
                <div class="titleMatiere"></div>
            </div>  
            <div class="submitButton">
                <input type="submit" value="CONFIRMER">
            </div>
        </div>

    </form>
<?php $this->load->view('component/validation/Validation'); ?>

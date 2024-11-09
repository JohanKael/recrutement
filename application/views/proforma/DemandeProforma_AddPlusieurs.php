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

        input[type="checkbox"] {
            margin-right: -85px; 
        }

        .moreInsertion {
            margin-top : 2%;
        }
    </style>
    <h2>Ajout d'une demande de Proforma</h2>
    <form action="<?php echo base_url('proforma/C_Proforma/ajout_plusieursDemandeProforma') ?>" method="POST">   
        <div class="col-md-10 achatMatiere">
            <div class="quantite">
                <h4 class="titleMatiere">Objet :</h4>
                <input type="text" name="objet" class="selectMats" id="quantiteInput">
                <div class="titleMatiere"></div>
            </div>   
            <div class="quantite">
                <h4 class="titleMatiere">Date demande de proforma :</h4> 
                <input type="date" name="dateDemandeProforma" class="selectMats">
                <div class="titleMatiere"></div>
            </div>
            <div class="col-md-10 checkBoxDisplay">
                <div class="checkBox">
                    <h3 class="titreLabel">Demande de Proforma :</h3>
                    <?php foreach ($liste_demandeProforma as $demande) { ?>
                        <div class="checkBoxContent">
                            <input class="checkBoxInput" type="checkbox" name="demandeProforma[]" value="<?php echo $demande['id_besoinglobal']; ?>">
                            <label class="checkBoxLabel"><?php echo $demande['objetdemande']; ?> 
                            le <?php $date = new DateTime($demande['datevalidation']);
                            echo $date->format('d F Y'); ?> </label>
                        </div>
                    <?php } ?>
                </div>  
                
                <div class="checkBox">
                    <h3 class="titreLabel">Fournisseurs :</h3>
                    <?php foreach ($liste_fournisseur as $fournisseur) { ?>
                        <div class="checkBoxContent">
                            <input class="checkBoxInput" type="checkbox" name="fournisseur[]" value="<?php echo $fournisseur['id_fournisseur']; ?>">
                            <label class="checkBoxLabel"><?php echo $fournisseur['nom_entreprise']; ?></label>
                        </div>
                    <?php } ?>
                </div>   
            </div>
            <div class="submitButton">
                <input type="submit" value="CONFIRMER">
            </div>
        </div>
    </form>
       
<?php $this->load->view('component/validation/Validation'); ?> 
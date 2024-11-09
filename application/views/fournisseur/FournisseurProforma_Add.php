<style>
        .moreInsertion {
            margin-top : 2%;
        }
    </style>
    <h2>Création d'un Proforma</h2>
    <form action="<?php echo base_url('proforma/C_ProformaFournisseur/ajout_proforma') ?>" method="POST">   
        <div class="col-md-10 achatMatiere">
            <div class="quantite"> 
                <input type="hidden" name="demandeProforma" value="<?php echo $detail_demandeProforma[0]['id_demandeproforma']; ?>">
                <input type="hidden" name="fournisseur" value="<?php echo $detail_demandeProforma[0]['id_fournisseur']; ?>">
                <div class="titleMatiere"></div>
            </div>
            <div class="quantite">
                <h4 class="titleMatiere">Date d'émission :</h4> 
                <input type="date" name="dateEmission" class="selectMats">
                <div class="titleMatiere"></div>
            </div>
            <div class="quantite">
                <h4 class="titleMatiere">Date d'expiration :</h4> 
                <input type="date" name="dateExpiration" class="selectMats">
                <div class="titleMatiere"></div>
            </div>
            <?php foreach ($detail_demandeProforma as $one_detail) { ?>
                <div class="quantite"> 
                    <input type="hidden" name="quantite[]" value="<?php echo $one_detail['quantite']; ?>">
                    <input type="hidden" name="materiel[]" value="<?php echo $one_detail['id_materiels']; ?>">
                    <div class="titleMatiere"></div>
                </div>
                <div class="quantite"> 
                    <h4 class="titleMatiere">Matériel : </h4>
                    <input type="text" class="selectMats" id="quantiteInput" value="<?php echo $one_detail['nom_materiel']; ?>" readonly>
                    <div class="titleMatiere"></div>
                </div>
                <div class="quantite">
                    <h4 class="titleMatiere">Prix Unitaire :</h4>
                    <input type="text" name="prixunitaire[]" class="selectMats" id="quantiteInput" value="">
                    <div class="titleMatiere"></div>
                </div>   
            <?php } ?>
            <div class="submitButton">
                <input type="submit" value="CONFIRMER">
            </div>
        </div>
    </form>
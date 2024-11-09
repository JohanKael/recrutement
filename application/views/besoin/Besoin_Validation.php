    <style>
        .annuler {
            background-color: rgb(255 0 0 / 66%);
            border: none;
            color: #FFF;
            transition: .3s;
            border-radius: 30px;
            width: 250px;
            height: 40px;
        }
        
        .annuler:hover{
            background-color: #FFF;
            color: rgb(255 0 0 / 66%);
            border: 1px solid rgb(255 0 0 / 66%);
        }

        .annulertxt {
            padding: 10px 0px 0px 87px;
        }
    </style>
    <h2>Validation de demande de Besoins</h2>
    <form action="<?php echo base_url('besoin/C_Besoin/valider_besoinChecked') ?>" method="POST">   
        <div class="col-md-10 achatMatiere">
            <div class="quantite">
                <h4 class="titleMatiere">Date dernière demande :</h4> 
                <input type="date" name="datevalidationdemande" class="selectMats" value="<?php echo $last_date[0]['derniere_demande'] ?>" readonly>
                <div class="titleMatiere"></div>
            </div>
            <div class="quantite">
                <h4 class="titleMatiere">Date validation de demande :</h4> 
                <input type="date" name="datevalidationdemande" class="selectMats">
                <div class="titleMatiere"></div>
            </div>
            <div class="quantite">
                <h4 class="titleMatiere">Matériel :</h4>
                <input type="hidden" name="id_materiel" class="selectMats" value="<?php echo $liste_besoinMateriel[0]['id_materiels'] ?>" readonly>
                <input type="text" name="materiel" class="selectMats" value="<?php echo $liste_besoinMateriel[0]['nom_materiel'] ?>" readonly>
                <div class="titleMatiere"></div>
            </div>  
            <div class="quantite">
                <h4 class="titleMatiere">Objet de la demande :</h4>
                <input type="text" name="objet" class="selectMats">
                <div class="titleMatiere"></div>
            </div>  
            <div class="quantite">
                <h4 class="titleMatiere">Quantité :</h4>
                <input type="text" name="quantite" class="selectMats" value="<?php echo $liste_besoinMateriel[0]['total_quantite'] ?>" readonly>
                <div class="titleMatiere"></div>
            </div>  
            <div class="quantite">
                <h4 class="titleMatiere">Unité :</h4>
                <input type="text" name="unite" class="selectMats" value="<?php echo $liste_besoinMateriel[0]['unite_materiel'] ?>" readonly>
                <div class="titleMatiere"></div>
            </div>  
            <div class="submitButton" style="display: inline-flex; justify-content: space-between;">
                <input type="submit" value="CONFIRMER">
                <a href="<?php echo base_url('besoin/C_Besoin/liste_besoins')?>">
                    <div class="annuler"><div class="annulertxt">ANNULER</div></div>
                </a>
                <div class="titleMatiere"></div>
            </div>
        </div>
    </form>

            <div class="info">
            </div>
    
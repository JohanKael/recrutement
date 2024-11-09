    <style>
        .checkBoxInput {
            transform: scale(1.5);
        }
        input[type="checkbox"] {
            margin-right: -40px;
            width: 50px;
        }
    </style>
    <h2>Creation d'un bon de commande</h2>
    <form action="<?php echo base_url('boncommande/C_BonCommande/afficher_bonCommande') ?>" method="POST"> 
        <div class="col-md-10 achatMatiere">
                <input type="hidden" name="size" value="<?php echo count($liste_proforma[0]); ?>" readonly>
        <?php for ($i=0; $i < count($liste_proforma[0]); $i++) { ?>  
            <div class="quantite">
                <h4 class="titleMatiere">Matériel :</h4>
                <input type="hidden" name="materiel[]" value="<?php echo $liste_proforma[0][$i]['id_materiels']; ?>" readonly>
                <input type="text" value="<?php echo $liste_proforma[0][$i]['nom_materiel']; ?>" class="selectMats" readonly>
                <div class="titleMatiere"></div>
            </div>  
                <table class="table" style="margin-top: 40px;">
                    <thead class="thead-dark">
                        <tr>
                            <th>Fournisseur</th>
                            <th>Prix Unitaire</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Devise</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($liste_proforma as $oneProforma) { ?>
                        <tr class="ligne">
                            <td><?php echo $oneProforma[$i]['id_fournisseur']; ?></td>
                            <td><?php echo $oneProforma[$i]['pu']; ?></td>
                            <td><?php echo $oneProforma[$i]['total_quantite']; ?></td>
                            <td><?php echo ($oneProforma[$i]['pu'] * $oneProforma[$i]['total_quantite']); ?></td>
                            <td>Ar</td>
                            <td><input class="checkBoxInput" type="checkbox" name="selected_proforma_<?php echo $i; ?>[]" value="<?php echo $oneProforma[$i]['id_proforma']. '|' . $oneProforma[$i]['id_fournisseur']; ; ?>"></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table> 
        <?php } ?>
        </div>
            <div class="submitButton">
                <input type="submit" value="CONFIRMER">
            </div>
    </form>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Itère sur chaque groupe de checkboxes par index
        <?php for ($i = 0; $i < count($liste_proforma[0]); $i++) { ?>
            let checkboxesGroup<?php echo $i; ?> = document.querySelectorAll('input[name="selected_proforma_<?php echo $i; ?>"]');
            checkboxesGroup<?php echo $i; ?>.forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    if (this.checked) {
                        checkboxesGroup<?php echo $i; ?>.forEach(cb => {
                            if (cb !== this) {
                                cb.checked = false;
                            }
                        });
                    }
                });
            });
        <?php } ?>
    });
</script>
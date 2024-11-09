    <style>
        .moreInsertion {
            margin-top : 2%;
        }
    </style>
    <h2>Ajout d'une demande de Proforma</h2>
    <form action="<?php echo base_url('proforma/C_Proforma/ajout_proforma') ?>" method="POST">   
        <div class="col-md-10 achatMatiere">
            <div class="quantite"> 
                <div class="titleMatiere"><h4>Besoin : </h4></div>
                <select class="selectMats" name="besoinglobal" onchange="updateQuantite()">
                    <?php foreach($liste_besoinGlobale as $besoin) { ?>
                        <option value="<?php echo $besoin['id_besoinglobal']; ?>" data-unite="<?php echo $besoin['quantite']; ?>" data-dateValidation="<?php echo $besoin['datevalidation']; ?>" selected><?php echo $besoin['objetdemande'] ?></option>
                    <?php } ?>
                </select>
                <div class="titleMatiere"></div>
            </div>
            <div class="quantite">
                <h4 class="titleMatiere">Quantité :</h4>
                <input type="text" name="quantite" class="selectMats" id="quantiteInput" value="">
                <div class="titleMatiere"></div>
            </div>   
            <div class="quantite">
                <h4 class="titleMatiere">Date validation demande :</h4> 
                <input type="date" name="dateValidation" class="selectMats" id="dateValidationInput" value="" readonly>
                <div class="titleMatiere"></div>
            </div>
            <div class="quantite">
                <h4 class="titleMatiere">Date demande de proforma :</h4> 
                <input type="date" name="dateDemandeProforma" class="selectMats">
                <div class="titleMatiere"></div>
            </div>
                <input type="hidden" name="multipleInsertion" class="selectMats" value="false">
            <div class="submitButton">
                <input type="submit" value="CONFIRMER">
                <input type="button" id="addButton" value="AJOUTER UN FOURNISSEUR" style="margin-left: 15%;">
        </div>

        <div class="col-md-9 moreInsertion" id="champForMore"></div>
    </form>
    
<?php $this->load->view('component/validation/Validation'); ?>

        <div class="col-md-10 achatMatiere" id="templateForMoreInput" style="display: none; margin-top : 6%;"> 
            <div class="quantite"> 
                <div class="titleMatiere"><h4>Besoin : </h4></div>
                <select class="selectMats" name="liste_fournisseurs[]">
                    <?php foreach($liste_fournisseur as $fournisseur) { ?>
                        <option value="<?php echo $fournisseur['id_fournisseur'] ?>"><?php echo $fournisseur['nom_entreprise'] ?></option>
                    <?php } ?>
                </select>
                <div class="titleMatiere"></div>
            </div>
            <button class="delete">SUPPRIMER</button>
        </div> 
        

<script>
    document.getElementById('addButton').addEventListener('click', function() {
        event.preventDefault(); // Empêcher la soumission du formulaire
        var templateForMoreInput = document.getElementById('templateForMoreInput');
        var clone = templateForMoreInput.cloneNode(true);
        clone.id = ''; // Supprimer l'ID pour éviter les conflits
        clone.style.display = 'block';
        
        // Ajouter un événement pour supprimer l'élément cloné
        clone.querySelector('.delete').addEventListener('click', function() {
            clone.remove();
            checkAddedInputCount(); // Vérifier après la suppression
        });

        document.getElementById('champForMore').appendChild(clone);
        checkAddedInputCount(); // Vérifier après l'ajout
    });              

    // Fonction pour vérifier le nombre d'éléments dans #champForMore
    function checkAddedInputCount() {
        var champForMore = document.getElementById('champForMore');
        var hiddenInput = document.querySelector('input[name="multipleInsertion"]');
        
        // Si le champ contient des éléments enfants, mettre multipleInsertion à true
        if (champForMore.children.length > 0) {
            hiddenInput.value = 'true';
        } else {
            hiddenInput.value = 'false';
        }
    }

    // Initialement, on vérifie l'état pour mettre à jour multipleInsertion correctement
    checkAddedInputCount();

    function updateQuantite() {
        var selectElement = document.querySelector('.selectMats');
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var quantite = selectedOption.getAttribute('data-unite');
        document.getElementById('quantiteInput').value = quantite;
        
        var dateValidation = selectedOption.getAttribute('data-dateValidation');
        document.getElementById('dateValidationInput').value = dateValidation;
    }
    document.addEventListener("DOMContentLoaded", updateQuantite);

</script>
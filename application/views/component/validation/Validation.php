    <?php 
    $checkValidation = $this->session->flashdata('checkValidation');
    if (isset($checkValidation) && is_array($checkValidation)) { ?>
        <div class="popupUser" id="popupReset">
            <div class="popup-contentEntree" id="popupContent">
                <h3><?php echo $checkValidation['message']; ?></h3>
                <div class="infoUser">
                    <button class="popup-buttonAccount" type="button" id="continueButton">CONTINUER</button>
                </div>
            </div>
        </div> 
    <?php } ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var popupReset = document.getElementById('popupReset');
            if (popupReset) {                                                                           // Afficher le popup
                popupReset.style.display = 'flex';                                                      // Ajouter un événement au bouton "CONTINUER"
                document.getElementById('continueButton').addEventListener('click', function() {        // Masquer le popup
                    popupReset.style.display = 'none';
                });

                // Appel AJAX pour effacer le flashdata
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo base_url('C_Home/clearCheckValidation'); ?>', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log("Flashdata effacé après clic sur CONTINUER.");
                    }
                };
                xhr.send();
            }
        });
    </script>
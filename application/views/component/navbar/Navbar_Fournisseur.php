<div class="col-md-1 url">
        <div class="logodiv"><img class="logo" src="<?php echo base_url('assets/image/logo.jpg'); ?>"></div>
        <div class="scroll-container">
            <a href="<?php echo base_url('login_controller/disconnect')?>">
                <div class="boutonnavbar">
                    <span class="glyphicon glyphicon-th-large icon" aria-hidden="true"></span>
                    <span class="link-text">Log Out</span>
                </div>
            </a>
            <a href="<?php echo base_url('C_Home')?>">
                <div class="boutonnavbar">
                    <span class="glyphicon glyphicon-home icon" aria-hidden="true"></span>
                    <span class="link-text">Home</span>
                </div>
            </a>
            <a href="<?php echo base_url('proforma/C_ProformaFournisseur/page_ListDemandeProformaFournisseur/3')?>">
                <div class="boutonnxavbar">
                    <span class="glyphicon glyphicon-list icon" aria-hidden="true"></span>
                    <span class="link-text">Demande Proforma</span>
                </div>
            </a>
            <a href="<?php echo base_url('proforma/C_ProformaFournisseur/page_ListDemandeProformaFournisseur/3')?>">
                <div class="boutonnavbar">
                    <span class="glyphicon glyphicon-list icon" aria-hidden="true"></span>
                    <span class="link-text">Bon Commande</span>
                </div>
            </a>
 
            <!-- <div class="boutonnavbar" id="fournisseur" data-dropdown="dropdownMenufournisseur">
                <span class="glyphicon glyphicon-grain icon" aria-hidden="true"></span>
                <span class="link-text">Fournisseur</span>
                <span class="glyphicon glyphicon-menu-down down" aria-hidden="true"></span>
            </div>  
                <div id="dropdownMenufournisseur" class="dropdown-content">
                    <a href="">
                        <div class="boutonnavbar">
                            <span class="glyphicon glyphicon-list icon" aria-hidden="true"></span>
                            <span class="link-text">Demande Profoma</span>
                        </div>
                    </a>
                </div> -->
        </div>
    </div>
    
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentDropdown = null;  // Stocker le menu actuellement ouvert

    var boutons = document.querySelectorAll('.boutonnavbar[data-dropdown]');
    
    // Vérifie l'état de l'élément dans le local storage lors du chargement de la page
    const openDropdownId = localStorage.getItem('openDropdownId');
    if (openDropdownId) {
        const dropdownToOpen = document.getElementById(openDropdownId);
        if (dropdownToOpen) {
            openDropdown(dropdownToOpen);
        }
    }

    boutons.forEach(function(bouton) {
        bouton.addEventListener('click', function(event) {
            event.preventDefault();

            var dropdownId = bouton.getAttribute('data-dropdown');
            var dropdown = document.getElementById(dropdownId);

            // Fermer le menu actuellement ouvert si ce n'est pas celui cliqué
            if (currentDropdown && currentDropdown !== dropdown) {
                closeDropdown(currentDropdown);
            }

            // Si le dropdown est déjà ouvert, le fermer ; sinon, l'ouvrir
            if (dropdown.classList.contains('show')) {
                closeDropdown(dropdown);
                currentDropdown = null;  // Réinitialiser le menu actuellement ouvert
                localStorage.removeItem('openDropdownId'); // Réinitialiser le stockage
            } else {
                openDropdown(dropdown);
            }
        });
    });
    function openDropdown(dropdown) {
        console.log(dropdown.scrollHeight);
        dropdown.style.maxHeight = dropdown.scrollHeight + 'px'; // Utiliser scrollHeight
        dropdown.style.opacity = '1';
        dropdown.classList.add('show');
        currentDropdown = dropdown;
        // Sauvegarder l'état dans le local storage
        localStorage.setItem('openDropdownId', dropdown.id);
    }

    function closeDropdown(dropdown) {
        dropdown.style.maxHeight = '0'; // Réinitialiser à 0 pour la transition
        dropdown.style.opacity = '0';
        setTimeout(() => {
            dropdown.classList.remove('show'); // Retirer la classe après la transition
        }, 500); // Correspond à la durée de la transition
    }
});
</script>

    
<!--            <a href="C_Notification_L">
                <div class="notification">
                    <span class="glyphicon glyphicon-bell notificationicon" aria-hidden="true"></span>
                    <span class="notificationlink-text">Notification</span>
                    <span class="notificationbadge"></span>
                </div>
            </a>-->

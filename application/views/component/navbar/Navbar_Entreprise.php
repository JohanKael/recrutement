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
            
            <div class="boutonnavbar" id="besoin" data-dropdown="dropdownMenubesoin">
                <span class="glyphicon glyphicon-shopping-cart icon" aria-hidden="true"></span>
                <span class="link-text">Besoins</span>
                <span class="glyphicon glyphicon-menu-down down" aria-hidden="true"></span>
            </div>
                <div id="dropdownMenubesoin" class="dropdown-content">
                    <a href="<?php echo base_url('besoin/C_Besoin/page_AjoutBesoin/3')?>">
                        <div class="boutonnavbar">
                            <span class="glyphicon glyphicon-plus-sign icon" aria-hidden="true"></span>
                            <span class="link-text">Ajout</span>
                        </div>
                    </a>
                    <a href="<?php echo base_url('besoin/C_Besoin/liste_besoins/3')?>">
                        <div class="boutonnavbar">
                            <span class="glyphicon glyphicon-list icon" aria-hidden="true"></span>
                            <span class="link-text">Liste</span>
                        </div>
                    </a>
                </div>
            
            <div class="boutonnavbar" id="categorie" data-dropdown="dropdownMenucategorie">
                <span class="glyphicon glyphicon-list-alt icon" aria-hidden="true"></span>
                <span class="link-text">Catégorie Matériel</span>
                <span class="glyphicon glyphicon-menu-down down" aria-hidden="true"></span>
            </div>
                <div id="dropdownMenucategorie" class="dropdown-content">
                    <a href="<?php echo base_url('materiel/C_Categorie/page_AjoutCategorieMateriel/3')?>">
                        <div class="boutonnavbar">
                            <span class="glyphicon glyphicon-plus-sign icon" aria-hidden="true"></span>
                            <span class="link-text">Ajout</span>
                        </div>
                    </a>
                    <a href="<?php echo base_url('materiel/C_Categorie/getListeCategorie')?>">
                        <div class="boutonnavbar">
                            <span class="glyphicon glyphicon-list icon" aria-hidden="true"></span>
                            <span class="link-text">Liste</span>
                        </div>
                    </a>
                </div>
            
            <div class="boutonnavbar" id="materiel" data-dropdown="dropdownMenumateriel">
                <span class="glyphicon glyphicon-print icon" aria-hidden="true"></span>
                <span class="link-text">Matériel</span>
                <span class="glyphicon glyphicon-menu-down down" aria-hidden="true"></span>
            </div>
                <div id="dropdownMenumateriel" class="dropdown-content">
                    <a href="<?php echo base_url('materiel/C_Materiel/page_AjoutMateriel/3')?>">
                        <div class="boutonnavbar">
                            <span class="glyphicon glyphicon-plus-sign icon" aria-hidden="true"></span>
                            <span class="link-text">Ajout</span>
                        </div>
                    </a>
                    <a href="<?php echo base_url('materiel/C_Materiel/getListeMateriel')?>">
                        <div class="boutonnavbar">
                            <span class="glyphicon glyphicon-list icon" aria-hidden="true"></span>
                            <span class="link-text">Liste</span>
                        </div>
                    </a>
                </div>

            <div class="boutonnavbar" id="facture" data-dropdown="dropdownMenufacture">
                <span class="glyphicon glyphicon-folder-open icon" aria-hidden="true"></span>
                <span class="link-text">Facture</span>
                <span class="glyphicon glyphicon-menu-down down" aria-hidden="true"></span>
            </div>  
                <div id="dropdownMenufacture" class="dropdown-content">
                    <a href="<?php echo base_url('proforma/C_Proforma/page_rechercheProforma/3')?>">
                        <div class="boutonnavbar">
                            <span class="glyphicon glyphicon-open-file icon" aria-hidden="true"></span>
                            <span class="link-text">Liste Profoma</span>
                        </div>
                    </a>
                    <a href="<?php echo base_url('proforma/C_Proforma/page_ListBesoinSansDemandeProforma/3')?>">
                        <div class="boutonnavbar">
                            <span class="glyphicon glyphicon-list icon" aria-hidden="true"></span>
                            <span class="link-text">Liste Besoin</span>
                        </div>
                    </a>
                </div>
                
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

<style>
        .table {
            margin-top: 2.5%;
        }
    </style>
    <h2>Liste des demandes de talents</h2>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>N° Demande Talent</th>
                <th>Date Demande</th>
                <th>Date Validation</th>
                <th>Poste</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($liste_talent as $talent) { ?>
                <tr class="ligne" data-href="<?php echo base_url('profil/C_Profil/page_DetailProfilValide/'.$talent['id_demandetalent']); ?>">
                    <td><?php echo $talent['id_demandetalent']; ?></td>
                    <td><?php echo $talent['datedemandetalent']; ?></td>
                    <td><?php echo $talent['datechecktalent']; ?></td>
                    <td><?php echo $talent['intitule']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php $this->load->view('component/validation/Validation'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sélectionner toutes les lignes de table avec l'attribut data-href
            var rows = document.querySelectorAll('.ligne[data-href]');

            rows.forEach(function(row) {
                row.addEventListener('click', function() {
                    // Rediriger vers l'URL stockée dans l'attribut data-href
                    window.location.href = this.getAttribute('data-href');
                });
            });
        });
    </script>  
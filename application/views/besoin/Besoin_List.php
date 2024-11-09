    <style>
        .table {
            margin-top: 2.5%;
        }
    </style>
    <h2>Liste des demandes de besoins</h2>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Matériel</th>
                <th>Quantité</th>
                <th>Unité</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($liste_besoin as $besoin) { ?>
                <tr class="ligne" data-href="<?php echo base_url('besoin/C_Besoin/detail_besoin/'.$besoin['id_materiels']); ?>">
                    <td><?php echo $besoin['nom_materiel']; ?></td>
                    <td><?php echo $besoin['total_quantite']; ?></td>
                    <td><?php echo $besoin['unite_materiel']; ?></td>
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
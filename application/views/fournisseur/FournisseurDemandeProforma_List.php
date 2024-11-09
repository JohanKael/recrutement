<style>
        .modifier {
            background-color: rgb(255 96 0 / 66%);
            border: none;
            color: #FFF;
            transition: .3s;
            border-radius: 30px;
            width: 85%;
            height: 40px;
            margin-left: 70px;
        }
        
        .modifier:hover{
            background-color: #FFF;
            color: rgb(255 96 0 / 66%);
            border: 1px solid rgb(255 96 0 / 66%);
        }

        .table {
            margin-top: 2.5%;
        }
    </style>
    <h2>Liste des demandes de proforma</h2>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>N° Demande Proforma</th>
                <th>Objet</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody> 
            <?php foreach ($liste_demandeProformaSansProforma as $demandeProforma) { ?>
                <tr class="ligne" data-href="<?php echo base_url('proforma/C_ProformaFournisseur/detail_demandeproforma/'.$demandeProforma['id_demandeproforma']); ?>">
                    <td><?php echo $demandeProforma['id_demandeproforma']; ?></td>    
                    <td><?php echo $demandeProforma['objetdemandeproforma']; ?></td>
                    <td><?php echo $demandeProforma['datedemande_proforma']; ?></td>
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
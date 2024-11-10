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
            margin-top: 25%;
        }
    </style>
    <h2>Liste de Cv</h2>
    <form action="<?php echo base_url('proforma/C_Proforma/recherche_proforma') ?>" method="GET">   
        <div class="col-md-10 achatMatiere">
            <div class="quantite">
                <h4 class="titleMatiere">Numéro demande proforma : </h4>
                <input type="text" name="numerodemandeproforma" class="selectMats">
                <div class="titleMatiere"></div>
            </div>
            <div class="quantite">
                <h4 class="titleMatiere">Date de demande proforma : </h4>
                <input type="date" name="dateDemandeProforma" class="selectMats">
                <div class="titleMatiere"></div>
            </div>
            <div class="submitButton">
                <input type="submit" value="SEARCH">
            </div>
        </div>
    </form>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Titre</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cvs as $cv) { ?>
                <tr class="ligne">
                    <td><?php echo $cv['title']; ?></td>
                    <td>
                        <a href="<?php echo base_url('index.php/cv/C_CurriculumVitae/viewPdf/' . $cv['id']); ?>">Voir PDF</a>
                    </td>
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
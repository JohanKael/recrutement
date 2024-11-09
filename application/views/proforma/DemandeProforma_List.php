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
    <h2>Liste des demandes de besoins valide à faire une demande de proforma</h2>
    <div class="col-md-10 paginationselect">
        <span></span>
        <span></span>
        <span>
            <a href="<?php echo base_url('proforma/C_Proforma/page_AjoutPlusieursDemandeProforma/3')?>"><button class="modifier">FAIRE PLUSIEURS DEMANDE</button></a>
        </span>
    </div>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Objet</th>
                <th>Date</th>
                <th>Matériel</th>
                <th>Quantite</th>
                <th>Unité</th>
            </tr>
        </thead>
        <tbody> 
            <?php foreach ($liste_demandeProforma as $demandeProforma) { ?>
                <tr class="ligne">
                    <td><?php echo $demandeProforma['objetdemande']; ?></td>
                    <td><?php echo $demandeProforma['datevalidation']; ?></td>
                    <td><?php echo $demandeProforma['nom_materiel']; ?></td>
                    <td><?php echo $demandeProforma['quantite']; ?></td>
                    <td><?php echo $demandeProforma['unite_materiel']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php $this->load->view('component/validation/Validation'); ?>

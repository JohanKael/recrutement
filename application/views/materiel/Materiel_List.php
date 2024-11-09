    <style>
        .table {
            margin-top: 2.5%;
        }
    </style>
    <h2>Liste des matériels</h2>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Unite</th>
                <th>Catégorie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($liste_materiel as $materiel) { ?>
                <tr class="ligne" data-href="">
                    <td><?php echo $materiel['id_materiels']; ?></td>
                    <td><?php echo $materiel['nom_materiel']; ?></td>
                    <td><?php echo $materiel['unite_materiel']; ?></td>
                    <td><?php echo $materiel['nom_categoriemateriel']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <style>
        .table {
            margin-top: 2.5%;
        }
    </style>
    <h2>Liste des catégories de matériels</h2>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($liste_categorie as $categorie) { ?>
                <tr class="ligne" data-href="">
                    <td><?php echo $categorie['id_categoriemateriel']; ?></td>
                    <td><?php echo $categorie['nom_categoriemateriel']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
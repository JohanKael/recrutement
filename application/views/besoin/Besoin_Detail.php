    <style>
        .info {
            font-size: 16px;
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-top: 10px;
        }
        
        .data {
            width: 30%;
        }
        
        .point {
            width: 30%;
            margin-left: -70px;
        }
        
        .modifier {
            background-color: rgb(47 202 38);
            border: none;
            color: #FFF;
            transition: .3s;
            border-radius: 30px;
            width: 85%;
            height: 40px;
            margin-top: 40px;
            margin-left: 70px;
        }
        
        .modifier:hover{
            background-color: #FFF;
            color: rgb(47 202 38);
            border: 1px solid rgb(47 202 38);
        }
    </style>
    
    <div class="col-md-9">
        <div>
            <h2>Détails de demande de besoin de <?php echo $detail_besoin[0]['nom_materiel']; ?></h2>
            <?php foreach ($detail_besoin AS $besoin) { ?>
                <div class="info" style="margin-top: 40px;">
                    <div class="data">N° de besoin </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $besoin['id_besoin'] ?></div>
                </div>
                <div class="info">
                    <div class="data">Date de la demande  </div>
                    <div class="point">................................................</div>
                    <div class="data">
                        <?php $date = new DateTime($besoin['datedemande']);
                            echo $date->format('d F Y');
                        ?>
                </div>
                </div>
                <div class="info">
                    <div class="data">Département  </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $besoin['nom_departement'] ?></div>
                </div>
                <div class="info">
                    <div class="data">Code Matériel  </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $besoin['id_materiels'] ?></div>
                </div>
                <div class="info">
                    <div class="data">Quantité  </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $besoin['total_quantite'] ?></div>
                </div>
                <div class="info">
                    <div class="data">Unité  </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $besoin['unite_materiel'] ?></div>
                </div>
            <?php } ?>
            <div class="info">
                <a href="<?php echo base_url('besoin/C_Besoin/validationPage_besoin/'.$detail_besoin[0]['id_materiels']); ?>">
                    <button class="modifier">VALIDER DEMANDE</button>
                </a>
            </div>
        </div>
    </div>
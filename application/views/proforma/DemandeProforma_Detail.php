<?php $entreprise_info = $this->session->userdata('entreprise_info'); ?>
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
            <h2>Détails de demande de proforma pour <?php echo $detail_demandeProforma[0]['objetdemande']; ?></h2>
            <h3>Acheteur</h3>
                <div class="info" style="margin-top: 40px;">
                    <div class="data">Entreprise </div>
                    <div class="data"><?php echo $entreprise_info['nom_entreprise']; ?></div>
                </div>
                <div class="info" style="margin-top: 40px;">
                    <div class="data">Numéro </div>
                    <div class="data"><?php echo $entreprise_info['num_entreprise']; ?></div>
                </div>
                <div class="info" style="margin-top: 40px;">
                    <div class="data">Email </div>
                    <div class="data"><?php echo $entreprise_info['email_entreprise']; ?></div>
                </div>
                <div class="info" style="margin-top: 40px;">
                    <div class="data">Adresse de livraison </div>
                    <div class="data"><?php echo $entreprise_info['adresse_entreprise']; ?></div>
                </div>
                <div class="info" style="margin-top: 40px;">
                    <div class="data">N° de demande de proforma </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $detail_demandeProforma[0]['id_demandeproforma'] ?></div>
                </div>
                <div class="info">
                    <div class="data">Date de la demande de proforma  </div>
                    <div class="point">................................................</div>
                    <div class="data">
                        <?php $date = new DateTime($detail_demandeProforma[0]['datedemande_proforma']);
                            echo $date->format('d F Y');
                        ?>
                    </div>
                </div>
                <div class="info">
                    <div class="data">Quantité  </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $detail_demandeProforma[0]['quantite'] ?></div>
                </div>
            <div class="info">
                <a href="<?php echo base_url('proforma/C_ProformaFournisseur/detail_demandeproforma/'.$detail_demandeProforma[0]['id_demandeproforma']); ?>">
                    <button class="modifier">FAIRE UN PROFORMA</button>
                </a>
            </div>
        </div>
    </div>
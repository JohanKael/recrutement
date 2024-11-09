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
            <h2>Détails de demande de proforma pour <?php echo $detail_demandeProforma[0]['objetdemandeproforma']; ?></h2>
            <h3>Acheteur</h3>
                <div class="info">
                    <div class="data">Entreprise </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $entreprise_info['nom_entreprise']; ?></div>
                </div>
                <div class="info">
                    <div class="data">Numéro </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $entreprise_info['num_entreprise']; ?></div>
                </div>
                <div class="info">
                    <div class="data">Email </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $entreprise_info['email_entreprise']; ?></div>
                </div>
                <div class="info">
                    <div class="data">Adresse de livraison </div>
                    <div class="point">................................................</div>
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
                <?php foreach ($detail_demandeProforma as $one_detail) { ?>
                    <div class="info">
                        <div class="data">-----------------------------------------------</div>
                        <div class="point">-----------------------------------------------</div>
                        <div class="data">-----------------------------------------------</div>
                    </div>
                    <div class="info">
                        <div class="data">Matériel  </div>
                        <div class="point">................................................</div>
                        <div class="data"><?php echo $one_detail['nom_materiel'] ?></div>
                    </div>
                    <div class="info">
                        <div class="data">Quantité  </div>
                        <div class="point">................................................</div>
                        <div class="data"><?php echo $one_detail['quantite'] ?></div>
                    </div>
                    <div class="info">
                        <div class="data">Unité  </div>
                        <div class="point">................................................</div>
                        <div class="data"><?php echo $one_detail['unite_materiel'] ?></div>
                    </div>
                <?php } ?>
            <div class="info">
                <form action="<?php echo base_url('proforma/C_ProformaFournisseur/page_ProformaFournisseur/3') ?>" method="POST">   
                    <input type="hidden" name="id_demandeProforma" class="selectMats" value="<?php echo $detail_demandeProforma[0]['id_demandeproforma'] ?>">
                    <div class="submitButton">
                        <input type="submit" value="FAIRE UN PROFROMA">
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-md-9 moreBesoin" id="champOneMoreBesoin"></div>
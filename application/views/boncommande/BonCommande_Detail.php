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
            <h2>Détails de bon de commande</h2>
            <form action="<?php echo base_url('boncommande/C_BonCommande/ajout_bonCommande') ?>" method="POST">
                    <div class="info" style="margin-top: 40px;">
                        <div class="data">Client </div>
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
                    <div class="info" style="margin-bottom: 80px;">
                        <div class="data">Adresse de livraison </div>
                        <div class="point">................................................</div>   
                        <div class="data"><?php echo $entreprise_info['adresse_entreprise']; ?></div>
                    </div>
                    
                <div class="quantite">
                    <h4 class="titleMatiere">Date bon commande :</h4> 
                    <input type="date" name="dateBonCommande" class="selectMats">
                    <div class="titleMatiere"></div>
                </div>

                <?php foreach ($liste_detailproforma as $detailprofroma) { ?>
                    <input type="hidden" name="proforma[]" value="<?php echo $detailprofroma[0]['id_proforma']; ?>">
                    <input type="hidden" name="materiel[]" value="<?php echo $detailprofroma[0]['id_materiels']; ?>">
                    <div class="info">
                        <div class="data">Fournisseur  </div>
                        <div class="point">................................................</div>
                        <div class="data"><?php echo $detailprofroma[0]['nom'] ?></div>
                    </div>
                    <div class="info">
                        <div class="data">Nom  </div>
                        <div class="point">................................................</div>
                        <div class="data"><?php echo $detailprofroma[0]['nom_entreprise'] ?></div>
                    </div>
                    <div class="info" style="margin-bottom: 10px;">
                        <div class="data">Adresse  </div>
                        <div class="point">................................................</div>
                        <div class="data"><?php echo $detailprofroma[0]['adresse'] ?></div>
                    </div>
                    <div class="info" style="margin-bottom: 10px;">
                        <div class="data">Date d'émission  </div>
                        <div class="point">................................................</div>
                        <div class="data"><?php $date = new DateTime($detailprofroma[0]['date_emission']);
                            echo $date->format('d F Y');
                        ?></div>
                    </div>
                    <table class="table" style="margin-bottom: 80px;">
                        <thead class="thead-dark">
                            <tr>
                                <th>Matériels</th>
                                <th>Prix Unitaire</th>
                                <th>Quantité</th>
                                <th>Total</th>
                                <th>Devise</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="ligne">
                                <td><?php echo $detailprofroma[0]['nom_materiel']; ?></td>
                                <td><?php echo $detailprofroma[0]['pu']; ?></td>
                                <td><?php echo $detailprofroma[0]['total_quantite']; ?></td>
                                <td><?php echo ($detailprofroma[0]['pu'] * $detailprofroma[0]['total_quantite']); ?></td>
                                <td>Ar</td>
                            </tr>
                        </tbody>
                    </table> 
                <?php } ?>
            
                <div class="submitButton">
                    <input type="submit" value="CONFIRMER">
                </div>
            </form>
        </div>
    </div>

    
    <div class="col-md-9 moreBesoin" id="champOneMoreBesoin"></div>
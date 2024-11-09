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
            
            <h2>Détails de demande de proforma</h2>
            <div class="col-md-10 paginationselect">
                <span><h4>Fournisseur : </h4></span>
                <span>
                    <form id="pageToGo" action="<?php echo base_url('proforma/C_Proforma/next_fournisseur/'); ?>" method="GET">  
                        <input type="hidden" value="<?php echo $demandeProforma; ?>" name="demandeproforma">       
                        <select class="selectpage" name="fournisseur" onchange="submitForm()">
                            <?php foreach($liste_fournisseur as $fournisseur) { 
                                if ($fournisseur['id_fournisseur'] == $fournisseur_selected) { ?>  
                                <option value="<?php echo $fournisseur['id_fournisseur']; ?>" selected="<?php echo $fournisseur['nom']; ?>"><?php echo $fournisseur['nom_entreprise']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $fournisseur['id_fournisseur']; ?>"><?php echo $fournisseur['nom_entreprise']; ?></option>
                            <?php } } ?>
                        </select>
                    </form>
                </span>
            </div>
    <div class="col-md-9">
        <div>
                    <div class="info" style="margin-top: 40px;">
                        <div class="data">Entreprise </div>
                        <div class="point">................................................</div>
                        <div class="data"><?php echo $liste_detailProforma[0]['nom_entreprise']; ?></div>
                    </div>
                    <div class="info">
                        <div class="data">Adresse </div>
                        <div class="point">................................................</div>
                        <div class="data"><?php echo $liste_detailProforma[0]['adresse']; ?></div>
                    </div>
                    <div class="info">
                        <div class="data">Télephone </div>
                        <div class="point">................................................</div>
                        <div class="data"><?php echo $liste_detailProforma[0]['telephone']; ?></div>
                    </div>
                    <div class="info">
                        <div class="data">Email </div>
                        <div class="point">................................................</div>
                        <div class="data"><?php echo $liste_detailProforma[0]['email']; ?></div>
                    </div>

                    <div class="info" style="margin-top: 40px;">
                        <div class="data">N° de proforma </div>
                        <div class="point">................................................</div>
                        <div class="data"><?php echo $liste_detailProforma[0]['id_proforma'] ?></div>
                    </div>
                    <div class="info">
                        <div class="data">Date proforma  </div>
                        <div class="point">................................................</div>
                        <div class="data">
                            <?php $date = new DateTime($liste_detailProforma[0]['date_emission']);
                                echo $date->format('d F Y');
                            ?>
                        </div>
                    </div>
                    
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
                    <div class="info">
                        <div class="data">Adresse de livraison </div>
                        <div class="point">................................................</div>   
                        <div class="data"><?php echo $entreprise_info['adresse_entreprise']; ?></div>
                    </div>
                    <table class="table" style="margin-top: 40px;">
                        <thead class="thead-dark">
                            <tr>
                                <th>Matériel</th>
                                <th>Quantité</th>
                                <th>Prix Unitaire</th>
                                <th>Total</th>
                                <th>Devise</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($liste_detailProforma as $detail_demandeProforma) { ?>
                                <tr class="ligne" data-href="<?php echo base_url('proforma/C_Proforma/detail_proforma/'.$detail_demandeProforma['id_demandeproforma']."/".$detail_demandeProforma['id_fournisseur']); ?>">
                                    <td><?php echo $detail_demandeProforma['nom_materiel']; ?></td>
                                    <td><?php echo $detail_demandeProforma['total_quantite']; ?></td>
                                    <td><?php echo $detail_demandeProforma['pu']; ?></td>
                                    <td><?php echo ($detail_demandeProforma['pu'] * $detail_demandeProforma['total_quantite']); ?></td>
                                    <td>Ar</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table> 
                    
                    <div class="info">
                        <div class="data">Total HT </div>
                        <div class="point">................................................</div>   
                        <div class="data"><?php echo $liste_detailProforma[0]['total'] ?> AR</div>
                    </div>
                    <div class="info">
                        <div class="data">TVA (20%) </div>
                        <div class="point">................................................</div>   
                        <div class="data"><?php echo $tva; ?> AR</div>
                    </div>
                    <div class="info">
                        <div class="data">Total </div>
                        <div class="point">................................................</div>   
                        <div class="data"><?php echo $total; ?> AR</div>
                    </div>
        </div>
        <?php if ($isBonCommande === false) { ?>
            <div class="info">
                <form action="<?php echo base_url('boncommande/C_BonCommande/bon_commande/'); ?>" method="POST">  
                    <input type="hidden" value="<?php echo $demandeProforma; ?>" name="numerodemandeproforma">
                    <button class="modifier">FAIRE UN BON DE COMMANDE</button>
                </form>
            </div>
        <?php } ?>
    </div>  

    <script>
        function submitForm() {
            document.getElementById('pageToGo').submit();
        }
    </script> 
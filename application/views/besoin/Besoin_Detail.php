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
            <h2>Détails de demande de besoin de <?php echo $detail_talent[0]['intitule']; ?></h2>
            <?php foreach ($detail_talent AS $talent) { ?>
                <div class="info" style="margin-top: 40px;">
                    <div class="data">N° de besoin </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $talent['id_demandetalent'] ?></div>
                </div>
                <div class="info">
                    <div class="data">Date de la demande  </div>
                    <div class="point">................................................</div>
                    <div class="data">
                        <?php $date = new DateTime($talent['datedemandetalent']);
                            echo $date->format('d F Y');
                        ?>
                </div>
                </div>
                <div class="info">
                    <div class="data">Département  </div>
                    <div class="point">................................................</div>
                    <div class="data"></div>
                </div>
                <div class="info">
                    <div class="data">Poste  </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $talent['intitule'] ?></div>
                </div>
                <div class="info">
                    <div class="data">Description  </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $talent['description_talent'] ?></div>
                </div>
                <div class="info">
                    <div class="data">Objectif  </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $talent['objectif'] ?></div>
                </div>
                <div class="info">
                    <div class="data">Qualification  </div>
                    <div class="point">................................................</div>
                    <div class="data"><?php echo $talent['qualification'] ?></div>
                </div>
            <?php } ?>
            
            <form action="<?php echo base_url('besoin/C_Besoin/validation_besoin') ?>" method="POST">
                    <input type="hidden" name="datedemande" class="selectMats" value="<?php echo $talent['datedemandetalent'] ?>">
                    <input type="hidden" name="demandetalent" class="selectMats" value="<?php echo $detail_talent[0]['id_demandetalent'] ?>">
                <div class="quantite">
                    <h4 class="titleMatiere">Date de validation :</h4> 
                    <input type="date" name="datevalidation" class="selectMats">
                    <div class="titleMatiere"></div>
                </div>
                <div class="submitButton">
                    <input type="submit" value="VALIDER DEMANDE DE TALENT">
                </div>
            </form>
        </div>
    </div>
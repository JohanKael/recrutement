<style>
        .moreBesoin {
            margin-top : 2.5%;
        }
    </style>
    <h2>Ajout d'une CV</h2>
    <form action="<?php echo base_url('index.php/cv/C_CurriculumVitae/upload') ?>" method="POST" enctype="multipart/form-data">   
        <div class="col-md-10 achatMatiere">
            
            <div class="quantite">
                <h4 class="titleMatiere">Titre :</h4> 
                <input type="text" name="title" class="selectMats">
                <div class="titleMatiere"></div>
            </div>

            <div class="quantite">
                <h4 class="titleMatiere">Cv :</h4> 
                <input type="file" name="pdf_file" accept=".pdf" required class="selectMats">
                <div class="titleMatiere"></div>
            </div>
            
            <div class="submitButton">
                <input type="submit" value="AJOUTER">
            </div>
        </div>

    </form>
<?php $this->load->view('component/validation/Validation'); ?>

<?php $base_url =  base_url();  ?>
<link rel="stylesheet" href="https://use.typekit.net/edv7ufj.css">
<style type="text/css">
    .header-font-style *{
        font-family: "din-2014",sans-serif !important;
        font-weight: 700 !important;
        font-style: normal !important;
    }

    .content02 *{
        font-family: "din-2014",sans-serif !important;
        font-weight: 700 !important;
        font-style: normal !important;
    }

    .content01 *{
        font-family: "din-2014",sans-serif !important;
        font-weight: 700 !important;
        font-style: normal !important;
    }
</style>
<header class="container-fluid p-0 " >
        <div class="container header-font-style" >
            <div class="row align-items-center">
                <div class="col-12 col-md-4 col-lg-5 logo1">
                   <a href="<?= $base_url ?>"> <img src="<?= $base_url ?>assets/img/Integra_LandHub_Logo.png" alt=""></a>
                </div>
                <div class="col-12 col-md-8 col-lg-7">
                    <div class="row align-items-center justify-content-end HeaderRight">
                        <div class="Date01">
                            <i><img src="<?= $base_url ?>assets/img/icon01.svg" alt=""></i>
                            <p>
                                <small><?php echo date('l') ?></small>
                                <span><?php echo date('F'); ?></span>
                            </p>
                            <strong>
                                <?php echo date('d') ?>
                            </strong>
                        </div>
                        <div class="Search01">
                            
                        </div>
                        <div class="User01">
                            <span class="header-font-style"><?php echo $name; ?></span>
                            <i class="DropDown01"></i>
                            <ul class="DropDown02">
                                <li><a href="<?php echo base_url().'editOld/'.$this->session->userdata('userId'); ?>" class="header-font-style">Settings</a></li>
                                <li><a href="<?= $base_url ?>logout" class="header-font-style">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        
        $params = ['name'=>$name];

        $this->load->view('includes/menu', $params); ?>

    </header>


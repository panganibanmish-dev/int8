<style>
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #fff;
    background-color: #0c1d2b;
    border-color: #dee2e6 #dee2e6 #fff;
}

.cardManage{
    

    position: relative;
   z-index: 2;
   
   display: -ms-flexbox;
   display: flex;
  /* width: 298px;*/
   height: 300px;
   margin-bottom: auto;
   -webkit-box-orient: vertical;
   -webkit-box-direction: normal;
   -webkit-flex-direction: column;
   -ms-flex-direction: column;
   flex-direction: column;
   -webkit-box-pack: center;
   -webkit-justify-content: center;
   -ms-flex-pack: center;
   justify-content: center;
   -webkit-box-align: start;
   -webkit-align-items: flex-start;
   -ms-flex-align: start;
   align-items: flex-start;
   border-radius: 0px;
   
   background-position: 50% 50%;
   background-size: cover;
   opacity: 1;
   -webkit-transition-property: none;
   transition-property: none;
   text-decoration: none;
   background-clip: border-box;
}
.dateManage{
    position: relative;
   display: -webkit-box;
   display: -webkit-flex;
   display: -ms-flexbox;
   display: flex;
   width: 100%;
   height: 100%;
   margin-top: 0px;
   margin-bottom: auto;
   padding-left: 30px;
   -webkit-box-align: end;
   -webkit-align-items: flex-end;
   -ms-flex-align: end;
   align-items: flex-end;
   /*background-color: rgba(27, 28, 32, 0.54);*/
   opacity: 1;
   font-family: din-2014, sans-serif;
   color: #fff;
   font-weight: 400;
   font-size: 12px;
   /* line-height: 20px; */
   font-weight: 700;
   letter-spacing: 1px;
   text-transform: uppercase;
}
.descriptionManage{
    display: -webkit-box;
   display: -webkit-flex;
   display: -ms-flexbox;
   display: flex;
   width: 100%;
   height: 100%;
   margin-top: auto;
   padding: 28px 50px 10px 30px;
   -webkit-box-align: start;
   -webkit-align-items: flex-start;
   -ms-flex-align: start;
   align-items: flex-start;
  /* background-color: rgba(27, 28, 32, 0.54);*/
   font-family: din-2014, sans-serif;
   color: #fff;
   font-size: 18px;
   line-height: 35px;
   font-weight: 700;
   text-align: left;
   text-decoration: none;
}
</style>
<section class="container content02">

    <div class="row">
        <div class="Head01 col-11 m-auto">            
            <h1>News</h1>
        </div>
    </div>

    <div class='row'>
        <div class = 'col-md-12'>
            <?php
                $this->load->helper('form');
                $error = $this->session->flashdata('error');
                if($error)
                {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('error'); ?>                    
            </div>
            <?php } ?>
            <?php  
                $success = $this->session->flashdata('success');
                if($success)
                {
            ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php } ?>
        </div>
    </div>

    
    <div class="row">
        <div class="col-sm-12">
            <div class="box">

                

                <!-- Tabs -->
<section id="tabs">
	<div class="container">
		
		<div class="row">
			<div class="col-xs-12 col-md-12">
				
				<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
				
				<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
						
			        <div class="row">

			           <?php 
			           	if(isset($all_news[0])){
			           			foreach ($all_news as $news){
			           		?>
			            <div class="col-12 col-md-3 " style="padding: 17px;background-image:url(<?php if(isset($news['imageLink'])){echo $news['imageLink'];}else{ echo "https://int1.dev.humanpixel.com.au/assets/images/default_image.png"; } ?>);background-size: 301px 298px;background-repeat: no-repeat;background-position: center;">
			               

							    <a href="<?php echo $news['link']; ?>" class="cardManage">
							    	<div class="dateManage"><?php echo $news['description']; ?></div>
							    	<div class="descriptionManage"><?php echo $news['title']; ?></div></a>
							  
			            </div>
			            <?php
			       			 }
			        	    }
			           ?>
			        </div>
 
					</div>
					
					
					
				</div>
			
			</div>
		</div>
	</div>
</section>
                <div class="clearfix"></div>
                <!-- <div class="box-footer clearfix">
                    <?php //echo $this->pagination->create_links(); ?>
                </div> -->
            </div><!-- /.box -->
        </div>
    </div>

   
    </script>

</section>

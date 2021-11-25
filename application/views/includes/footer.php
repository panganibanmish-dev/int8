 </div>  

    <footer class="main-footer">
        
        <p>Copyright &copy; 2020-<?php echo (int)date('Y') + 1; ?> <a href="<?php echo base_url(); ?>"></a>. All rights reserved.</p>
    </footer>
 
    <!-- jQuery UI 1.11.2 -->
    <!-- <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script> -->
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 3.3.2 JS -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/canvas/canvasjs.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/js/app.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/validation.js"></script>
    <script type="text/javascript">
        var windowURL = window.location.href;
        pageURL = windowURL.substring(0, windowURL.lastIndexOf('/'));
        var x= $('a[href="'+pageURL+'"]');
            x.addClass('active');
            x.parent().addClass('active');
        var y= $('a[href="'+windowURL+'"]');
            y.addClass('active');
            y.parent().addClass('active');
    </script>
    
    <script>
    $(document).ready(function(){
		$('.datatable').DataTable({
            responsive: true
        });
    });
    </script>
  </body>
</html>
      
      <div class="kt-footer">
        <!-- <span>Copyright &copy;. All Rights Reserved. Katniss Responsive Bootstrap 4 Admin Dashboard.</span>
        <span>Created by: ThemePixels, Inc.</span> -->
      </div><!-- kt-footer -->
    </div><!-- kt-mainpanel -->

    <script src="<?=base_url()?>theme/lib/jquery/jquery.js"></script>
    <script src="<?=base_url()?>theme/lib/popper.js/popper.js"></script>
    <script src="<?=base_url()?>theme/lib/bootstrap/bootstrap.js"></script>
    <script src="<?=base_url()?>theme/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="<?=base_url()?>theme/lib/moment/moment.js"></script>
    <script src="<?=base_url()?>theme/lib/highlightjs/highlight.pack.js"></script>
    <script src="<?=base_url()?>theme/lib/datatables/jquery.dataTables.js"></script>
    <script src="<?=base_url()?>theme/lib/datatables-responsive/dataTables.responsive.js"></script>
    <script src="<?=base_url()?>theme/lib/select2/js/select2.min.js"></script>
    <script src="<?=base_url()?>theme/lib/d3/d3.js"></script>
    
    <!-- <script src="http://maps.google.com/maps/api/js?key=AIzaSyAEt_DBLTknLexNbTVwbXyq2HSf2UbRBU8"></script> -->
    <script src="<?=base_url()?>theme/lib/gmaps/gmaps.js"></script>
    <script src="<?=base_url()?>theme/lib/chart.js/Chart.js"></script>
    <script src="<?=base_url()?>theme/js/sweetalert2.all.min.js"></script>

    <script src="<?=base_url()?>theme/js/katniss.js"></script>
    <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
          responsive: true, 
          "paging":   false,
          "info":     false,
          searching: false,
           retrieve: true
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>
    <script src="<?=base_url()?>theme/js/ResizeSensor.js"></script>
   

  </body>
</html>
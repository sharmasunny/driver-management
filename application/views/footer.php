<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	</main><!-- #site-content -->

	<footer id="site-footer" role="contentinfo">
	</footer><!-- #site-footer -->

	<!-- js -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!--script src="<?= base_url('assets/js/jquery-2.1.4.js') ?>"></script-->
	<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/script.js') ?>"></script>
	<script src="<?= base_url('assets/js/jquery.mobile.custom.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/main.js') ?>"></script> <!-- Resource jQuery -->
<script>
$(document).ready(function(){
   $("#update_div").click(function(e){
     var o_id =$("#o_id").val();
     var driver_id = $("#driver_id").val();
     // var driver_name = $("#driver_id option:selected").text();
      $.ajax({
        url: '<?= base_url("order/assign_driver") ?>',
        data: {'order_id':o_id ,'driver_list':driver_id},
        type: "post",
        success: function(data){
          var data = JSON.parse(data);
          if(data.status){
            // $("#driver-assigned").hide();
            // $("#driver-name").html(driver_name);
            $("#confirmation-value").html(data.timeline);
           	alert('Driver assigned successfully');
          }
        }
      });
   });

   //by sachin

    $("#update_zone").click(function(e){
     var o_id =$("#o_id").val();
     var order_driver_zone = $("#driver_zone").val();
     // console.log(order_driver_zone);
     // var driver_name = $("#driver_id option:selected").text();
      $.ajax({
        url: '<?= base_url("order/assign_zone") ?>',
        data: {'order_id':o_id ,'order_driver_zone':order_driver_zone},
        type: "post",
        success: function(data){
          console.log(data);
          var data = JSON.parse(data);
          if(data.status){
            //$("#driver-assigned").hide();
            // $("#driver-name").html(driver_name);
            $("#confirmation-value").html(data.timeline);
            alert('Zone assigned successfully');
          }
        }
      });
   });


//end section

// my js
$("#testing").click(function(){
  if ($("#radio-id1").is(":checked")) {
           
          //show the hidden div
           $("#driver-assigned").show("slide");
          
      } else {
          
         
          $("#driver-assigned").hide("slide");
      } 
    if ($("#radio-id2").is(":checked")) {
           
          //show the hidden div
           $("#div-id").show("slide");
          
      } else {
          
         
          $("#div-id").hide("slide");
      }
});



});
</script>
</body>
</html>
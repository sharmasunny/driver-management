<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

 	
?>
<style>
	body{height:auto !important;}

</style>
	<h2>Orders Listing</h2>
	<div class="row">
  <!--  <div class="col-md-10">
 <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#add-driver">Add New Driver</button> 
  </div> 
  <div class="col-md-2"><button type="button" onclick="logout()"  id="logout_btn" class="btn btn-danger btn-lg" >Logout</button></div>-->
</div>
	
	<br/>
	<br/> <?php 
	// echo form_open(base_url()."/controllername/mehod");

		
			?>
	<table class="table table-bordered" id="orderlist" style="width:100%">
		<thead>
			<tr>
			<!-- <th  width="10px">Sr. No. </th> -->
				<!-- <th width="10px" style="background:none"><input type="checkbox" id="alluser" /></th> -->
				<th width="14px">Sno</th>
				<th width="50px">Order ID</th> 
				<th width="150px">Customer Email</th>         
				<th width="150px">Order Address</th>  
				<th width="150px">Order Status</th>                           
				<th width="150px">Driver Assigned</th>                             
			</tr>
		</thead>
		<tbody>				     
			<?php
			$no = 1;
			if ( count($orders) > 0 ) { ?>
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery('#orderlist').dataTable({ 
							"aaSorting": [[ 0, "desc" ]],
						});
						 
						jQuery('#alluser').click(function(event) {  //on click
						if(this.checked) { // check select status
						    jQuery('.userid').each(function() { //loop through each checkbox
						        this.checked = true;  //select all checkboxes with class "checkbox1"              
						    });
						}else{
						    jQuery('.userid').each(function() { //loop through each checkbox
						        this.checked = false; //deselect all checkboxes with class "checkbox1"                      
						    });        
						}
						});
					});	
				</script>
				<?php
				$i=0;
				 foreach($orders as $order){
				 	$i++;
//print_r($order);

					
				

					?>
					<tr>
					 <!-- <td>
					
					</td> -->
						<td><?php echo $i; ?></td>
						<td>#<?php echo $order->order_id ?></td>
						<td nowrap><?php echo $order->customer_email; ?></td>
						<td nowrap><?php echo $order->order_shipping_address; ?></td>
						<td nowrap><?php  
$stat = $order->order_status;
// echo $stat;

						switch($stat)
						{
						case '0':
						$order_stat = ' ';
						break;
						case '1':
						$order_stat = 'Accepted';
						break;case '2':
						$order_stat = 'Picked up';
						break;case '3':
						$order_stat = 'On the way';
						break;case '4':
						$order_stat = 'Delivery';
						break;case '5':
						$order_stat = 'Full Fill';
						break;
						default:
						$order_stat = ' ';
						}

						echo $order_stat;

?>
							


						</td>
						

						<td nowrap>
						<?php
						$default_assigned = $options[$order->order_driver_id]; 
						$hidden = array('order_id' => $order->id); 
						echo form_open("order/assign_driver", '', $hidden); 
						echo form_dropdown('driver_list', $options ,  $order->order_driver_id); 	 
						
						?>
						<button type = "submit" title="assign driver">
						<img src= "<?php echo base_url().'assets/images/update.ico'; ?>"  alt="Smiley face" height="24" width="24"/>	
						</button>
<? echo form_close(); ?>
							
						</td>
					               
						          
					</tr>
				<?php $no += 1;							
				}
			} else {
				echo '<h3>No Orders Details Found !!</h3>';
			} ?>					
		</tbody>
	</table>
	<!-- <p>
		<input type="submit" name="delete" class="add-new-h2 button-secondary" onclick="javascript:return confirm('Are you sure, want to delete all checked record?')" value="Delete">
	</p> -->
	
</div>
</div>
</div>
<!-- <div class="container">
	<div class="row">
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="col-md-12">
			<div class="page-header">
				<h1>Login</h1>
			</div>
			<?= form_open() ?>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Your username">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Your password">
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-default" value="Login">
				</div>
			</form>
		</div>
	</div><!-- .row 
</div><!-- .container -->
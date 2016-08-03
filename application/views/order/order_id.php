 <?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 // print_r(json_decode($this->data['order_details']['all_record'])); 
 $order_details = $this->data['order_details']; 
 $order_status = $this->data['order_status'][0]->order_status;
 $o_id = $this->data['order_status'][0]->id;
 $o_driver_id  = $this->data['order_status'][0]->order_driver_id;
 $o_zone_id  = $this->data['order_status'][0]->order_zone_id;
// print_r($this->data['order_status']);die;
 // $order_details = json_decode($this->data['order_details']['0']->all_record); 
 // print_r($this->data['order_details']->all_record); 
  $order_number = $this->data['order_number']; 
  
 // echo $order_number;
 // echo $order_number;die;
 /* echo "<pre>";
  print_r($order_details );
  echo "</pre>";*/
  // echo $order_details->number;die;
?>

<style>
@media (min-width:320px) and (max-width:480px)
{
.next-card__header {padding: 5px 10px;}
.ui-layout__section--primary {flex: 1 1 auto;}
.ui-layout__item {padding-left: 0;}
.ui-layout {margin: 20px auto;max-width: inherit;width: 100% !important;}
.ui-layout .next-card {border-radius: 0;margin: 0;}
.ui-layout__sections {margin: -30px 0 0 ;padding: 0;}
.ui-stack-item.ui-stack-item--fill {margin: 0;}
h1 {font-size: 20px;margin: 10px 0 0;}

}
</style>

<div class="ui-layout">
  <div class="ui-layout__sections">
    <div class="ui-layout__section hide-when-printing" id="order-notices" refresh="order-notices">
    </div>
    <div class="ui-layout__section ui-layout__section--primary">
      <div class="ui-layout__item">
        <div id="order_card" class="next-card">
          <header class="next-card__header">
            <div class="ui-stack">
              <div class="ui-stack-item ui-stack-item--fill">
                <h1>#<?php echo $this->data['order_status'][0]->order_id; ?></h1>
                <h2 class="next-heading">Order details 
                </h2>
              </div>              
              <div class="hide-when-printing">
                <h6 class="next-heading next-heading--no-margin next-heading--tiny ">
                  <div class="ui-stack ui-stack--distribution-leading ui-stack--spacing-tight">
                    <div class="ui-stack-item">
                      <a href="https://24sevens.myshopify.com/admin/draft_orders/<?php echo $order_number; ?>">Draft order #D<?php echo $order_details->number; ?>
                      </a>
                    </div>
                  </div>  
                </h6>
              </div>
            </div>          
          </header>
          <div id="order-line-items" refresh="order-line-items">
            <div class="next-card__section hide-when-printing">
              <h3 class="next-heading next-heading--small next-heading--no-margin">
                <svg class="next-icon next-icon--color-slate-lighter next-icon--size-16 next-icon--right-spacing-quartered">
                  <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#next-order-unfulfilled-16">
                  </use>
                </svg>
              </h3>
            </div>
            <div class="next-card__section next-card__section--no-vertical-spacing">
              <table class="table--no-side-padding table--divided">
                <tbody>
                <?php foreach($order_details->line_items as $product_detail) 
                { 
                  ?>
                 <tr class="orders-line-item">
                    <td class="orders-line-item__image hide-when-printing">
                      <div class="aspect-ratio aspect-ratio--square aspect-ratio--square--50">
                        <img title="<?php echo $product_detail->title; ?>" class="block aspect-ratio__content" src="<?php echo $product_detail->img; ?>" alt="Cold cut platter thumb">
                      </div>
                    </td>
                    <td class="orders-line-item__description">
                      <a href="https://24sevens.myshopify.com/admin/products/6640123590/variants/20984528390"> <?php echo $product_detail->title; ?>
                      </a>
                    </td>
                    <td class="orders-line-item__price">
                       <?php echo '$'.$product_detail->price; ?>
                    </td>
                    <td class="orders-line-item__times-sign">
                      ×
                    </td>
                    <td class="orders-line-item__quantity">
                      <?php echo $product_detail->quantity; ?>
                    </td>
                    <td class="orders-line-item__total">
                      <?php echo '$'.($product_detail->price*$product_detail->quantity); ?>
                    </td>
                  </tr>
                  <tr>
                     <td class="pick_address" colspan="2">
                      <h4>Pickup Address</h4>  
                            Name :  <?php echo $product_detail->origin_location->name; ?> </br>    
                            Address1 :  <?php echo $product_detail->origin_location->address1; ?> </br>
                            Address2 :  <?php echo $product_detail->origin_location->address2; ?> <br/>
                            City :  <?php echo $product_detail->origin_location->city; ?> </br>    
                            State :  <?php echo $product_detail->origin_location->province_code; ?> </br>    
                            Country  :  <?php echo $product_detail->origin_location->country_code; ?> </br>    
                            zip code : <?php echo $product_detail->origin_location->zip; ?> </br> 
                    </td>

                    <td class="drop_address">
                      <h4>Drop Off Address</h4>
                            Name :  <?php echo $product_detail->destination_location->name; ?> </br>    
                            Address1 :  <?php echo $product_detail->destination_location->address1; ?> </br>
                            Address2 :  <?php echo $product_detail->destination_location->address2; ?> <br/>
                            City :  <?php echo $product_detail->destination_location->city; ?> </br>    
                            State :  <?php echo $product_detail->destination_location->province_code; ?> </br>    
                            Country  :  <?php echo $product_detail->destination_location->country_code; ?> </br>    
                            zip code : <?php echo $product_detail->destination_location->zip; ?> </br> 
                    </td>
                  </tr>

                 <?php }
                  
                  ?>


                 
                </tbody>
              </table>
            </div>
          </div>
          <div class="next-card__section">
            <div class="wrappable">
              <div id="order-notes" refresh="notes" class="wrappable__item">
                <form refresh-on-success="notes" tg-remote="post" define="{orderNoteForm: new Shopify.Form(this, {disabledUntilDirty: true})}" class="js-note-form" id="edit_order_<?php echo $order_number; ?>" action="https://24sevens.myshopify.com/admin/orders/<?php echo $order_number; ?>" accept-charset="UTF-8" method="post">
                  <input name="utf8" type="hidden" value="✓">
                  <input type="hidden" name="_method" value="patch">
                  <input type="hidden" name="authenticity_token" value="DqRNxez2QN6tR4KVzLK2Um48AcA9l5sxrNX2tgt2tqG9YkY2G9Epcqgr9Z9lFvYkl8oKrtLajsfewl1k/MK+6w==">
                  
                </form>              
              </div>
              <div id="transaction_summary" refresh="order-actions" class="wrappable__item">
                <table class="table--nested table--no-border type--right">
                  <tbody>
                    <tr>
                      <td class="type--subdued">Subtotal
                      </td>
                      <td> <?php echo '$'.$order_details->subtotal_price; ?>
                      </td>
                    </tr>
                    <?php foreach($order_details->tax_lines as $tax_details) { ?>
                    <tr>
                      <td class="type--subdued">
                        <p><?php echo $tax_details->title." ". $tax_details->rate."%"; ?>
                        </p>
                      </td>
                      <td> <?php echo '$'.$tax_details->price; ?>
                      </td>
                    </tr>

                    <?php } ?>
                    <tr>
                      <td>
                        <strong>Total
                        </strong>
                      </td>
                      <td>
                        <strong><?php echo '$'.$order_details->total_price; ?>
                        </strong>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <hr class="next-card__section__separator--half">
                <table class="table--nested table--no-border type--right">
                  <tbody>
                    <tr>
                      <td class="type--subdued">Paid by customer
                      </td>
                      <td><?php echo '$'.$order_details->total_price; ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div id="order-payment-callout" class="next-card__section next-card__section--subdued hide-when-printing" refresh="order-actions">
            <div>  
              <div class="driver-assign">
                <h2>Driver Assigned </h2>

                <!-- Option buttons -->
                  <?php if($this->data['order_status'][0]->confirmation!=2){ ?>
                <div id="testing" >
                   <input type ="radio" id="radio-id2" name="link">Zone Pool</input>
                   <input type ="radio" id="radio-id1" name="link" >Select Driver</input>
                </div>
               
                  
              
                  <?php
                    $attributes = array('autocomplete' => 'off');
                    echo form_open('',$attributes); 
                  ?>
                    
                  <?php

              /*    foreach ($zones as $key=>$val)
                  {
                  $row_zones[$value['zone_id']] = $value['zone_name'];         
                  }
                  print_r($row_zones);die;*/
                 // echo form_dropdown('driver_zone', $row_zones ,$o_zone_id,' id="driver_zone"');
                    ?>
                   <div id="div-id" style="display:none;">
                     <select id="driver_zone" name="driver_zone">
                          <option selected="selected">Select Zone Name</option>
                          <?php 
                          foreach ($zones as $key => $value) {?>
                              <option value="<?php echo $value['zone_id']; ?>" 
                              <?php if($value['zone_id'] == $o_zone_id) { echo 'selected'; }?>
                              >
                              <?php echo $value['zone_name']; ?>
                                
                              </option>
                          <?php  }?>
                          
                      </select> 
                      <button type="button" class="btn btn-primary" id="update_zone" title="assign zone">Update</button>
                       <?php 
                    echo form_close(); 
                    ?>
                  </div>
                <?php } ?>
                <!-- Option buttons -->

                <!-- driver code -->
                 <?php //echo "<pre>"; print_r($drivers); echo "</pre>";?>
                <?php $driver_zone_id_array = array();
                  foreach ($drivers as $key => $value) {
                    // echo $in = implode(",",unserialize($value['driver_zone_id']));
                      $array = @unserialize($value['driver_zone_id']);
                      if ($array === false && $string !== 'b:0;') {
                          $driver_zone_id_array[] =  $value['driver_zone_id'];
                          // woops, that didn't appear to be anything serialized
                      }else{
                           $driver_zone_id_array[] = implode(",", unserialize($value['driver_zone_id']));
                      }
    
                  }
         

                       /* $sql = $this->db->query("SELECT `driver_name` FROM  `drivers` WHERE  `driver_zone_id` IN (".$o_zone_id.") LIMIT 0 , 30")->result_array();
                
                       echo "<pre>"; print_r($sql); echo "<pre>";*/


                                        // echo "<pre>"; print_r($in); echo "</pre>";
                  $arrayName = array();
                  foreach ($driver_zone_id_array as $key => $value) {   
                        if(!array_filter($value)){
                           $arrayName[] = $value;
                        }else{
                             foreach ($value as $users => $uservalue) {
                               $arrayName[] = $uservalue;
                             }    
                        }

                  }
                  //echo "<pre>"; print_r($arrayName); echo "</pre>";
                  $resulted_array = array();
                  foreach ($zones as $key => $value) {
                      if(in_array($value['zone_id'], $arrayName)){
                          array_push($resulted_array, $value['zone_id']);
                      }
                  }
                  //echo "<pre>"; print_r($resulted_array); echo "</pre>";
                ?>

                <!-- driver code -->

              

                <?php 
                //echo "<pre>"; print_r($this->data['order_status'][0]->confirmation); echo "</pre>";
                if($this->data['order_status'][0]->confirmation!=2){ ?>
                  <div id="driver-assigned" style="display:none;">
                    <?php
                    echo form_open(); 

                    //echo "<pre>"; print_r($o_driver_id); echo "</pre>";
                    ?>
                    <input type="hidden" id="o_id" name="order_id" value="<?php echo $o_id; ?>"/>
                    <?php
                    echo form_dropdown('driver_list', $options ,$o_driver_id,' id="driver_id"');
                    ?>
                    <button type="button" class="btn btn-primary" id="update_div" title="assign driver">Update</button>
                    <?php 
                    echo form_close(); 
                    ?>
                </div>
              <?php }else{ ?>
                <div id="driver-name"><?php echo $this->data['driver_details'][0]->driver_name.' '.$this->data['driver_details'][0]->driver_lname; ?></div>
              <?php } ?>  
              </div>
            </div>
          </div>
     
        </div>

         
        <div class="timeline-box">
          <ol>
            <?php 
           // echo "<pre>"; print_r($this->data['timeline'] ); echo "</pre>";
            foreach ($this->data['timeline'] as $tkey => $timeline) {
              if($tkey==0){
                foreach ($timeline as $key =>  $value) {
                  if($this->data['order_status'][0]->confirmation==$key){
                    echo '<li '.($this->data['order_status'][0]->order_status==$tkey?'class="active"':'').' id="confirmation-value">'.$value.'</li>';
                  }
                }
              }else{
                echo "<li ".($this->data['order_status'][0]->order_status==$tkey?'class="active"':'')." >".$timeline."</li>";
              }
            }

            ?>
          </ol>
        </div>

<style>
.driver-assign {
    text-align: center;
}
div#driver-name {
    font-size: 24px;
    text-transform: capitalize;
}
</style>
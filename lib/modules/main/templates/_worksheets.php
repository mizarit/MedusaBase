<div id="page-3" style="padding: 0;margin:0;" class="inactive">
  <div style="padding: 0.5em 0.8em 0.5em 0.5em;">
    <div class="form-row">
      <div class="form-label"><label for="workorder">Bonnummer</label></div>
      <input type="text" name="workorder" id="workorder" readonly="readonly" placeholder="Bonnummer" value="Bonnummer" class="smart-input empty">
    </div>
    <div id="workorder-details">
      <div class="form-row" style="display:none;">
        <div class="form-label"><label for="debitor">Debiteurnummer</label></div>
        <input type="text" name="debitor" id="debitor" placeholder="Debiteurnummer" value="" class="smart-input empty">
      </div>
      <?php if($settings['crud_customer']) { ?>
      <div class="form-row" style="display:none;">
        <div class="form-label"><label for="contractor">Opdrachtgever</label></div>
        <div class="search">
          <span class="fa fa-search"></span>
          <input type="text" name="contractor" id="contractor" placeholder="Opdrachtgever" value="" class="smart-input empty">
        </div>
      </div>
      <div class="form-row">
        <div class="form-label"><label for="customer">Klant</label></div>
        <div class="search">
          <span class="fa fa-search"></span>
          <input type="text" name="customer" id="customer" placeholder="Klant" value="Klant" class="smart-input empty">
        </div>
      </div>
      <div class="form-row">
        <div class="form-label"><label for="address">Adres</label></div>
        <input type="input" name="address" id="address" placeholder="Adres" value="Adres" class="smart-input empty">
      </div>
      <div class="form-row">
        <div class="form-label"><label for="zipcode">Postcode &amp; plaats</label></div>
        <input type="text" name="zipcode" id="zipcode" placeholder="1234AA" value="1234AA" class="smart-input empty small">
        <input type="text" name="city" id="city" placeholder="Plaats" value="Plaats" class="smart-input empty medium">
      </div>
      <div class="form-row">
        <div class="form-label"><label for="contact">Contactpersoon</label></div>
        <input type="text" name="contact" id="contact" placeholder="Contactpersoon" value="Contactpersoon" class="smart-input empty">
      </div>
      <div class="form-row">
        <div class="form-label"><label for="phone">Telefoon</label></div>
        <input type="tel" name="phone" id="phone" placeholder="Telefoon" value="Telefoon" class="smart-input empty">
      </div>
      <div class="form-row">
        <div class="form-label"><label for="email">E-mail adres</label></div>
        <input type="email" name="email" id="email" placeholder="E-mail adres" value="E-mail adres" class="smart-input empty">
      </div>
      <?php
      $resource = Resource::model()->findByAttributes(new Criteria(array('xid' => Registry::get('user_id'))));
      $fields = Field::model()->findAllByAttributes(new Criteria(array('company_id' => $resource->company_id, 'active' => 1)));
      foreach ($fields as $field) {
        if ($field->form == 'customer') { ?>
          <div class="form-row">
            <div class="form-label"><label for="extra_1_<?php echo $field->id; ?>"><?php echo $field->label; ?></label></div>
            <input type="text" class="extra-field" name="extra_1_<?php echo $field->id; ?>" id="extra_1_<?php echo $field->id; ?>" placeholder="<?php echo $field->label; ?>" value="" class="smart-input empty">
          </div>
      <?php
        }
      }
      foreach ($fields as $field) {
        if ($field->form == 'app') { ?>
          <div class="form-row">
            <div class="form-label"><label for="extra_2_<?php echo $field->id; ?>"><?php echo $field->label; ?></label></div>
            <input type="text" class="extra-field" name="extra_2_<?php echo $field->id; ?>" id="extra_2_<?php echo $field->id; ?>" placeholder="<?php echo $field->label; ?>" value="" class="smart-input empty">
          </div>
        <?php
        }
      }
      ?>
      <?php } else { ?>
        <div class="form-row" style="display:none;">
          <div class="form-label"><label for="contractor">Opdrachtgever</label></div>
          <input type="text" readonly="readonly" name="contractor" id="contractor">
        </div>
        <div class="form-row">
          <div class="form-label"><label for="customer">Klant</label></div>
          <input type="text" readonly="readonly" name="customer" id="customer">
        </div>
        <div class="form-row">
          <div class="form-label"><label for="address">Adres</label></div>
          <input type="input" readonly="readonly" name="address" id="address">
        </div>
        <div class="form-row">
          <div class="form-label"><label for="zipcode">Postcode &amp; plaats</label></div>
          <input type="text" readonly="readonly" name="zipcode" id="zipcode" class="small">
          <input type="text" readonly="readonly" name="city" id="city" class="medium">
        </div>
        <div class="form-row">
          <div class="form-label"><label for="contact">Contactpersoon</label></div>
          <input type="text" readonly="readonly" name="contact" id="contact">
        </div>
        <div class="form-row">
          <div class="form-label"><label for="phone">Telefoon</label></div>
          <input type="tel" readonly="readonly" name="phone" id="phone">
        </div>
        <div class="form-row">
          <div class="form-label"><label for="email">E-mail adres</label></div>
          <input type="email" readonly="readonly" name="email" id="email">
        </div>
        <?php
        $resource = Resource::model()->findByAttributes(new Criteria(array('xid' => Registry::get('user_id'))));
        $fields = Field::model()->findAllByAttributes(new Criteria(array('company_id' => $resource->company_id, 'active' => 1)));
        foreach ($fields as $field) {
          if ($field->form == 'customer') { ?>
            <div class="form-row">
              <div class="form-label"><label for="extra_1_<?php echo $field->id; ?>"><?php echo $field->label; ?></label></div>
              <input type="text" class="extra-field" readonly="readonly" name="extra_1_<?php echo $field->id; ?>" id="extra_1_<?php echo $field->id; ?>">
            </div>
          <?php
          }
        }
        foreach ($fields as $field) {
          if ($field->form == 'app') { ?>
            <div class="form-row">
              <div class="form-label"><label for="extra_2_<?php echo $field->id; ?>"><?php echo $field->label; ?></label></div>
              <input type="text" class="extra-field" readonly="readonly" name="extra_2_<?php echo $field->id; ?>" id="extra_2_<?php echo $field->id; ?>">
            </div>
          <?php
          }
        }
        ?>
      <?php } ?>
    </div>
    <div id="workorder-collapse"><i id="workorder-collapse-btn" class="fa fa-caret-up"></i></div>
  </div>

<div style="clear:both;"></div>
<ul class="subnav">
  <li id="sn-1" class="button-2" onclick="Workorder.saveWorkorderForm();">Opslaan</li>
  <?php if($settings['feature_times']) { ?>
  <li id="sn-2" class="button-3" onclick="if(!$(this).hasClassName('inactive')) { Workorder.startWork(); }">Werkzaamheden starten</li>
  <li id="sn-7" class="button-3" onclick="if(!$(this).hasClassName('inactive')) { Workorder.finishWork(); }">Werkzaamheden afronden</li>
  <?php } ?>
  <?php if($settings['crud_orderrows']) { ?>
  <li id="sn-3" class="button-3" onclick="if(!$(this).hasClassName('inactive')) { Workorder.loadWorkorder(Workorder.current_workorder);Workorder.showOrderrows(); goPage(12, 3);}">Orderregels bewerken <span class="fa fa-check"></span></li>
  <?php } ?>
  <?php if($settings['crud_photo']) { ?>
  <li id="sn-4" class="button-3" onclick="if(!$(this).hasClassName('inactive')) { Workorder.loadWorkorder(Workorder.current_workorder);Workorder.renderPhotos(); goPage(8, 3); }">Situatiefoto's (<span id="photo-count">0</span>) <span class="fa fa-check"></span></li>
  <?php } ?>
  <?php
  $label = 'Controleren';
  if (!$settings['feature_signature'] && !$settings['feature_pos']) {
    // this is the last step
    $label = 'Afsluiten';
  }
  ?>
  <li id="sn-8" class="button-3" onclick="if(!$(this).hasClassName('inactive')) { Workorder.loadWorkorder(Workorder.current_workorder);Workorder.showOrderrows();Workorder.checkWorkorder(); }"><?php echo $label; ?> <span class="fa fa-check"></span></li>
  <?php if($settings['feature_signature']) { ?>
  <li id="sn-6" class="button-3" onclick="if(!$(this).hasClassName('inactive')) { Workorder.loadWorkorder(Workorder.current_workorder);Workorder.showOrderrows(); goPage(5, 3);}">Ondertekenen <span class="fa fa-check"></span></li>
  <?php } ?>
  <?php if($settings['feature_pos']) { ?>
  <li id="sn-5" class="button-3" onclick="if(!$(this).hasClassName('inactive')) { Workorder.loadWorkorder(Workorder.current_workorder);Workorder.showOrderrows(); Workorder.calculateInvoice(); goPage(9, 3); } ">Afrekenen</li>
  <?php } ?>
  <?php if($settings['delete_workorder']) { ?>
  <li id="sn-9" class="button-1" onclick="if(!$(this).hasClassName('inactive')) { Workorder.deleteWorkorder(); goPage(2); } ">Werkbon verwijderen</li>
  <?php } ?>


</ul>
</div>

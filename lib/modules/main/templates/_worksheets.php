<div id="page-3" style="padding: 0;margin:0;" class="inactive">
  <div style="padding: 0.5em 0.8em 0.5em 0.5em;">
    <div class="form-row">
      <div class="form-label"><label for="workorder">Bonnummer</label></div>
      <input type="text" name="workorder" id="workorder" placeholder="Bonnummer" value="Bonnummer" class="smart-input empty">
    </div>
    <div id="workorder-details">
      <div class="form-row">
        <div class="form-label"><label for="contractor">Opdrachtgever</label></div>
        <div class="search">
          <span class="fa fa-search"></span>
          <input type="text" name="contractor" id="contractor" placeholder="Opdrachtgever" value="" class="smart-input empty">
        </div>
      </div>
      <div class="form-row">
        <div class="form-label"><label for="debitor">Debiteurnummer</label></div>
        <input type="text" name="debitor" id="debitor" placeholder="Debiteurnummer" value="" class="smart-input empty">
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
            <input type="text" name="extra_1_<?php echo $field->id; ?>" id="extra_1_<?php echo $field->id; ?>" placeholder="<?php echo $field->label; ?>" value="" class="smart-input empty">
          </div>
      <?php
        }
      }
      foreach ($fields as $field) {
        if ($field->form == 'app') { ?>
          <div class="form-row">
            <div class="form-label"><label for="extra_2_<?php echo $field->id; ?>"><?php echo $field->label; ?></label></div>
            <input type="text" name="extra_2_<?php echo $field->id; ?>" id="extra_2_<?php echo $field->id; ?>" placeholder="<?php echo $field->label; ?>" value="" class="smart-input empty">
          </div>
        <?php
        }
      }
      ?>
    </div>
    <div id="workorder-collapse"><i id="workorder-collapse-btn" class="fa fa-caret-up"></i></div>
  </div>

<div style="clear:both;"></div>
<ul class="subnav">
  <li id="sn-1" class="button-2" onclick="Workorder.saveWorkorderForm();">Opslaan</li>
  <li id="sn-2" class="button-3" onclick="if(!$(this).hasClassName('inactive')) { Workorder.startWork(); }">Werkzaamheden starten</li>
  <li id="sn-7" class="button-3 inactive" onclick="if(!$(this).hasClassName('inactive')) { Workorder.finishWork(); }">Werkzaamheden afronden</li>
  <li id="sn-3" class="button-3 inactive" onclick="if(!$(this).hasClassName('inactive')) { Workorder.loadWorkorder(Workorder.current_workorder);Workorder.showOrderrows(); goPage(12, 3);}">Orderregels bewerken <span class="fa fa-check"></span></li>
  <li id="sn-4" class="button-3 inactive" onclick="if(!$(this).hasClassName('inactive')) { Workorder.loadWorkorder(Workorder.current_workorder);Workorder.renderPhotos(); goPage(8, 3); }">Situatiefoto's (<span id="photo-count">0</span>) <span class="fa fa-check"></span></li>
  <li id="sn-8" class="button-3 inactive" onclick="if(!$(this).hasClassName('inactive')) { Workorder.loadWorkorder(Workorder.current_workorder);Workorder.showOrderrows();Workorder.checkWorkorder(); }">Controleren <span class="fa fa-check"></span></li>
  <li id="sn-6" class="button-3 inactive" onclick="if(!$(this).hasClassName('inactive')) { Workorder.loadWorkorder(Workorder.current_workorder);Workorder.showOrderrows(); goPage(5, 3);}">Ondertekenen <span class="fa fa-check"></span></li>

  <li id="sn-5" class="button-3 inactive" onclick="if(!$(this).hasClassName('inactive')) { Workorder.loadWorkorder(Workorder.current_workorder);Workorder.showOrderrows(); Workorder.calculateInvoice(); goPage(9, 3); } ">Afrekenen</li>
  <li id="sn-9" class="button-1" onclick="if(!$(this).hasClassName('inactive')) { Workorder.deleteWorkorder(); goPage(2); } ">Werkbon verwijderen</li>


</ul>
</div>

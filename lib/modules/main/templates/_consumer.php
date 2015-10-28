<div id="page-19" style="padding: 0;margin:0;" class="inactive">
  <div style="padding: 0.5em 0.8em 0.5em 0.5em;">

        <div class="form-row">
          <div class="form-label"><label for="customer">Klant</label></div>
          <input type="text" name="customer-title" id="customer-title" placeholder="Klant" value="Klant" class="smart-input empty">
        </div>
        <div class="form-row">
          <div class="form-label"><label for="customer-address">Adres</label></div>
          <input type="input" name="customer-address" id="customer-address" placeholder="Adres" value="Adres" class="smart-input empty">
        </div>
        <div class="form-row">
          <div class="form-label"><label for="customer-zipcode">Postcode &amp; plaats</label></div>
          <input type="text" name="customer-zipcode" id="customer-zipcode" placeholder="1234AA" value="1234AA" class="smart-input empty small">
          <input type="text" name="customer-city" id="customer-city" placeholder="Plaats" value="Plaats" class="smart-input empty medium">
        </div>
        <div class="form-row">
          <div class="form-label"><label for="contact">Contactpersoon</label></div>
          <input type="text" name="contact" id="contact" placeholder="Contactpersoon" value="Contactpersoon" class="smart-input empty">
        </div>
        <div class="form-row">
          <div class="form-label"><label for="customer-phone">Telefoon</label></div>
          <input type="tel" name="customer-phone" id="customer-phone" placeholder="Telefoon" value="Telefoon" class="smart-input empty">
        </div>
        <div class="form-row">
          <div class="form-label"><label for="customer-email">E-mail adres</label></div>
          <input type="email" name="customer-email" id="customer-email" placeholder="E-mail adres" value="E-mail adres" class="smart-input empty">
        </div>
        <?php
        $resource = Resource::model()->findByAttributes(new Criteria(array('xid' => Registry::get('user_id'))));
        $fields = Field::model()->findAllByAttributes(new Criteria(array('company_id' => $resource->company_id, 'active' => 1)));
        foreach ($fields as $field) {
          if ($field->form == 'customer') { ?>
            <div class="form-row">
              <div class="form-label"><label for="consumer-extra_1_<?php echo $field->id; ?>"><?php echo $field->label; ?></label></div>
              <input type="text" class="extra-field" name="consumer-extra_1_<?php echo $field->id; ?>" id="consumer-extra_1_<?php echo $field->id; ?>" placeholder="<?php echo $field->label; ?>" value="" class="smart-input empty">
            </div>
          <?php
          }
        }
        ?>

    <h2>Werkbonnen van deze klant</h2>
    <ul id="customer-workorder-list"></ul>

  </div>

  <div style="clear:both;"></div>
  <ul class="subnav">
    <li id="sn-1" class="button-2" onclick="Workorder.saveCustomer();">Opslaan</li>
  </ul>
</div>

<div id="page-12" style="padding: 0;margin:0;">
  <h2 style="margin:0;padding:0;border-top:#fff 1px solid;background:#2ea6dd;font-size:1.5em;line-height:1.6em;color:#fff;">Orderregels</h2>
  <div style="padding: 0.5em;">
    <p id="no-orderrows">Er zijn nog geen orderregels toegevoegd.</p>
    <ul id="orderrows"></ul>
  </div>

  <div style="clear:both;"></div>
  <ul class="subnav">
    <li class="save" onclick="Workorder.saveWorkorderRows();goPage(3);">Opslaan</li>
    <li class="shortlist" onclick="Workorder.addQuicklist();">Snelkeuze toevoegen</li>
    <li onclick="Workorder.addActivity();">Werkzaamheden toevoegen</li>
    <li onclick="Workorder.addHours();">Uren toevoegen</li>
    <li onclick="Workorder.addProduct();">Product toevoegen</li>
  </ul>
</div>
<div id="page-13" style="padding: 0;margin:0;">
  <h2 style="margin:0;padding:0;border-top:#fff 1px solid;background:#2ea6dd;font-size:1.5em;line-height:1.6em;color:#fff;">Werkzaamheden toevoegen</h2>
  <div style="padding: 0.5em;">
    <div class="form-row">
      <div class="form-label"><label for="activityrowdesc">Omschrijving</label></div>
      <div class="search">
        <span class="fa fa-search"></span>
        <input type="text" name="activityrowdesc" id="activityrowdesc" placeholder="Omschrijving" value="Omschrijving" class="smart-input empty">
      </div>
    </div>
    <div class="form-row">
      <div class="form-label"><label for="activityrowcost">Kosten</label></div>
      <input type="number" name="activityrowcost" id="activityrowcost" placeholder="0,00" value="0,00" class="smart-input empty small">
    </div>
  </div>

  <div style="clear:both;"></div>
  <ul class="subnav">
    <li class="save" id="activity-add-btn" onclick="Workorder.addActivityRow();">Toevoegen</li>
    <li class="save" id="activity-save-btn" onclick="Workorder.saveActivityRow();">Opslaan</li>

  </ul>
</div>
<div id="page-14" style="padding: 0;margin:0;">
  <h2 style="margin:0;padding:0;border-top:#fff 1px solid;background:#2ea6dd;font-size:1.5em;line-height:1.6em;color:#fff;">Uren toevoegen</h2>
  <div style="padding: 0.5em;">
    <div class="form-row">


      <div class="form-label"><label for="hoursrowdesc">Omschrijving</label></div>
      <div class="search">
        <span class="fa fa-search"></span>
        <input type="text" name="hoursrowdesc" id="hoursrowdesc" placeholder="Omschrijving" value="Omschrijving" class="smart-input empty">
      </div>
    </div>
    <div class="form-row">
      <div class="form-label"><label for="hoursrowminutes">Minuten</label></div>
      <input type="number" name="hoursrowminutes" id="hoursrowminutes" placeholder="0" value="0" class="smart-input empty small">
    </div>
  </div>

  <div style="clear:both;"></div>
  <ul class="subnav">
    <li class="save" id="hours-add-btn" onclick="Workorder.addHoursRow();">Toevoegen</li>
    <li class="save" id="hours-save-btn" onclick="Workorder.saveHoursRow();">Opslaan</li>
  </ul>
</div>
<div id="page-15" style="padding: 0;margin:0;">
  <h2 style="margin:0;padding:0;border-top:#fff 1px solid;background:#2ea6dd;font-size:1.5em;line-height:1.6em;color:#fff;">Product toevoegen</h2>
  <div style="padding: 0.5em;">
    <div class="form-row">
      <div class="form-label"><label for="productrowdesc">Omschrijving</label></div>
      <div class="search">
        <span class="fa fa-search"></span>
        <input type="text" name="productrowdesc" id="productrowdesc" placeholder="Omschrijving" value="Omschrijving" class="smart-input empty">
      </div>
    </div>
    <div class="form-row">
      <div class="form-label"><label for="productrowcost">Prijs incl. BTW</label></div>
      <input type="number" name="productrowcost" id="productrowcost" placeholder="0,00" value="0,00" class="smart-input empty small">
    </div>
    <div class="form-row">
      <div class="form-label"><label for="productrowamount">Aantal</label></div>
      <input type="number" name="productrowamount" id="productrowamount" placeholder="1" value="1" class="smart-input empty small">
    </div>
    <!--<div class="form-row">
      <div class="form-label"><label for="productrowvat">BTW tarief</label></div>
      <input type="number" name="productrowvat" id="productrowvat" placeholder="21" value="21" class="smart-input empty small">
    </div>-->
    <input type="hidden" name="productrowvat" id="productrowvat" value="21">
  </div>

  <div style="clear:both;"></div>
  <ul class="subnav">
    <li class="save" id="product-add-btn" onclick="Workorder.addProductRow();">Toevoegen</li>
    <li class="save" id="product-save-btn" onclick="Workorder.saveProductRow();">Opslaan</li>
  </ul>
</div>
<div id="page-17" style="padding: 0;margin:0;">
  <h2 style="margin:0;padding:0;border-top:#fff 1px solid;background:#2ea6dd;font-size:1.5em;line-height:1.6em;color:#fff;">Snelkeuze</h2>
  <div style="padding: 0.5em;">

  </div>

  <div style="clear:both;"></div>
  <ul class="subnav" id="shortlist-picker">
  </ul>
</div>


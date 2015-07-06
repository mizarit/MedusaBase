<div id="page-3" style="padding: 0;margin:0;" class="inactive">
  <h2 style="margin:0;padding:0;border-top:#fff 1px solid;background:#2ea6dd;font-size:1.5em;line-height:1.6em;color:#fff;">Werkbon</h2>
  <div style="padding: 0.5em;">
    <div class="form-row">
      <div class="form-label"><label for="workorder">Bonnummer</label></div>
      <input type="text" name="workorder" id="workorder" placeholder="Bonnummer" value="Bonnummer" class="smart-input empty">
    </div>
    <div id="workorder-details">
      <div class="form-row">
        <div class="form-label"><label for="contractor">Opdrachtgever</label></div>
        <div class="search">
          <span class="fa fa-search"></span>
          <input type="text" name="contractor" id="contractor" placeholder="Opdrachtgever" value="Opdrachtgever" class="smart-input empty">
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
    </div>
    <div id="workorder-collapse"><i id="workorder-collapse-btn" class="fa fa-caret-up"></i></div>
  </div>

<div style="clear:both;"></div>
<ul class="subnav">
  <li id="sn-1" class="save" onclick="Workorder.saveWorkorderForm();">Opslaan</li>
  <li id="sn-2" onclick="if(!$(this).hasClassName('inactive')) { Workorder.startWork(); }">Werkzaamheden starten</li>
  <li id="sn-7" class="inactive" onclick="if(!$(this).hasClassName('inactive')) { Workorder.finishWork(); }">Werkzaamheden afronden</li>
  <li id="sn-3" class="inactive" onclick="if(!$(this).hasClassName('inactive')) { Workorder.loadWorkorder(Workorder.current_workorder);Workorder.showOrderrows(); goPage(12, 3);}">Orderregels bewerken <span class="fa fa-check"></span></li>
  <li id="sn-4" class="inactive" onclick="if(!$(this).hasClassName('inactive')) { Workorder.loadWorkorder(Workorder.current_workorder);Workorder.renderPhotos(); goPage(8, 3); }">Situatiefoto's (<span id="photo-count">0</span>) <span class="fa fa-check"></span></li>
  <li id="sn-8" class="inactive" onclick="if(!$(this).hasClassName('inactive')) { Workorder.checkWorkorder(); }">Controleren <span class="fa fa-check"></span></li>
  <li id="sn-6" class="inactive" onclick="if(!$(this).hasClassName('inactive')) goPage(5, 3);">Ondertekenen <span class="fa fa-check"></span></li>

  <li id="sn-5" class="inactive" onclick="if(!$(this).hasClassName('inactive')) { Workorder.calculateInvoice(); goPage(9, 3); } ">Afrekenen</li>


</ul>
</div>

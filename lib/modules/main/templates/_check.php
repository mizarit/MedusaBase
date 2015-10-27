<div id="page-18" style="padding: 0;margin:0;">
  <div style="padding: 0.5em;">
    <ul id="check-summary"></ul>
      <textarea id="remarks" name="remarks" placeholder="Opmerkingen"></textarea>
    <input id="mark-as-ready" type="checkbox" checked="checked" onchange="Workorder.setReady(this.checked);">
    <label class="checkbox" for="mark-as-ready" style="margin-bottom:0.4em;"> Werkzaamheden zijn gereed</label>
    <div id="checklist-container"></div>

  </div>
  <ul class="subnav">
    <?php
    $label = 'Werkbon afsluiten';
    if($settings['feature_signature']) {
      $label = 'Klant laten ondertekenen';
    } else if($settings['feature_pos']) {
      $label = 'Klant laten afrekenen';
    }
      ?>
    <li id="signature-btn" class="button-2" onclick="Workorder.finalizeWorkorder();"><?php echo $label; ?></li>
  </ul>


</div>

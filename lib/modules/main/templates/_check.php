<div id="page-18" style="padding: 0;margin:0;">
  <h2 style="margin:0;padding:0;border-top:#fff 1px solid;background:#2ea6dd;font-size:1.5em;line-height:1.6em;color:#fff;">Controleren</h2>
  <div style="padding: 0.5em;">
    <ul id="check-summary"></ul>
      <textarea id="remarks" name="remarks" placeholder="Opmerkingen"></textarea>
    <input id="mark-as-ready" type="checkbox" checked="checked" onchange="Workorder.setReady(this.checked);">
    <label class="checkbox" for="mark-as-ready" style="margin-bottom:0.4em;"> Werkzaamheden zijn gereed</label>
      <ul class="subnav">
        <li id="signature-btn" class="save" onclick="Workorder.finalizeWorkorder();">Klant laten ondertekenen</li>
      </ul>

  </div>
</div>

<div id="page-9" style="padding: 0;margin:0;">
  <div style="padding: 0.5em;">
    <ul id="invoice-summary"></ul>
    <ul class="subnav">
      <li id="payment-cash-btn" onclick="Workorder.startPayment('cash');">Contant</li>
      <li id="payment-pin-btn" onclick="Workorder.startPayment('pin');">Pin-betaling</li>
      <li id="payment-onvoice-btn" onclick="Workorder.startPayment('invoice');">Op rekening</li>
      <li id="payment-service-btn" onclick="Workorder.startPayment('service');">Service</li>
      <li class="save" id="payment-service-btn" onclick="Workorder.startPayment('none');">Niet afrekenen</li>
    </ul>
  </div>
</div>

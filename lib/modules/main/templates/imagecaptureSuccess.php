<style type="text/css">
  input[type="file"]#fileElem1,
  input[type="file"]#fileElem2,
  input[type="file"]#fileElem3 {
    /* Note: display:none on the input won't trigger the click event in WebKit.
       Setting visibility to hidden and width 0 works.*/
    visibility: hidden;
    width: 0;
    height: 0;
  }
 .fileSelect {
    color: #08233e;
    font-size: 18pt;
    padding: 12px;
    background: -webkit-gradient(linear, left top, left bottom,
    color-stop(0.5, rgba(255,255,255,0.3)), color-stop(0.5, #ffcc00), to(#ffcc00));
    background: -webkit-linear-gradient(top, rgba(255,255,255,0.3) 50%, #ffcc00 50%, #ffcc00);
    background: -moz-linear-gradient(top, rgba(255,255,255,0.3) 50%, #ffcc00 50%, #ffcc00);
    background: -ms-linear-gradient(top, rgba(255,255,255,0.3) 50%, #ffcc00 50%, #ffcc00);
    background: -o-linear-gradient(top, rgba(255,255,255,0.3) 50%, #ffcc00 50%, #ffcc00);
    background: linear-gradient(top, rgba(255,255,255,0.3) 50%, #ffcc00 50%, #ffcc00);
    background-color: #ffcc00;
    border: 1px solid #ffcc00;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    -o-border-radius: 10px;
    -ms-border-radius: 10px;
    border-radius: 10px;
    border-bottom: 1px solid #9f9f9f;
    -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.5);
    -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.5);
    -o-box-shadow: inset 0 1px 0 rgba(255,255,255,0.5);
    -ms-box-shadow: inset 0 1px 0 rgba(255,255,255,0.5);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.5);
    cursor: pointer;
    text-shadow: 0 1px #fff;
  }
  .fileSelect:hover {
    background: -webkit-gradient(linear, left top, left bottom,
    color-stop(0, #fff), color-stop(0.7, #ffcc00),
    to(#ffcc00));
    background: -webkit-linear-gradient(top, #fff, #ffcc00 70%, #ffcc00);
    background: -moz-linear-gradient(top, #fff, #ffcc00 70%, #ffcc00);
    background: -o-linear-gradient(top, #fff, #ffcc00 70%, #ffcc00);
    background: -ms-linear-gradient(top, #fff, #ffcc00 70%, #ffcc00);
    background: linear-gradient(top, #fff, #ffcc00 70%, #ffcc00);
  }
  .fileSelect:active {
    position: relative;
    top: 2px;
  }
</style>
<form action="#" enctype="multipart/form-data" method="POST">
<div style="padding:10px;">
  <h1 style="margin:0;text-align:center;font-size:2em;text-transform: uppercase;font-family:'Proxima-Nova'">Image capture test</h1>
  <div style="margin-bottom:1em;background:#fff;border:#cecece 3px solid;padding:0.2em;border-radius: 0.5em;">
      test 1: selecteer of maak foto's, uitgebreid<br>
      <input name="file1" type="file" id="fileElem1" multiple onchange="$('save-btn').disabled = false;" accept="image/*;capture=camera">
      <button class="fileSelect" id="fileSelect1" type="button">Selecteer of maak foto</button>
      <br>
      <hr>
      test 2: forceer foto maken<br>
      <input name="file2" type="file" id="fileElem2" multiple onchange="$('save-btn').disabled = false;" accept="image/*" capture="camera">
      <button class="fileSelect" id="fileSelect2" type="button">Maak een foto</button>
      <hr>
      test 3: selecteer of maak foto's<br>
      <input name="file3" type="file" id="fileElem3" multiple onchange="$('save-btn').disabled = false;" accept="image/*">
      <button class="fileSelect" id="fileSelect3" type="button">Selecteer of maak foto</button>

  </div>
  <div>
    <button id="save-btn" disabled="disabled" style="float:right;font-size:2em;padding: 0 0.5em;border-radius:0.1em;">Opslaan</button>
    <div id="save-msg"></div>
  </div>
</div>
</form>
<script type="text/javascript">
  Event.observe($('fileSelect1'), 'click', function() {
    $('fileElem1').click();
  });
  Event.observe($('fileSelect2'), 'click', function() {
    $('fileElem2').click();
  });
  Event.observe($('fileSelect3'), 'click', function() {
    $('fileElem3').click();
  });
</script>

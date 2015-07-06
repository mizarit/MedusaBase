<div id="page-8" style="padding: 0;margin:0;">
  <h2 style="margin:0;padding:0;border-top:#fff 1px solid;background:#2ea6dd;font-size:1.5em;line-height:1.6em;color:#fff;">Situatiefoto's</h2>
  <div style="padding: 0.5em;">
    <p id="no-photos">Er zijn nog geen foto's toegevoegd.</p>
    <ul id="images"></ul>

    <img id="loaded-image" style="width:100%">

    <form action="#" enctype="multipart/form-data" method="POST" id="photo-form">
    </form>
  </div>
  <div style="clear:both;"></div>
  <ul class="subnav">
    <li class="save" onclick="Workorder.savePhotoForm();">Opslaan</li>
    <?php if(isset($_SESSION['isIos']) && $_SESSION['isIos']){ ?>
      <li onclick="iOS.attachFileInput();">Foto toevoegen</li>
    <?php }
    else if(isset($_SESSION['isAndroid']) && $_SESSION['isAndroid']){ ?>
      <li onclick="Android.attachFileInput();">Foto toevoegen</li>
    <?php } ?>
      <li id="photo-delete" style="background:#e93653;">Foto verwijderen</li>
  </ul>

  </div>
</div>


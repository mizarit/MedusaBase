<div id="page-8" style="padding: 0;margin:0;">
  <div style="padding: 0.5em;">
    <p id="no-photos">Er zijn nog geen foto's toegevoegd.</p>
    <ul id="images"></ul>

    <img id="loaded-image" style="width:100%">

    <form action="#" enctype="multipart/form-data" method="POST" id="photo-form">
    </form>
  </div>
  <div style="clear:both;"></div>
  <ul class="subnav">
    <li class="button-2" onclick="Workorder.savePhotoForm();">Opslaan</li>
    <?php if(isset($_SESSION['isIos']) && $_SESSION['isIos']){ ?>
      <li onclick="iOS.attachFileInput();">Foto toevoegen</li>
    <?php }
    else if(isset($_SESSION['isAndroid']) && $_SESSION['isAndroid']){ ?>
      <li onclick="Android.attachFileInput();">Foto toevoegen</li>
    <?php } ?>
      <li id="photo-delete" style="background:#e93653;">Foto verwijderen</li>
  </ul>
</div>


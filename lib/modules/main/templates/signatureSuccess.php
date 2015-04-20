<div style="padding:10px;">
  <h1 style="margin:0;text-align:center;font-size:2em;text-transform: uppercase;font-family:'Proxima-Nova'">Signature test</h1>
  <div style="margin-bottom:1em;background:#fff;border:#cecece 3px solid;padding:0.2em;border-radius: 0.5em;">
    <canvas id="signaturePanel" style="width:100%;height:20em;background: #fff;">no canvas support</canvas>
  </div>
  <div>
    <button id="clear-btn" type="button" style="font-size:2em;padding: 0 0.5em;border-radius:0.1em;">Wissen</button>
    <button id="save-btn" type="button" style="float:right;font-size:2em;padding: 0 0.5em;border-radius:0.1em;">Opslaan</button>
    <div id="save-msg"></div>
  </div>
</div>
<script type="text/javascript">
  window.Signature = Class.create({
    sign: [],
    initialize: function (el) {

      this.signPad = $(el);
      this.signPadContext = this.signPad.getContext('2d');

      this.signPad.width = this.signPad.getWidth();
      this.signPad.height = this.signPad.getHeight();
      Event.observe(this.signPad, 'mousedown', this.eventSignPad);
      Event.observe(this.signPad, 'mouseup', this.eventSignPad);
      Event.observe(this.signPad, 'mousemove', this.eventSignPad);
      Event.observe(this.signPad, 'touchstart', this.eventTouchPad);
      Event.observe(this.signPad, 'touchmove', this.eventTouchPad);
      Event.observe(this.signPad, 'touchend', this.eventTouchPad);

      Event.observe($('clear-btn'), 'click', this.eventClear);
      Event.observe($('save-btn'), 'click', this.eventSave);

      this.sign = new this.signCap(this);
      this.signPadContext.lineWidth = 3;
    },

    eventClear: function()
    {
      signatureSigner.signPad.width = signatureSigner.signPad.width;
      signatureSigner.signPadContext.lineWidth = 3;
    },

    eventSave: function()
    {
      var data = signatureSigner.signPad.toDataURL();
      var signatureData = data.replace(/^data:image\/(png|jpg);base64,/, "");

      new Ajax.Request('/main/signature', {
        parameters: {
          image: signatureData
        },
        onSuccess: function(transport)
        {
          $('save-msg').innerHTML = transport.responseText;
        }

      });
    },

    signCap: function(o)
    {
      //var sign = o.sign;
      this.draw = false;
      this.start = false;

      this.mousedown = function(event) {
        signatureSigner.signPadContext.beginPath();
        signatureSigner.signPadContext.arc(event._x, event._y,1,0*Math.PI,2*Math.PI);
        signatureSigner.signPadContext.fill();
        signatureSigner.signPadContext.stroke();
        signatureSigner.signPadContext.moveTo(event._x, event._y);
        signatureSigner.sign.draw = true;
        //saveButton.enable();
      };

      this.mousemove = function(event) {
        if (signatureSigner.sign.draw) {
          signatureSigner.signPadContext.lineTo(event._x, event._y);
          signatureSigner.signPadContext.stroke();
        }
      };

      this.mouseup = function(event) {
        if (signatureSigner.sign.draw) {
          signatureSigner.sign.mousemove(event);
          signatureSigner.sign.draw = false;
        }
      };

      this.touchstart = function(event) {
        signatureSigner.signPadContext.beginPath();
        signatureSigner.signPadContext.arc(event._x, event._y,1,0*Math.PI,2*Math.PI);
        signatureSigner.signPadContext.fill();
        signatureSigner.signPadContext.stroke();
        signatureSigner.signPadContext.moveTo(event._x, event._y);
        signatureSigner.sign.start = true;
        //saveButton.enable();
      };

      this.touchmove = function(event) {
        event.preventDefault();
        if (signatureSigner.sign.start) {
          signatureSigner.signPadContext.lineTo(event._x, event._y);
          signatureSigner.signPadContext.stroke();
        }
      };

      this.touchend = function(event) {
        if (signatureSigner.sign.start) {
          signatureSigner.signatureSigner.sign.touchmove(event);
          signatureSigner.signatureSigner.sign.start = false;
        }
      };
    },

    eventSignPad: function(event)
    {
      if (event.offsetX || event.offsetX == 0) {
        event._x = event.offsetX;
        event._y = event.offsetY;
      } else if (event.layerX || event.layerX == 0) {
        event._x = event.layerX;
        event._y = event.layerY;
      }
      offset = Element.cumulativeOffset(signatureSigner.signPad);
      event._x = event._x - offset.left;
      event._y = event._y - offset.top;

      var func = signatureSigner.sign[event.type];
      if (func) {
        func(event);
      }
    },

    eventTouchPad: function(event)
    {
      event._x = event.targetTouches[0].pageX;// - mySign.getX();
      event._y = event.targetTouches[0].pageY;// - mySign.getY();

      offset = Element.cumulativeOffset(signatureSigner.signPad);
      event._x = event._x - offset.left;
      event._y = event._y - offset.top;

      var func = signatureSigner.sign[event.type];
      if (func) {
        func(event);
      }
    }

  });

  var signatureSigner = new Signature('signaturePanel');
</script>

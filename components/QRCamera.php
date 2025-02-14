<script type="text/javascript" src="../js/instascan.min.js"></script>

<!-- camera element -->
<div class="card-body" style="position: relative;">
    <div id="timer-container" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); aspect-ratio: 1;">
        <svg width="100%" height="100%" viewBox="0 0 200 200">
            <circle cx="100" cy="100" r="90" stroke="#007bff" stroke-width="10" fill="none" stroke-dasharray="565" stroke-dashoffset="565" transform="rotate(-90 100 100)">
                <animate attributeName="stroke-dashoffset" from="565" to="0" dur="2s" fill="freeze" />
            </circle>
        </svg>
    </div>
    <video id="preview" class="rounded-3" width="100%"></video>
</div>

<!-- invisible form element to submit data using QR code -->
<div id="form-container">
    <form action="../controllers/QR_Log_insert.php" method="post" class="form-horizontal" name="text">
        <input type="hidden" name="text" id="text" readonny="" placeholder="scan qrcode" class="form-control">
    </form>
</div>


<script>
    setTimeout(function() {

        // Delay camera display by 3 seconds to prevent multiple QR scans
        document.getElementById('timer-container').style.display = 'none';
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('No cameras found');
            }
        }).catch(function(e) {
            console.error(e);
        });

        //Scanning function
        scanner.addListener('scan', function(c) {
            document.getElementById('text').value = c;
            document.forms['text'].submit();
        });
    }, 2000);
</script>
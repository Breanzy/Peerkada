<!-- FOR THE THINGY BELOWW -->
<div class="col-md-4">

    <form action="blah.php" method="post" class="form-horizontal" name="blah">
        <input type="text" name="blah" id="blah" readonny="" placeholder="Input Name" class="form-control">
    </form>

    <form action="insert1.php" method="post" class="form-horizontal" name="text">
        <label>Input name if no QR Code</label>
        <input type="text" name="text" id="text" readonny="" placeholder="scan qrcode" class="form-control">
    </form>
</div>




<?php

// Calculates total duty time per month according to title. I think this function could be optimized.
switch ($Title) {
    case 'Assistant':
        $DutyHour = 16;
        break;
    case 'Junior':
        $DutyHour = 12;
        break;
    case 'Senior':
        $DutyHour = 10;
        break;
    case 'LAV':
        $DutyHour = 20;
        break;
    default:
        $DutyHour = 0;
}

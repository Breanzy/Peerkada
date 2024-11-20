<?php session_start(); ?>

<html>
    <head>
        <script type = "text/javascript" src = "js/instascan.min.js"></script>
        <script type = "text/javascript" src = "js/vue.min.js"></script>
        <script type = "text/javascript" src = "js/adapter.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/customStyle.css">

        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="style.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
        <script src= https://code.jquery.com/jquery-3.5.1.js></script>
        <script src= https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js></script>
        <script src= https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js></script>
        <script src="js/listhingy.js"></script>

    </head>

    <body>

        <div class= "container">
            <div class = "row">
                <!-- FOR THE VIDEO CAM -->
                <div class= "col-md-6">
                <center><p class="login-box-msg"> <i class="glyphicon glyphicon-camera"></i> SCAN HERE</p></center> 
                    <video id= "preview" width="85%"></video>
                    <br>

                    <?php
                    if (isset($_SESSION['error'])) {
                        echo "
                          <div class='alert alert-danger alert-dismissible fade fadeout' style='background:red;color:#fff'>
                            <h4><i class='icon fa fa-warning fade fadeout'></i> Error!</h4>
                            " . $_SESSION['error'] . "
                          </div>
                        ";
                        unset($_SESSION['error']);
                    }
                    if (isset($_SESSION['success'])) {
                        echo "
                          <div class='alert alert-success alert-dismissible fade fadeout' style='background:green;color:#fff'>
                            <h4><i class='icon fa fa-check'></i> Success!</h4>
                            " . $_SESSION['success'] . "
                          </div>
                        ";
                        unset($_SESSION['success']);
                    }
                    ?>
                </div>
                <!-- FOR THE RIGHT SIDE THINGY -->
                <div class = "col-md-6" >
                    <h1>RECENT LOGS</h1>
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <td id="t1">STUDENT ID</td>
                                <td style="width:300px">LOGDATE</td>
                                <td style="width:450px">TIME IN</td>
                                <td style="width:450px">TIME OUT</td>
                                <td style="width:950px">TOTAL TIME</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $server = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "qrcode";

                            $DATE = date('d-m-Y');

                            $conn = new mysqli($server, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Connection failed" . $conn->connect_error);
                            }
                            $sql = "SELECT * FROM table_attendance WHERE LOGDATE = '$DATE' ORDER BY ID DESC";
                            $query = $conn->query($sql);
                            while ($row = $query->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['STUDENTID']; ?></td>
                                        <td><?php echo $row['LOGDATE']; ?></td>
                                        <td><?php echo ($row['TIMEIN'] != null) ? date('h:i:s A', strtotime($row['TIMEIN'])) : null; ?></td>
                                        <td><?php echo ($row['TIMEOUT'] != null) ? date('h:i:s A', strtotime($row['TIMEOUT'])) : null; ?></td>
                                        <td><?php echo ($row['TIMEOUT'] != null) ? gmdate("H \\h\\r/\\s, i \\m\\i\\n/\\s, s \\s\\e\\c/\\s", $row['TIMEOUT'] - $row['TIMEIN']) : null; ?></td>
                                    </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                  </table>

                </div>
                <!-- FOR THE THINGY BELOWW -->
                <div class="col-md-6">

                    <form action="blah.php" method="post" class="form-horizontal" name="blah">
                        <input type="text" name="blah" id="blah" readonny="" placeholder="Input Name" class="form-control">
                    </form>

                    <form action="insert1.php" method="post" class="form-horizontal" name="text">
                        <label>Input name if no QR Code</label>
                        <input type="text" name="text" id="text" readonny="" placeholder="scan qrcode" class="form-control">
                    </form>
                    
                </div> 

                <div>
                    
                </div>
            </div>
        </div>


        
         <script>
             let scanner = new Instascan.Scanner({video: document.getElementById('preview')});
                Instascan.Camera.getCameras().then(function(cameras)
                {
                    if(cameras.length > 0){
                        scanner.start(cameras[0]);
                    } else {
                        alert('No cameras found');
                    }
                }).catch(function(e){
                    console.error(e);
                });

                scanner.addListener('scan', function(c){
                    document.getElementById('text').value=c;
                    document.forms['text'].submit();
                });
        </script>
        
    </body>
</html>
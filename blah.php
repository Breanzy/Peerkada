<?php session_start(); ?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css">

    </head>

    <body>
        <?php                   
            $server = "localhost";
            $username="root";
            $password="";
            $dbname="qrcode";
        
            $conn = new mysqli($server,$username,$password,$dbname);

            if($conn->connect_error)
                die("Connection failed" .$conn->connect_error);

            if(isset($_POST['blah']))
            {
                $text = $_POST['blah'];

                $sql = "SELECT * FROM members_profile WHERE ID_NUMBER = '$text'";
                $query = $conn->query($sql);

                if($query->num_rows > 0){
                    ?>
                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <td>STUDENT NAME</td>
                                <td>LOGDATE</td>
                                <td>TIME IN</td>
                                <td>TIME OUT</td>
                            </tr>
                        </thead>

                        <tbody>

                        <?php
                            $TOTALTIN = 0;
                            $TOTALOUT = 0;
                                
                            while ($row = $query->fetch_assoc()){
                                $TOTALOUT += $row['TIMEOUT'];
                                $TOTALTIN += $row['TIMEIN'];
                                ?>
                            
                                <tr>
                                    <td><?php echo $row['STUDENTID'];?></td>
                                    <td><?php echo $row['LOGDATE'];?></td>
                                    <td><?php echo ($row['TIMEIN'] != null) ? date('h:i:s A', strtotime($row['TIMEIN'])) : null;?></td>
                                    <td><?php echo ($row['TIMEOUT'] != null) ? date('h:i:s A', strtotime($row['TIMEOUT'])) : null;?></td>
                                    <td><?php echo ($row['TIMEOUT'] != null) ? gmdate("H \\h\\r/\\s, i \\m\\i\\n/\\s, s \\s\\e\\c/\\s", $row['TIMEOUT'] - $row['TIMEIN']): null ;?></td>
                                </tr>
                            
                                <?php
                            }?>
        
                        </tbody>
                    </table>
        
                    <br><br><br>

                    <h1>Total Time: <?php echo gmdate("H \\h\\r/\\s, i \\m\\i\\n/\\s, s \\s\\e\\c/\\s", ($TOTALOUT - $TOTALTIN))?></h1>

                <?php
                }
        
        else
            echo 'WALAY NAME NA INANA HEHEHE';
        }
        ?>

    </body>

</html>
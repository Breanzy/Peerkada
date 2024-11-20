<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="css/customStyle.css">
    <link href="css/styles.css" rel="stylesheet">

</head>


<body>

<form action="blah.php" method="post" class="form-horizontal" name="blah">
        <input type="text" name="blah">
    </form>

    <?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "id21827628_peerkada";
    $conn = new mysqli($server, $username, $password, $dbname) or die("Unable to connect");

    $date = date('y-m-d');

    // $sql = "INSERT INTO table_attendance(LOGDATE) VALUES('$date')";
    $sql = "SELECT * FROM table_attendance WHERE MONTH(LOGDATE)= 2";
    $query = $conn->query($sql);

    while ($row = $query->fetch_assoc()) {
        echo "the deed iz done";
        echo $row['LOGDATE'];
    }

    ?>

</body>
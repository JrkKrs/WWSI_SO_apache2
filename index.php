<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "moja_domena_pl_apache";
$password = "P@ssw0rd";
$dbname = "moja_domena_pl";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
if(isset($_GET['add']) && $_GET['add']=='user')
{
//    print_r($_POST);
    $firstname = $_POST['name'];
    $lastname = $_POST['surname'];
    $email = $_POST['email'];
    $stmt = $conn->prepare("insert into moja_domena_pl.table (name, surname, email, datetime_add) VALUE (:firstname, :lastname , :email, now())");
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);

    $stmt->execute();
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: https://moja-domena.pl/');
    header('Connection: close');

}
if(isset($_GET['get']) && $_GET['get']=='user')
{
    $stmt = $conn->prepare("select name, surname, email, datetime_add from moja_domena_pl.table;");
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $list = $stmt->fetchAll();
//    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
//        echo $v;
//    }
    $jaon = json_encode(['data' => $list]);
    header('Content-Type: application/json');
    echo $jaon;

}
else
{
    echo "<!doctype html>
<html lang=\"pl\">
<head>
    <!-- Required meta tags -->
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">

    <!-- Bootstrap CSS -->
    <link rel=\"stylesheet\" href=\"vendor/twbs/bootstrap/dist/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"vendor/datatables/datatables/media/css/dataTables.bootstrap4.min.css\">

    <title>Hello, world!</title>
    <script>
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('txt').innerHTML =
                h + \":\" + m + \":\" + s;
            var t = setTimeout(startTime, 500);
        }

        function checkTime(i) {
            if (i < 10) {
                i = \"0\" + i
            }
            ;  // add zero in front of numbers < 10
            return i;
        }
    </script>
</head>
<body>
<div class=\"container\">
    <div class=\"row\">
        <div class=\"col\">
            <table id=\"example\" class=\"display\" style=\"width:100%\">
                <thead>
                <tr>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>email</th>
                    <th>data dodania</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>email</th>
                    <th>data dodania</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <div class=\"col-sm-2\">
            <h4><span id=\"txt\" class=\"badge badge-secondary\"></span></h4>
            <button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#exampleModal\">Dodaj nową
                osobę
            </button>
        </div>
    </div>
</div>


<div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\"
     aria-hidden=\"true\">
    <div class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">
            <form action='index.php?add=user' method='post'>
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\" id=\"exampleModalLabel\">New message</h5>
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                    </button>
                </div>
                <div class=\"modal-body\">
                   
                        <div class=\"form-group\">
                            <label for=\"recipient-name\" class=\"col-form-label\">Imię:</label>
                            <input name='name' type=\"text\" class=\"form-control\" id=\"recipient-name\" required>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"recipient-surname\" class=\"col-form-label\">Nazwisko:</label>
                            <input name='surname' type=\"text\" class=\"form-control\" id=\"recipient-surname\" required>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"recipient-mail\" class=\"col-form-label\">Email:</label>
                            <input name='email' type=\"email\" class=\"form-control\" id=\"recipient-mail\" required>
                        </div>
                    
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Zamknij</button>
                    <button type=\"submit\" class=\"btn btn-primary\">Dodaj użytkownika</button>
                </div>
            </form> 
        </div>
    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src=\"vendor/components/jquery/jquery.js\"></script>
<script src=\"popper.js\"></script>
<script src=\"vendor/twbs/bootstrap/dist/js/bootstrap.min.js\"></script>
<script src='vendor/datatables/datatables/media/js/jquery.dataTables.min.js'></script>
<script src='vendor/datatables/datatables/media/js/dataTables.bootstrap4.min.js'></script>
<script>
    startTime();

    $(document).ready(function () {
        $('#example').DataTable({
            \"ajax\": 'index.php?get=user',
            \"columns\": [
                {\"data\": \"name\"},
                {\"data\": \"surname\"},
                {\"data\": \"email\"},
                {\"data\": \"datetime_add\"}
            ]
        });
    });
</script>
</body>
</html>";
}

$conn = null;

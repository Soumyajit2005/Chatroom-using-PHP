<?php

// Get parameters
$roomname = $_GET['roomname'];

// Connecting to the database
include "db_connect.php";

// Execute sql to check whether room exists
$sql = "SELECT * FROM `rooms` WHERE `roomname` = '$roomname'";

$result = mysqli_query($conn, $sql);
if ($result) {
    // Check if room exists
    if (mysqli_num_rows($result) == 0) {
        $message = "This room does not exist. Try creating a new name";
        echo "<script language='javascript'>";
        echo "alert('$message');";
        echo "window.location='http://localhost/chatroom';";
        echo "</script>";
    }

} else {
    echo "Error: " . mysqli_error($conn);
}

// echo "Lets chat now";

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/product/"> -->

    <link href="css/product.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body {
            margin: 0 auto;
            max-width: 800px;
            padding: 0 20px;
        }

        .container {
            border: 2px solid #dedede;
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
        }

        .darker {
            border-color: #ccc;
            background-color: #ddd;
        }

        .container::after {
            content: "";
            clear: both;
            display: table;
        }

        .container img {
            float: left;
            max-width: 60px;
            width: 100%;
            margin-right: 20px;
            border-radius: 50%;
        }

        .container img.right {
            float: right;
            margin-left: 20px;
            margin-right: 0;
        }

        .time-right {
            float: right;
            color: #aaa;
        }

        .time-left {
            float: left;
            color: #999;
        }

        .anyclass {
            height: 350px;
            overflow-y: scroll;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
                aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="#">MyChatRoom</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>

            </div>
        </div>
    </nav>

    <h2>Chat Messages -
        <?php echo $roomname; ?>
    </h2>

    <div class="container">
        <div class="anyclass">
            <img src="/w3images/bandmember.jpg" alt="Avatar" style="width:100%;">
            <p>Hello. How are you today?</p>
            <span class="time-right">11:00</span>
        </div>

    </div>


    <input type="text" class="form-control" name="usermsg" id="usermsg" placeholder="Add message"><br>
    <button class="btn btn-primary" name="submitmsg" id="submitmsg">Send</button>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <script type="text/javascript">

        // Using Enter key to submit 
        var input = document.getElementById("usermsg");
        input.addEventListener("keypress", function (event) {
            // event.preventDefault();
            if (event.keyCode === 13) {
                document.getElementById("submitmsg").click();
            }
        });

        // If user submits the form
        $("#submitmsg").click(function () {
            var clientmsg = $("#usermsg").val();
            $.post("postmsg.php", { text: clientmsg, room: "<?php echo $roomname ?>", ip: "<?php echo $_SERVER['REMOTE_ADDR'] ?>" },
                function (data, status) {
                    document.getElementsByClassName('anyclass')[0].innerHTML = data;
                });

            $("#usermsg").val("");

            return false;


        });
    </script>
</body>

</html>
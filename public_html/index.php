<html>
<head>
    <script>
        var live = new EventSource("http://localhost:8080/live");
        live.addEventListener("message", function (message) {
            document.body.innerHTML += message.data;
        });
    </script>
</head>
<body style="background-color:#ddd;">
<?php phpinfo()?>
Hello World at
</body>
</html>
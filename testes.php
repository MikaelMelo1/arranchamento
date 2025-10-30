<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <div onclick="Window();">téste</div>
</body>
</html>


<SCRIPT>


    function Window() {
        history.pushState("http://localhost/arfh/", "titulo", "endereco");
    }
</SCRIPT>
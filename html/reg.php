<?php
$host = "ravenedu";
$dbname = "RavenDB";
$user = "iplexa";
$password = "zuRxHw2f";

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $login = $_POST["login"];
        $pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);
        $email = $_POST["email"];

        $sql = "INSERT INTO users (name, surname, login, pass, email) VALUES (:name, :surname, :login, :pass, :email)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        header("Location: ./login.html");
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Raven</title>
    <link rel="stylesheet" href="../css/login-reg-style.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/root.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@200;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container">
            <a class="back-link gr_text" href="./login.html">назад</a>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <img src="../atributes/img/login logo.svg" alt="логотип рейвен" class="logo">
            <form action="" method="post">
                <div class="inputs-block">
                    <input type="text" class="default-input" name="name" placeholder="Имя" required>
                    <input type="text" class="default-input" name="surname" placeholder="Фамилия" required>
                    <input type="text" class="default-input" name="login" placeholder="Придумайте никнейм" required maxlength="15">
                    <input type="password" class="default-input" name="pass" placeholder="Придумайте пароль" required maxlength="15" minlength="5">
                    <input type="email" class="default-input" name="email" placeholder="Электронная почта" required>
                </div>
                <button type="submit" class="login-btn dark-btn">Зарегистрироваться</button>
            </form>
        </div>
    </main>
</body>
</html>
<!DOCTYPE html>
<html="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет Raven</title>
</head>
<body>
    <main id="main" class="main">
        <div class="container">
            <?php
            // Get the user ID from the cookie
            $userId = isset($_COOKIE['user_id']) ? intval($_COOKIE['user_id']) : 0;

            // Connect to the PostgreSQL database using PDO
            $host = "ravenedu";
            $db = "RavenDB";
            $user = "iplexa";
            $pass = "zxRxHw2f";
            $charset = 'utf8mb4';
            $dsn = "pgsql:host=$host;dbname=$db";
            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($dsn, $user, $pass, $opt);

            // Retrieve the user information from the database based on the user ID
            if ($userId) {
                $stmt = $pdo->prepare("SELECT name, surname, email, id, login FROM users WHERE id = :id");
                $stmt->bindParam(':id', $userId);
                $stmt->execute();
                $user = $stmt->fetch();

                // Display the user information
                if ($user) {
                    echo "<table>";
                    echo "<tr><th>Имя:</th><td>" . htmlspecialchars($user['name']) . "</td></tr>";
                    echo "<tr><th>Фамилия:</th><td>" . htmlspecialchars($user['surname']) . "</td></tr>";
                    echo "<tr><th>Email:</th><td>" . htmlspecialchars($user['email']) . "</td></tr>";
                    echo "<tr><th>ID:</th><td>" . htmlspecialchars($user['id']) . "</td></tr>";
                    echo "<tr><th>Логин:</th><td>" . htmlspecialchars($user['login']) . "</td></tr>";
                    echo "</table>";
                } else {
                    echo "Пользователь не найден.";
                }
            } else {
                echo "Пользователь не авторизован.";
            }
            ?>
        </div>
        <button id="logoutButton">Выйти из аккаунта</button>
    </main>
    <script>
        document.getElementById('logoutButton').addEventListener('click', function() {
            // Delete the user_id cookie
            if (document.cookie.includes('user_id=')) {
                document.cookie = 'user_id=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
            }

            // Optionally, you can redirect the user to the login page after logout
            window.location.href = 'login.html';
        });
    </script>
</body>
</html>
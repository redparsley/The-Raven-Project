<?php
$host = "ravenedu";
$db = "RavenDB";
$user = "iplexa";
$pass = "zuRxHw2f";

$login = $_POST['login']; // получаем логин из формы
$password = $_POST['password']; //чаем пароль из формы

try {
   // подключаемся к базе данных с помощью PDO
   $connection = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
   $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // выполняем запрос к базе данных для проверки логина
   $query = "SELECT * FROM users WHERE login=:login";
   $statement = $connection->prepare($query);
   $statement->bindParam(':login', $login);
   $statement->execute();
   $user = $statement->fetch();

   // если запрос вернул результат, значит логин найден
   if ($user) {
       // сравниваем введенный пароль с хэшированным паролем из базы данных
       if (password_verify($password, $user['pass'])) {
           // пароли совпадают, заходим в аккаунт
           session_start();
           $_SESSION['login'] = $login;

           // сохраняем айди пользователя в куки
           $user_id = $user['id'];
           setcookie("user_id", $user_id, time() + 60 * 60 * 24 * 30); // устанавливаем куки на 30 дней

           header('Location: account.php');
       } else {
           // пароли не совпадают, выводим ошибку
           echo "Неверный пароль";
       }
   } else {
       // логин не найден, выводим ошибку
       echo "Неверный логин или пароль";
   }

   // закрываем соединение с базой данных
   $connection = null;
} catch (PDOException $e) {
   die("Error: " . $e->getMessage());
}
?>
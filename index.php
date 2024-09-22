<?php
// Conexão com o banco de dados
$servername = "sql105.byetcluster.com"; // servidor de banco de dados
$username = "if0_37357799";
$password = "loHzX1FqxhMLOn";
$dbname = "if0_37357799_ccyber";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$registrationSuccess = false; // Para controlar se o registro foi bem-sucedido
$loginMessage = ''; // Para controlar mensagens de login
$userRole = ''; // Para armazenar o papel do usuário
$showLoginError = false; // Para controlar se deve mostrar erro de login

// Processa o registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Captura a senha como texto simples

    // Verifica se o nome de usuário já existe
    $stmt = $conn->prepare("SELECT COUNT(*) FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<p>Este nome de Utilizador já está registrado.</p>";
    } else {
        // Prepara e vincula para inserir novo usuário
        $stmt = $conn->prepare("INSERT INTO Users (Username, Password, Estado, Cargo) VALUES (?, ?, 'Ativo', 'Utilizador')");
        if ($stmt) {
            $stmt->bind_param("ss", $username, $password); // Insere a senha como texto simples

            // Executa a consulta
            if ($stmt->execute()) {
                $registrationSuccess = true; // Atualiza a variável para mostrar o popup
            } else {
                echo "<p>Erro ao registrar: " . $stmt->error . "</p>";
            }

            // Fecha a declaração
            $stmt->close();
        } else {
            echo "<p>Erro ao preparar a consulta: " . $conn->error . "</p>";
        }
    }
}

// Processa o login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $login_username = trim($_POST['login_username']);
    $login_password = trim($_POST['login_password']); // Captura a senha como texto simples

    // Verifica as credenciais do usuário
    $stmt = $conn->prepare("SELECT Password, Cargo FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $login_username);
    $stmt->execute();
    $stmt->bind_result($storedPassword, $userRole);
    $stmt->fetch();
    $stmt->close();

    if ($storedPassword === $login_password) { // Compara a senha armazenada com a senha fornecida
        $loginMessage = "Bem-vindo, $login_username!"; // Mensagem de boas-vindas
    } else {
        $showLoginError = true; // Mostra erro de login
    }
}

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro e Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            animation: backgroundAnimation 10s ease infinite;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        @keyframes backgroundAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            width: 90%;
            max-width: 1000px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            background: white;
        }

        .column {
            flex: 1;
            min-width: 300px;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input[type="text"], input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #74ebd5;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #58c2bc;
        }

        /* Estilos do popup */
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            animation: popupAnimation 0.5s ease;
        }

        @keyframes popupAnimation {
            from { opacity: 0; transform: translate(-50%, -40%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }

        .overlay {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 500;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="column">
            <h2>Registro</h2>
            <form method="post" action="">
                <label for="username">Nome de Utilizador:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <input type="submit" name="register" value="Registrar">
            </form>
        </div>
        <div class="column">
            <h2>Login</h2>
            <form method="post" action="">
                <label for="login_username">Nome de Utilizador:</label>
                <input type="text" id="login_username" name="login_username" required>
                <label for="login_password">Senha:</label>
                <input type="password" id="login_password" name="login_password" required>
                <input type="submit" name="login" value="Entrar">
            </form>
            <?php if ($showLoginError): ?>
                <p class="error">Nome de usuário ou senha inválidos.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Popup de sucesso no registro -->
    <?php if ($registrationSuccess): ?>
        <div class="overlay" id="overlay"></div>
        <div class="popup" id="popup">
            <h2>Registro bem-sucedido!</h2>
            <p>Obrigado por se registrar! Agora já pode entrar.</p>
            <input type="button" value="Fechar" onclick="closePopup()">
        </div>
    <?php endif; ?>

    <!-- Popups de boas-vindas -->
    <?php if (!empty($loginMessage)): ?>
        <div class="overlay" id="overlay"></div>
        <div class="popup" id="popup">
            <h2><?php echo ($userRole === 'Administrador') ? 'Bem-vindo, Administrador!' : 'Bem-vindo, Utilizador!'; ?></h2>
            <p><?php echo $loginMessage; ?></p>
            <input type="button" value="Iniciar" onclick="closePopup()">
        </div>
    <?php endif; ?>

    <script>
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        <?php if ($registrationSuccess || !empty($loginMessage)): ?>
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        <?php endif; ?>
    </script>
</body>
</html>
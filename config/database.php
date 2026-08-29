<?php
class Database {
    private static string $host = 'localhost';
    private static string $db_name = 'beautyshop_db';
    private static string $username = 'root';
    private static string $password = ''; // Ajustar contraseña si aplica
    private static ?PDO $conn = null;

    public static function getConnection(): ?PDO {
        if (self::$conn === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                self::$conn = new PDO($dsn, self::$username, self::$password, $options);
            } catch (PDOException $e) {
                die("Error de Conexión a la Base de Datos: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}

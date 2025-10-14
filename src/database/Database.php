<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;
    private $conn;

    public function __construct() {
        $this->host = DB_HOST;
        $this->db_name = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;
        $this->charset = DB_CHARSET;
    }

    /**
     * 
     * @return PDO|null
     */
    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "sqlsrv:server=" . $this->host . ";Database=" . $this->db_name;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch(PDOException $e) {
            // Mostrar error amigable y detener ejecución
            $error_msg = $e->getMessage();
            
            // Verificar si es un error de firewall de Azure
            if (strpos($error_msg, 'not allowed to access the server') !== false) {
                die("
                <div style='font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; border: 2px solid #dc3545; border-radius: 10px; background-color: #f8d7da;'>
                    <h2 style='color: #721c24;'>🔒 Error de Firewall de Azure SQL Server</h2>
                    <p><strong>Tu IP está bloqueada por el firewall de Azure.</strong></p>
                    <p>Tu IP actual no está autorizada para conectarse al servidor SQL en Azure.</p>
                    
                    <h3 style='color: #721c24;'>✅ Solución:</h3>
                    <ol>
                        <li>Ve al <a href='https://portal.azure.com' target='_blank'>Portal de Azure</a></li>
                        <li>Busca tu servidor SQL: <strong>marketperu</strong></li>
                        <li>Ve a <strong>Firewalls and virtual networks</strong></li>
                        <li>Haz clic en <strong>\"+ Add client IP\"</strong></li>
                        <li>Guarda los cambios y espera 2-5 minutos</li>
                    </ol>
                    
                    <details style='margin-top: 20px;'>
                        <summary style='cursor: pointer; color: #721c24;'><strong>Ver error técnico completo</strong></summary>
                        <pre style='background-color: #fff; padding: 10px; border-radius: 5px; overflow-x: auto; margin-top: 10px;'>" . htmlspecialchars($error_msg) . "</pre>
                    </details>
                </div>
                ");
            } else {
                // Otros errores de conexión
                die("
                <div style='font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; border: 2px solid #dc3545; border-radius: 10px; background-color: #f8d7da;'>
                    <h2 style='color: #721c24;'>❌ Error de Conexión a la Base de Datos</h2>
                    <p>No se pudo establecer conexión con el servidor SQL.</p>
                    <details style='margin-top: 20px;'>
                        <summary style='cursor: pointer; color: #721c24;'><strong>Ver detalles del error</strong></summary>
                        <pre style='background-color: #fff; padding: 10px; border-radius: 5px; overflow-x: auto; margin-top: 10px;'>" . htmlspecialchars($error_msg) . "</pre>
                    </details>
                </div>
                ");
            }
        }

        return $this->conn;
    }
}


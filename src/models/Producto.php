<?php
class Producto {
    private $conn;
    private $table = 'productos';

    // Propiedades del producto
    public $id_producto;
    public $nombre;
    public $categoria;
    public $precio;
    public $disponible;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * 
     * @return PDOStatement
     */
    public function leer() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id_producto DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * 
     * @return bool
     */
    public function leerUno() {
        // Para SQL Server: usar consulta preparada correctamente
        $query = "SELECT TOP 1 * FROM " . $this->table . " WHERE id_producto = ?";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$this->id_producto]);
            
            // SQL Server puede devolver -1 en rowCount(), usar fetch() directamente
            $row = $stmt->fetch();
            if ($row) {
                $this->nombre = $row['nombre'];
                $this->categoria = $row['categoria'];
                $this->precio = $row['precio'];
                // Convertir bit (0/1) a 'SI'/'NO' para compatibilidad con formularios
                $this->disponible = ($row['disponible'] == 1) ? 'SI' : 'NO';
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Para depuración: mostrar el error SQL
            error_log("Error SQL en leerUno: " . $e->getMessage());
            return false;
        }
    }

    /**
     * 
     * @return bool
     */
    public function crear() {
        // Limpiar datos
        $nombre = htmlspecialchars(strip_tags($this->nombre));
        $categoria = htmlspecialchars(strip_tags($this->categoria));
        $precio = htmlspecialchars(strip_tags($this->precio));
        
        // Convertir 'SI'/'NO' a 1/0 para SQL Server (tipo bit)
        $disponible_bit = ($this->disponible === 'SI') ? 1 : 0;

        // Usar consulta preparada
        $query = "INSERT INTO " . $this->table . " (nombre, categoria, precio, disponible) VALUES (?, ?, ?, ?)";

        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$nombre, $categoria, $precio, $disponible_bit]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * 
     * @return bool
     */
    public function actualizar() {
        // Limpiar datos
        $nombre = htmlspecialchars(strip_tags($this->nombre));
        $categoria = htmlspecialchars(strip_tags($this->categoria));
        $precio = htmlspecialchars(strip_tags($this->precio));
        
        // Convertir 'SI'/'NO' a 1/0 para SQL Server (tipo bit)
        $disponible_bit = ($this->disponible === 'SI') ? 1 : 0;

        // Usar consulta preparada
        $query = "UPDATE " . $this->table . " 
                  SET nombre = ?, categoria = ?, precio = ?, disponible = ?
                  WHERE id_producto = ?";

        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$nombre, $categoria, $precio, $disponible_bit, $this->id_producto]);
        } catch (PDOException $e) {
            // Para depuración: mostrar el error
            $_SESSION['mensaje'] = 'Error SQL: ' . $e->getMessage();
            $_SESSION['tipo_mensaje'] = 'error';
            return false;
        }
    }

    /**
     * 
     * @return bool
     */
    public function eliminar() {
        // Usar consulta preparada
        $query = "DELETE FROM " . $this->table . " WHERE id_producto = ?";

        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$this->id_producto]);
        } catch (PDOException $e) {
            return false;
        }
    }

}


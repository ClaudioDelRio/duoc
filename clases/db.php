<?php
class db
{
    //Declaración de variables
    protected $connection;
    protected $query;
    protected $show_errors = TRUE;
    protected $query_closed = TRUE;
    public $query_count = 0;
    public $insert_id;
    protected $in_transaction = FALSE;

    // función "constructora"
    // Ojo, que coloca valores por default en caso de no pasarle parámetros.
    // Estos valores están entre comillas: localhost, root, vacío ('') y utf8.
    public function __construct($dbhost = 'localhost', $dbuser = 'root', $dbpass = '', $dbname = 'vademecum', $charset = 'utf8')
    {
        $this->connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($this->connection->connect_error) {
            $this->error('No se pudo conectar a MySQL - ' . $this->connection->connect_error);
        }
        $this->connection->set_charset($charset);
    }

    // función que recibe una consulta (query) y la ejecuta.
    public function query($query)
    {
        if (!$this->query_closed) {
            $this->query->close();
        }
        if ($this->query = $this->connection->prepare($query)) {
            if (func_num_args() > 1) {
                $x = func_get_args();
                $args = array_slice($x, 1);
                $types = '';
                $args_ref = array();
                foreach ($args as $k => &$arg) {
                    if (is_array($args[$k])) {
                        foreach ($args[$k] as $j => &$a) {
                            $types .= $this->_gettype($args[$k][$j]);
                            $args_ref[] = & $a;
                        }
                    } else {
                        $types .= $this->_gettype($args[$k]);
                        $args_ref[] = & $arg;
                    }
                }
                
                // Verificar si hay tipos para bind_param
                if (!empty($types) && !empty($args_ref)) {
                    array_unshift($args_ref, $types);
                    call_user_func_array(array($this->query, 'bind_param'), $args_ref);
                }
            }
            $this->query->execute();
            if ($this->query->errno) {
                $this->error('No se puede procesar la consulta de MySQL (revisa tus parámetros) - ' . $this->query->error);
            }
            $this->query_closed = FALSE;
            $this->query_count++;
        } else {
            $this->error('No se puede preparar la declarción de MySQL (revisa tu sintaxis) - ' . $this->connection->error);
        }
        return $this;
    }

    // Función que trae todos los resultados de la consulta
    public function fetchAll($callback = null)
    {
        $params = array();
        $row = array();
        $meta = $this->query->result_metadata();
        
        if (!$meta) {
            // Si no hay metadata, retornar un array vacío - lo modifique por que me causaba error.
            return [];
        }
        
        while ($field = $meta->fetch_field()) {
            $params[] = & $row[$field->name];
        }
        
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        
        while ($this->query->fetch()) {
            $r = array();
            foreach ($row as $key => $val) {
                $r[$key] = $val;
            }
            
            if ($callback != null && is_callable($callback)) {
                $value = call_user_func($callback, $r);
                if ($value == 'break') break;
            } else {
                $result[] = $r;
            }
        }
        
        $this->query->free_result();
        $this->query->close();
        $this->query_closed = TRUE;
        
        return $result;
    }

    // función que devuelve un array
    public function fetchArray()
    {
        $params = array();
        $row = array();
        $meta = $this->query->result_metadata();
        while ($field = $meta->fetch_field()) {
            $params[] = & $row[$field->name];
        }
        call_user_func_array(array($this->query, 'bind_result'), $params);
        $result = array();
        while ($this->query->fetch()) {
            foreach ($row as $key => $val) {
                $result[$key] = $val;
            }
        }
        $this->query->store_result();
        $this->query->close();
        $this->query_closed = TRUE;
        return $result;
    }

    // función que cierra la conerxión a la base de datos
    public function close()
    {
        return $this->connection->close();
    }

    // función que obtiene el número de registros que trae la consulta.
    public function numRows()
    {
        $this->query->store_result();
        return $this->query->num_rows;
    }

    // función que trae los registros afectados por la consulta
    public function affectedRows()
    {
        return $this->query->affected_rows;
    }

    // Función para obtener el último ID insertado
    public function getInsertId() {
        return $this->connection->insert_id;
    }

    // función que muestra el error devuelto por la base de datos
    public function error($error)
    {
        if ($this->show_errors) {
            exit($error);
        }
    }

    //función que obtiene el tipo de dato
    private function _gettype($var)
    {
        if (is_string($var))
            return 's';
        if (is_float($var))
            return 'd';
        if (is_int($var))
            return 'i';
        return 'b';
    }

    // MÉTODOS PARA MANEJAR TRANSACCIONES

    /**
     * Inicia una transacción en la base de datos
     */
    public function beginTransaction()
    {
        $this->connection->autocommit(FALSE);
        $this->in_transaction = TRUE;
        return $this->connection->begin_transaction();
    }

    /**
     * Confirma una transacción en la base de datos
     */
    public function commit()
    {
        $result = $this->connection->commit();
        $this->connection->autocommit(TRUE);
        $this->in_transaction = FALSE;
        return $result;
    }

    /**
     * Revierte una transacción en la base de datos
     */
    public function rollBack()
    {
        $result = $this->connection->rollback();
        $this->connection->autocommit(TRUE);
        $this->in_transaction = FALSE;
        return $result;
    }

    /**
     * Verifica si hay una transacción activa
     */
    public function inTransaction()
    {
        return $this->in_transaction;
    }
}
?>
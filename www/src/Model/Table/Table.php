<?php
namespace App\Model\Table;

use \App\Controller\Database\DatabaseController;

/**
 *  Classe Table : accès aux tables
 **/
class Table
{
    /**
     * @var connect (old)
     * @access protected
     */
    //protected static $_connect = null;

    /**
     * @var db : DatabaseController
     * @access protected
     */
    protected $db;

    /**
     * @var table : nom de la table en base
     * @access protected
     */
    protected $table;


    /**
     * Constructeur de la classe sans databaseController
     *
     * @return void
     * @access private
     */
   /*  public function __constructOld()
    {
        if (self::$_connect == null)
            self::$_connect = Connect::getInstance();
    }
 */
    //==============================  correction AFORMAC
    /**
     * Constructeur de la classe avec un databaseController
     *
     * @return void
     * @access private
     */
    public function __construct(DatabaseController $db = null)
    {
/*         if ($db == null) {
            $this->__constructOld();
        } else  */{
            $this->db = $db;
            if (is_null($this->table)) {
                $parts = explode('\\', get_class($this));
                // nom de la classe dont on crée une instance
                $class_name = end($parts);
                // nom de la table en base
                $this->table = strtolower(str_replace('Table', '', $class_name));
            }
        }
    }
    public function count(?int $id = null)
    {
        $nbpage =  $this->query("SELECT COUNT(id) as nbrow FROM $this->table", null, true, null);
        // recupere un objet PostEntity
        //dd($nbpage);
        return $nbpage;
    }

    /**
     * lecture d'un enregistrement par son id 
     * valable pour n'importe quelle table
     */
    public function find(int $id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE id=?", [$id], true);
    }

    /**
     * exécution de la requête à la base
     */
    public function query(string $statement, ?array $attributes = null, bool $one = false, ?string $class_name = null)
    {
        if (is_null($class_name)) {
            // instance de la classe 'Entity'
            $class_name = str_replace('Table', 'Entity', get_class($this));
        }
        if ($attributes) {
            return $this->db->prepare($statement, $attributes, $class_name, $one);
        } else {
            return $this->db->query($statement, $class_name, $one);
        }
    }
}

<?php
namespace App\Model\Table;

use App\Model\Entity\PostEntity;

/**
 *  Classe PostTable : accès à la table post 
 **/
class PostTable extends Table
{
    /**
     * L'objet unique PostTable
     * @var $_instance
     * @access private
     * @static
     */
    //private static $_instance = null;

    /**
     * Méthode qui crée l'unique instance de la classe
     * si elle n'existe pas encore puis la retourne.
     *
     * @param void
     * @return PostTable
     */
    /*     public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new PostTable();
        }

        return self::$_instance;
    }

 */
    /**
     *  retourne le nombre total de posts d'une catégorie dans la table post
     * @param int
     * @return int
     *   SELECT count(id) FROM post 
     *   WHERE id IN (SELECT post_id FROM post_category WHERE category_id = {$idCategory}) ");
     **/
    /*    public static function getNbPost(int $idCategory = null): int
    {
        if ($idCategory === NULL) {
            $statement = self::$_connect->executeQuery("SELECT count(id) FROM post");
        } else {
            $statement = self::$_connect->executeQuery("
            SELECT count(category_id) FROM post_category WHERE  category_id = {$idCategory}");
        }
        return $statement->fetch()[0];
    }
 */
    /**
     *  retourne tous les articles d'une catégorie dans la table post
     * @param int
     * @param int
     * @param int
     * @return int
     **/
    /*     public static function getPosts(int $perPage, int $offset, int $idCategory = null): array
    {
        if ($idCategory == null) {
            $statement = self::$_connect->executeQuery("SELECT * FROM post as p
            ORDER BY created_at DESC
            LIMIT {$perPage} 
            OFFSET {$offset}");
        } else {
            $statement = self::$_connect->executeQuery("SELECT * FROM post as p 
                JOIN post_category as pc ON pc.post_id = p.id 
                WHERE pc.category_id = {$idCategory}
                ORDER BY created_at DESC
                LIMIT {$perPage} OFFSET {$offset} ");
        }

        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);

        $posts = $statement->fetchAll();

        return $posts;
    }
 */
    /**
     *  retourne un article recherché par son id dans la table post
     * @param int
     * @return int
     **/
    /*     
public static function getPost(int $id): Post
    {
        $statement = self::$_connect->executeQuery("SELECT * FROM post 
        WHERE id = {$id}");
        $statement->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        $post = $statement->fetch();
        $post->setCategories(self::getCategoriesOfPost($id));

        return ($post);
    }

 */
    /**
     *  retourne toutes les catégories d'un article
     * @param int
     * @param int
     * @param int
     * @return int
     **/
    /*     public static function getCategoriesOfPost(int $idPost): array
    {
        $statement = self::$_connect->executeQuery(
            "SELECT c.id, c.slug, c.name 
            FROM post_category pc 
            JOIN category c ON pc.category_id = c.id 
            WHERE pc.post_id = {$idPost}
            ORDER BY c.id 
            "
        );
        $statement->setFetchMode(\PDO::FETCH_CLASS, Category::class);
        $categories = $statement->fetchAll();

        return $categories;
    }

 */

    //==============================  correction AFORMAC
    /**
     * lecture de tous les articles d'une page
     */
    public function allByLimit(int $limit, int $offset)
    {

        $posts = $this->query("SELECT * FROM {$this->table} LIMIT {$limit} OFFSET {$offset}", null);

        $ids = array_map(function (PostEntity $post) {
            return $post->getId();
        }, $posts);


        $categories = (new CategoryTable($this->db))->allInId(implode(', ', $ids));


        $postById = [];
        foreach ($posts as $post) {
            $postById[$post->getId()] = $post;
        }
        //dd($categories);
        foreach ($categories as $category) {
            $postById[$category->post_id]->setCategory($category);
        }
        return $postById;
    }

    public function count(?int $id = null)
    {
        if (!$id){
            // sans id : appel de la méthode de la classe parente Table.php
            return parent::count();
        }else{
            return $this->query("SELECT COUNT(id) as nbrow FROM {$this->table} as p 
                    JOIN post_category as pc ON pc.post_id = p.id 
                    WHERE pc.category_id = {$id}", null, true);
            
        }

        // recupere un objet PostEntity
        //dd($nbpage);
       // return $nbpage;
    }
    /**
     * lecture de tous les articles d'une catégorie d'une page
     */
    public function allInIdByLimit(int $limit, int $offset, int $idCategory)
    {

        $posts = $this->query("
        SELECT * FROM {$this->table} as p 
                JOIN post_category as pc ON pc.post_id = p.id 
                WHERE pc.category_id = {$idCategory}
                LIMIT {$limit} OFFSET {$offset} ", null);

        $ids = array_map(function (PostEntity $post) {
            return $post->getId();
        }, $posts);


        $categories = (new CategoryTable($this->db))->allInId(implode(', ', $ids));


        $postById = [];
        foreach ($posts as $post) {
            $postById[$post->getId()] = $post;
        }
        //dd($categories);
        foreach ($categories as $category) {
            $postById[$category->post_id]->setCategory($category);
        }
        return $postById;
    }
}

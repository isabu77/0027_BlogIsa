<?php
namespace App\Controller;
//use App\Model\Table\CategoryTable;

class CategoryController extends Controller
{
    /**
     * constructeur par Correction AFORMAC
     */
    public function __construct()
    {
        // crée une instance de la classe PostTable dans la propriété $this->post
        // $this->category est créée dynamiquement
        $this->loadModel('category');    
        
        // $this->post est créée dynamiquement pour accéder aux méthodes de PostTable
        // via PaginatedQueryController pour afficher les posts d'une catégorie
        $this->loadModel('post');
    }

    /**
     * toutes les catégories
     */
    public function all()
    {
        //==============================  correction AFORMAC
        // $this->post contient une instance de la classe PostTable
        $paginatedQuery = new PaginatedQueryController(
            $this->category,
            $this->generateUrl('categories'), 10
        );
        $categories = $paginatedQuery->getItems();

        $title = "les habitats";

        // affichage HTML avec category/all.twig
        $this->render('category/all', [
            'categories' => $categories,
            'paginate' => $paginatedQuery->getNavHTML(),
            'title' => $title
        ]);

        //==============================  correction AFORMAC FIN
        
        //============================= MON CODE
/*         
        // lecture des catégories dans la base 
        $paginatedController = new PaginatedController(
            'getNbCategory',
            'getCategories',
            'App\Model\Table\CategoryTable',
            $this->getRouter()->url("categories"),
            null,
            10
        );
        $categories = $paginatedController->getItems();
        $title = "Catégories";

        $this->render(
            "category/all",
            [
                "title" => $title,
                "categories" => $categories,
                "paginate" => $paginatedController->getNavHTML()
            ]
        );
*/
        //============================= MON CODE === FIN
    }

    /**
     * une seule catégorie et ses articles
     */
    public function show(string $slug, int $id)
    {
    

        //==============================  correction AFORMAC
        // méthode générique de table.php
        $category = $this->category->find($id);

        if (!$category) {
            throw new \exception("Aucune catégorie ne correspond à cet Id");
        }
        if ($category->getSlug() !== $slug) {
            $url = $this->generateUrl('category', ['id' => $id, 'slug' => $category->getSlug()]);
            // code 301 : redirection permanente pour le navigateur (de son cache, plus de requete au serveur)
            http_response_code(301);
            header('Location:' . $url);
            exit();
        }

        $title = 'Habitat : ' . $category->getName();

        // les articles de la catégorie : ERROR !! affiche tous les articles, de toutes catégories
        // $this->post doit etre créé par loadModel dans le constructeur
        $paginatedQuery = new PaginatedQueryController(
            $this->post,
            $this->generateUrl('category', ["id" => $category->getId(), "slug" => $category->getSlug()])
        );
        $postById = $paginatedQuery->getItemsInId($id);

        //============================= MON CODE 
        // lecture de la catégorie id dans la base (objet Category)
        //$categoryTable = CategoryTable::getInstance();
        //$category = $categoryTable::getCategory($id);
        //============================= MON CODE === FIN


        $this->render(
            "category/show",
            [
                "title" => $title,
                "posts" => $postById,
                "paginate" => $paginatedQuery->getNavHTML()
            ]
        );
        //==============================  correction AFORMAC FIN

        //============================= MON CODE
        // lecture des articles de la catégorie par son id dans la base 
/*         
        $uri = $this->getRouter()->url("category", ["id" => $category->getId(), "slug" => $category->getSlug()]);
        $paginatedController = new PaginatedController(
            'getNbPost',
            'getPosts',
            'App\Model\Table\PostTable',
            $uri,
            $category->getId()
        );
        $posts = $paginatedController->getItems();
 */
        /**
         *  @var $postById
         * Tableau d'objets Post
         * dont la propriété  $catégories est lue dans la base
         *  
         */
/*
        $postById = $categoryTable::getCategoriesOfPosts($posts);

        $this->render(
            "category/show",
            [
                "title" => $title,
                "posts" => $postById,
                "paginate" => $paginatedController->getNavHTML()
            ]
        );
 */    
        //============================= MON CODE === FIN
    }
}

<?php
namespace App\Controller;

/* use App\Model\Table\CategoryTable;
use App\Model\Table\PostTable;
use App\Model\Entity\Category;
use App\Model\Entity\Post; */

class InscriptionController extends Controller
{
    /**
     * tous les articles
     */
    public function index()
    {
        $title = 'Inscription';

        $this->render('inscription/index', [
            'title' => $title
        ]);


    }

}
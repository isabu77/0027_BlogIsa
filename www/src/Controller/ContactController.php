<?php
namespace App\Controller;

/* use App\Model\Table\CategoryTable;
use App\Model\Table\PostTable;
use App\Model\Entity\Category;
use App\Model\Entity\Post; */

class ContactController extends Controller
{
    /**
     * tous les articles
     */
    public function index()
    {
        $title = 'Contact';

        $this->render('contact/index', [
            'title' => $title
        ]);


    }

}
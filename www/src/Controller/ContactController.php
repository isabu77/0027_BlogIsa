<?php
namespace App\Controller;
use \Core\Controller\Controller;

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
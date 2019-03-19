<?php

namespace App\Controller;

use App\Dao\EventDao;
use App\Dao\ArticleDao;
use App\Dao\CommentDao;
use App\Dao\BaseDao;
use App\Service\AuthentificationService;

class FrontendController
{
    private $eventDao;
    private $articleDao;
    private $commentDao;
    private $twig;
    private $authentificationService;

    /**
     * FrontendController constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct($twig)
    {
        $this->eventDao = new EventDao();
        $this->articleDao = new ArticleDao();
        $this->commentDao = new CommentDao();
        $this->twig = $twig;
        $this->authentificationService = new AuthentificationService();
    }

    public function er()
    {
        header("HTTP/1.0 404 Not Found");
        die();
    }

    //affichage dela page d'accueil
    public function home()
    {
        $lastArticle = $this->articleDao->lastArticle();
        $lastEvent = $this->eventDao->lastEvent();
        return $this->twig->render('frontend/home.html.twig', ['lastArticle' => $lastArticle, 'lastEvent' => $lastEvent]);
    }

    //affichage de la page des articles avec pagination
    public function pageArticles($offset = 0, $limit = 3)
    {
        $pageArt = $this->articleDao->artPage($offset, $limit);
        $nbarticles = $this->articleDao->count();
        $nbPages = ceil($nbarticles / (int)$limit);
        $prevOffset = $offset == 0 ? 0 : $offset - $limit;
        $nextOffset = $offset <= $nbarticles ? $offset + $limit : $offset;
        return $this->twig->render('frontend/pageArticles.html.twig',
            ['nextoffset' => $nextOffset, 'prevoffset' => $prevOffset, 'offset' => $offset, 'limit' => $limit, 'nbarticles' => $nbarticles, 'nbpages' => (int)$nbPages, 'pageart' => $pageArt]);
    }

    //affichage de la page des évenements avec pagination
    public function pageEvents($offset = 0, $limit = 2)
    {
        $pageEv = $this->eventDao->eventPage($offset, $limit);
        $nbevents = $this->eventDao->count();
        $nbPages = ceil($nbevents / (int)$limit);
        $prevOffset = $offset == 0 ? 0 : $offset - $limit;
        $nextOffset = $offset <= $nbevents ? $offset + $limit : $offset;
        return $this->twig->render('frontend/pageEvents.html.twig',
            ['nextoffset' => $nextOffset, 'prevoffset' => $prevOffset, 'offset' => $offset, 'limit' => $limit, 'nbevents' => $nbevents, 'nbpages' => (int)$nbPages, 'pageev' => $pageEv]);
    }

    //affichage de la page d'un article
    public function findArticle($id)
    {
        $articles = $this->articleDao->findAll();
        $events = $this->eventDao->findEvents();
        $event = $this->eventDao->find($id);
        $article = $this->articleDao->find($id);
        $comments = $this->commentDao->getComments($id);
        if (!$article) {
            $this->er();
        }
        return $this->twig->render('frontend/article.html.twig', ['events' => $events, 'event' => $event, 'article' => $article, 'articles' => $articles, 'comments' => $comments]);
    }

    //affichage de la page d'un évenement
    public function findEvent($id)
    {
        $events = $this->eventDao->findEvents();
        $articles = $this->articleDao->findAll();
        $event = $this->eventDao->find($id);
        if (!$event) {
            $this->er();
        }
        return $this->twig->render('frontend/event.html.twig', ['events' => $events, 'event' => $event, 'articles' => $articles]);
    }

    // création d'un commentaire
    public function addComment($articleId, $formData)
    {
        $this->commentDao->insert($articleId, $formData->get("author"), $formData->get("comment"));
        header('location: /article/' . $articleId);
        die();
    }

    //affichage fu formulaire de contact
    public function contact()
    {
        $articles = $this->articleDao->findAll();
        $events = $this->eventDao->findEvents();
        return $this->twig->render('frontend/contact.html.twig', ['events' => $events, 'articles' => $articles]);
    }

    //envoi des éléments de contact par mail
    public function postContact($formData)
    {
        $articles = $this->articleDao->findAll();
        $events = $this->eventDao->findEvents();
        $name = $formData->get('name');
        $firstName = $formData->get('firstname');
        $email = $formData->get('email');
        $phone = $formData->get('phone');
        $message = $formData->get('message');

        $options = [
            'name' => FILTER_SANITIZE_STRING,
            'firstname' => FILTER_SANITIZE_STRING,
            'email' => FILTER_VALIDATE_EMAIL,
            'phone' => FILTER_SANITIZE_STRING,
            'message' => FILTER_SANITIZE_STRING
        ];
        $resultat = filter_input_array(INPUT_POST, $options);
        if ($resultat['email'] === false) {
            header('Location:/contact');
        } else {
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
            $headers .= 'FROM:' . $email . "\r\n";
            $to = 'cauzard.christian@orange.fr';
            $subject = 'Prise de contact';
            $message_content = '
        <table>
        <tr>
        <td><b>Emetteur du message:</b></td>
        </tr>
        <tr>
        <td>Message envoyé par :' . $name . '  ' . $firstName . ' ; ' . $email . ' ; ' . $phone . ' </td>
        </tr>
        <tr>
        <td><b>Contenu du message:</b></td>
        </tr>
        <tr>
        <td>' . $message . '</td>
        </tr>
        </table>
        ';
            mail($to, $subject, $message_content, $headers);
            echo "<html>
      <head>
          <title>Message Envoyé !</title>
      </head>
      <body onLoad=\"javascript:alert('Message Envoyé!');window.location='/contact'\">
      </body>
          </html>";
        }
    }

    //affichage formulaire de connection
    public function connect()
    {
        $articles = $this->articleDao->findAll();
        $events = $this->eventDao->findEvents();
        return $this->twig->render('frontend/connect.html.twig', ['events' => $events, 'articles' => $articles]);
    }
}



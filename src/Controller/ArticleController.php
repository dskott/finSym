<?php
    namespace App\Controller;

    use App\Entity\Expense;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    class ArticleController extends Controller {
        /**
         * @Route("/", name="article_list")
         * @Method({"GET"})
         */
        public function index() {
            $articles = $this->getDoctrine()->getRepository
            (Expense::class)->findAll();
//            $entityManager = $this->getDoctrine()->getManager();
//            for ($i = 0; $i < count($articles); $i+=1){
//                $entityManager->remove($articles[$i]);
//            }
//            $entityManager->flush();
            return $this->render('articles/index.html.twig',
                array ('articles' => $articles));
        }

        /**
         * @Route("/article/{id}", name="article_show")
         */
        public function show($id) {
            $article = $this->getDoctrine()->getRepository
            (Expense::class)->find($id);

            return $this->render('articles/show.html.twig', array('article' => $article));
        }

//        /**
//         * @Route("article/save")
//         */
//        public function save() {
//            $entityManager = $this->getDoctrine()->getManager();
//            $article = new Expense();
//
//            $article->setTitle('Article Two');
//            $article->setBody('This is the body for article two');
//            $entityManager->persist($article);
//            $entityManager->flush();
//
//            return new Response('Saves an article with the id of '.$article->getId());
//        }
    }
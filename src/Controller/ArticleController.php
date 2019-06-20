<?php
    namespace App\Controller;

    use App\Entity\Expense;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;

    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\DateType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;

    use \DateTime;

    class ArticleController extends Controller {
        /**
         * @Route("/", name="expense_list")
         * @Method({"GET"})
         */
        public function index() {
            $expenses = $this->getDoctrine()->getRepository
            (Expense::class)->findAll();
            return $this->render('articles/index.html.twig',
                array ('expenses' => $expenses));
        }

        /**
         * @Route("/expense/new", name="new_expense")
         * @Method({"GET", "POSt"})
         */
        public function new(Request $request) {
            $expense = new Expense();

            $form = $this->createFormBuilder($expense)
                ->add('title', TextType::class, array('attr' =>
                array('class' => 'form-control')))
                ->add('category', TextareaType::class, array(
                    'required' => true, 'attr' => array(
                        'class' => 'form-control')))
                ->add('amount', TextareaType::class, array(
                    'required' => true, 'attr' => array(
                        'class' => 'form-control')))
                ->add('currency', TextareaType::class, array(
                    'required' => true, 'attr' => array(
                        'class' => 'form-control')))
                ->add('date', DateType::class, array(
                    'required' => true, 'attr' => array(
                        'class' => 'form-control')))
                ->add('description', TextareaType::class, array(
                    'required' => false, 'attr' => array(
                        'class' => 'form-control')))
                ->add('save', SubmitType::class, array(
                    'label' => 'Create', 'attr' => array(
                        'class' => 'btn btn-primary mt-3')
                ))
                ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $expense = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($expense);
                $entityManager->flush();

                return $this->redirectToRoute('expense_list');
            }

            return $this->render('articles/new.html.twig', array(
                'form' => $form->createView()
            ));
        }

        /**
         * @Route("/expense/edit/{id}", name="edit_article")
         * @Method({"GET", "POSt"})
         */
        public function edit(Request $request, $id) {
            $article = new Expense();
            $article = $this->getDoctrine()->getRepository
            (Expense::class)->find($id);

            $form = $this->createFormBuilder($article)
                ->add('title', TextType::class, array('attr' =>
                    array('class' => 'form-control')))
                ->add('body', TextareaType::class, array(
                    'required' => false, 'attr' => array(
                        'class' => 'form-control')))
                ->add('save', SubmitType::class, array(
                    'label' => 'Update', 'attr' => array(
                        'class' => 'btn btn-primary mt-3')
                ))
                ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                return $this->redirectToRoute('expense_list');
            }

            return $this->render('articles/edit.html.twig', array(
                'form' => $form->createView()
            ));
        }

        /**
         * @Route("/expense/{id}", name="article_show")
         */
        public function show($id) {
            $expense = $this->getDoctrine()->getRepository
            (Expense::class)->find($id);

            return $this->render('articles/show.html.twig', array('expense' => $expense));
        }

        /**
         * @Route("/expense/delete/{id}")
         * @Method({"DELETE"})
         */
        public function delete(Request $request, $id) {
            $article = $this->getDoctrine()->getRepository
            (Expense::class)->find($id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();

            $response = new Response();
            $response->send();
        }
//        /**
//         * @Route("article/save")
//         */
//        public function save() {
//            $entityManager = $this->getDoctrine()->getManager();
//            $expense = new Expense();
//
//            $expense->setTitle('Expense Two');
//            $expense->setCategory('clothing'); // clothing, entertainment, rent, car, insurance
//            $expense->setAmount(100.25);
//            $expense->setCurrency('Pounds');
//
//            $date = new DateTime();
//            $date->setDate(2010, 5, 20);
//            $expense->setDate($date);
//
//            $expense->setDescription('Bought some blue jeans');
//
//            $entityManager->persist($expense);
//            $entityManager->flush();
//
//            return new Response('Saves an article with the id of '.$expense->getId());
//        }
    }
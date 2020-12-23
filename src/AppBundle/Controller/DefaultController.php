<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\Post;
use AppBundle\Service\MathService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AdminBundle:Post')->findBy([], ['datepublish' => 'DESC'], 3, null);
        return $this->render('default/index.html.twig', [
            'posts' => $posts
        ]);
    }


    /**
     * @Route("/blog", name="blog")
     */
    public function blog()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AdminBundle:Post')->findAll();
        return $this->render('default/blog.html.twig', [
            'posts' => $posts
        ]);
    }

     /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show($id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AdminBundle:Post')->find($id);
        return $this->render('default/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/contact", name="contact_show")
     * @Method({"GET", "POST"})
     */
    public function contact(Request $request, \Swift_Mailer $mailer){
        //creation de formulaire
        $form = $this->createFormBuilder()
                    ->add('from')
                    ->add('subject')
                    ->add('body', TextareaType::class)
                    ->getForm();
            
          $form->handleRequest($request);          
          
         if ($form->isSubmitted()) {
             $data = $form->getData();
             //traitement d envoi de mail
            $message = (new \Swift_Message($data['subject']))
            ->setFrom($data['from'])
            ->setTo('abdel@gmail.com')
            ->setBody($data['body'], 'text\plain');

            $mailer->send($message);
         }           
        return $this->render('default/contact.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/operation", name="operation")
     */
    public function operation(MathService $service)
    {
        return new Response($service->addition(30,40));
    }
   
}

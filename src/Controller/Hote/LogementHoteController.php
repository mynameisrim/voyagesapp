<?php

namespace App\Controller\Hote;

use App\Entity\Logement;
use App\Form\LogementType;
use App\Repository\LogementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


/**
 * @Route("hote/logement")
 */
class LogementHoteController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)//Injecttion de dépendence
    {
       $this->security = $security;
    }
    /**
     * @Route("/", name="logement_index", methods={"GET"})
     */
    public function index(LogementRepository $logementRepository): Response // return type is http response
    {
        //Récuperer l'User authentifier
        $user = $this->security->getUser();
        //Requete pour affficher les logements par user connecter
        $logementsByUser = $logementRepository->findLogementByUser($user);
        
        return $this->render('hote/logement/index.html.twig', [
            'logements' => $logementsByUser,
        ]);
    }

    /**
     * @Route("/new", name="logement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $logement = new Logement();
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //1 récuperer l'user connecté
            $hote = $this->security->getUser();
            $logement->setHote($hote);

            $entityManager->persist($logement);
            $entityManager->flush();

            return $this->redirectToRoute('logement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hote/logement/new.html.twig', [
            'logement' => $logement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="logement_show", methods={"GET"})
     */
    public function show(Logement $logement): Response
    {
        return $this->render('hote/logement/show.html.twig', [
            'logement' => $logement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="logement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Logement $logement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('logement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hote/logement/edit.html.twig', [
            'logement' => $logement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="logement_delete", methods={"POST"})
     */
    public function delete(Request $request, Logement $logement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$logement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($logement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('logement_index', [], Response::HTTP_SEE_OTHER);
    }
}

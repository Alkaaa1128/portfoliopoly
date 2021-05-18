<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\Projets;
use App\Form\ProductType;
use App\Form\ProjetsType;
use App\Repository\ProductRepository;
use App\Repository\ProjetsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminProjetsController extends AbstractController
{
    private $repo;
    private $em;

    public function __construct(ProjetsRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /* ============================================================== */

    /**
     * Index.
     *
     * @Route("/admin", name="admin.projets.index")
     *
     * @return void
     */
    public function index()
    {
        $projets = $this->repo->findAll();
        dump($projets);

        return $this->render('admin/index.html.twig', compact('projets'));
    }

    /* ============================================================== */

    /**
     * Edit.
     *
     * @Route("/admin/projets/{id}", name="admin.projets.edit", methods="GET|POST")
     *
     * @return void
     */
    public function edit(Projets $projets, Request $request)
    {
        $form = $this->createForm(ProjetsType::class, $projets);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($projets);
            $this->em->flush();
            $this->addFlash('success', 'Projet modifié avec succès');

            return $this->redirectToRoute('admin.projets.index');
        }

        return $this->render('admin/edit.html.twig', [
            'projets' => $projets,
            'form' => $form->createView(),
        ]);
    }

    /* ============================================================== */

    /**
     * Create new product.
     *
     * @Route("/admin/create", name="admin.projets.new", methods={"GET|POST"})
     *
     * @return void
     */
    public function new(Request $request)
    {
        $projets = new Projets();
        $form = $this->createForm(ProjetsType::class, $projets);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($projets);
            $this->em->flush();
            $this->addFlash('success', 'Projet créé avec succès');

            return $this->redirectToRoute('admin.projets.index');
        }

        return $this->render('admin/new.html.twig', [
            'projets' => $projets,
            'form' => $form->createView(),
        ]);
    }

    /* ============================================================== */

    /**
     * Delete a product.
     *
     * @Route("/admin/projets/{id}", name="admin.projets.delete", methods="DELETE")
     *
     * @return void
     */
    public function delete(Projets $projets, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$projets->getId(), $request->get('_token'))) {
            $this->em->remove($projets);
            $this->em->flush();
            $this->addFlash('success', 'Projet supprimé avec succès');
        }

        return $this->redirectToRoute('admin.projets.index');
    }
}

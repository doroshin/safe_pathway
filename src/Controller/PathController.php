<?php

namespace App\Controller;

use App\Entity\Path;
use App\Form\PathType;
use App\Repository\PathRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PathController extends AbstractController
{
    #[Route('/path', name: 'main_pathway')]
    public function index(PathRepository $pathRepository): Response
    {
        return $this->render('path/index.html.twig', [
            'pathways' => $pathRepository->findAll(),
            #'controller_name' => 'PathController',
        ]);
    }

    #[Route('view_path/{id}', name: 'view_pathway', methods: ['GET'])]
    public function show(Path $path): Response
    {
        return $this->render('path/view_path.html.twig', [
            'pathway' => $path,
        ]);
    }

    #[Route('path/add_path', name: 'add_pathway', methods: ['GET', 'POST'])]
    public function new(Request $request, PathRepository $pathRepository): Response
    {
        $path = new Path();
        $form = $this->createForm(PathType::class, $path);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $path->setCreatedAt(time());
            $path->setUpdatedAt(0);
            $pathRepository->save($path, true);

            return $this->redirectToRoute('view_pathway', ['id' => $path->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('path/add_path.html.twig', [
            'pathway' => $path,
            'form' => $form,
        ]);
    }

    #[Route('/path/{id}/edit_path   ', name: 'edit_pathway', methods: ['GET', 'POST'])]
    public function edit(Request $request, Path $path, pathRepository $pathRepository): Response
    {
        $form = $this->createForm(PathType::class, $path);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $path->setUpdatedAt(time());
            $pathRepository->save($path, true);

            return $this->redirectToRoute('view_pathway', ['id' => $path->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('path/edit_path.html.twig', [
            'pathway' => $path,
            'form' => $form,
        ]);
    }

    #[Route('/path/{id}   ', name: 'delete_pathway', methods: ['POST'])]
    public function delete(Request $request, Path $path, pathRepository $pathRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$path->getId(), $request->request->get('_token'))) {
            $pathRepository->remove($path, true);
        }

        return $this->redirectToRoute('main_pathway', [], Response::HTTP_SEE_OTHER);
    }
}

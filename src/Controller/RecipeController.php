<?php


namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeTypeForm;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'app_recipe')]
    public function index(RecipeRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $recipes = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        
        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
    }
    
    #[Route('/recipe/nouveau', name: 'recipe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeTypeForm::class, $recipe);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            
            $manager->persist($recipe);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Votre recette a été créée avec succès !'
            );
            
            return $this->redirectToRoute('app_recipe');
        }
        
        return $this->render('pages/recipe/new.html.twig', [
            'form' => $form
        ]);
    }
    
    #[Route('/recipe/edit/{id}', name: 'recipe_edit', methods: ['GET', 'POST'])]
    public function edit(
        Recipe $recipe, 
        Request $request, 
        EntityManagerInterface $manager
    ): Response
    {
        $form = $this->createForm(RecipeTypeForm::class, $recipe);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Votre recette a été modifiée avec succès !'
            );
            
            return $this->redirectToRoute('app_recipe');
        }
        
        return $this->render('pages/recipe/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/recipe/delete/{id}', name: 'recipe_delete', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager,
        Recipe $recipe
    ): Response
    {
        $manager->remove($recipe);
        $manager->flush();

        $this->addFlash(
            'success',
            'La recette a été supprimée avec succès !'
        );

        return $this->redirectToRoute('app_recipe');
    }
}
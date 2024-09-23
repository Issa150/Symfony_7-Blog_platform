<?php 

namespace App\Controller\Backoffice;

use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/backoffice', name: 'app_backoffice_')]
class BackofficeController extends AbstractController{

    private $entityManager;
    private $entityNames;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        $entities = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $this->entityNames = array_map(function ($metadata) {
            $entityName = basename($metadata->getName());
            if (!in_array($entityName, ['Users', 'Admin'])) {
                return $entityName;
            }
            return null; // return null if the entity should be excluded
        }, $entities);
        
        $this->entityNames = array_filter($this->entityNames);
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        // Get a list of all entities (e.g., from a config file or database)
        // $entities = [
        //     // 'User',
        //     'Product',
        //     'Category',
        //     // ...
        // ];
        // $entities = $this->entityManager->getMetadataFactory()->getAllMetadata();
        // $entityNames = array_map(function ($metadata) {
        //     $entityName = basename($metadata->getName());
        //     if (!in_array($entityName, ['Users', 'Admin'])) {
        //         return $entityName;
        //     }
        //     return null; // return null if the entity should be excluded
        // }, $entities);
        
        // $entityNames = array_filter($entityNames);
        
        
        $postsRepository = $this->entityManager->getRepository(Posts::class);
        $posts = $postsRepository->findAll();
        return $this->render('backoffice/index.html.twig', [
            'entities' => $this->entityNames,
            'datas' => $posts,
        ]);

    }
    
    #[Route('/{entity}', name: 'entity_list')]
    public function listEntities(string $entity): Response
    {
        // Get the entity repository
        // $repository = $this->entityManager->getRepository( strtolower($entity));
        // Convert entity name to FQCN
        // $fqcn = 'App\Entity\\' . ucfirst($entity);
        $fqcn = 'App\Entity\\' . $entity;
        // Get the entity repository
        $repository = $this->entityManager->getRepository($fqcn);

        // Get the all datas of each entities
        $entitieDatas = $repository->findAll();

        // Providing posts entity for category and contenttype 
        $postsRepository = $this->entityManager->getRepository(Posts::class);
        $posts = $postsRepository->findAll();
        return $this->render('backoffice/index.html.twig', [
            'entities' => $this->entityNames,
            'datas' => $entitieDatas,
            'entity_name' => $entity,

            'posts' => $posts,
        ]);
    }
    
    // Add more actions for create, edit, delete, etc.
    // using the same approach with the $entity parameter
}
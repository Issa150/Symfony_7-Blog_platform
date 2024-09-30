<?php 

namespace App\Controller\Backoffice;

use App\Entity\Categories;
use App\Entity\ContentType;
use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/backoffice', name: 'backoffice_')]
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
        
        
        
        
        $postsRepository = $this->entityManager->getRepository(Posts::class);
        $posts = count($postsRepository->findAll());
        $categorieRepository = $this->entityManager->getRepository(Categories::class);
        $categories = count($categorieRepository->findAll());
        $contentTypeRepository = $this->entityManager->getRepository(ContentType::class);
        $contenttypes = count($contentTypeRepository->findAll());
        return $this->render('backoffice/index.html.twig', [
            'entities' => $this->entityNames,
            'postTotal' => $posts,
            'contentTypesTotal' => $contenttypes,
            'categoriesTotal' => $categories,
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
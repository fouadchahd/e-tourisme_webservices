<?php

namespace App\Controller;

use App\Entity\TypeOfAttraction;
use App\Repository\TypeOfAttractionRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/type_of_attraction", name="type_of_attraction")
 */
class TypeOfAttractionController extends AbstractController
{

    private $entityManager;
    private $typeOfAttractionRepository;
    public function __construct(EntityManagerInterface $entityManager,TypeOfAttractionRepository $typeOfAttractionRepository)
    {
        $this->entityManager=$entityManager;
        $this->typeOfAttractionRepository=$typeOfAttractionRepository;
    }
    /**
     * @Route("/", name="_read_all",methods={"GET"})
     */
    public function getAllAction(): Response
    {
        $listOfTypes=$this->typeOfAttractionRepository->findGlobalTypes();
        if(empty($listOfTypes)){
            return $this->json(
                    ["status"=>Response::HTTP_NO_CONTENT,"message"=>"empty list found "]
            );
        }else{
            return $this->json(["type_of_attraction" => $listOfTypes,
                "more information"=>
                    ["status"=>Response::HTTP_OK,"message"=>"List of Types available ","itemCount"=>count($listOfTypes),]
            ]);
        }
    }

    /**
     * @Route("/create", name="_create_item",methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createTypeAction(Request $request) :?JsonResponse
    {
        $content=json_decode($request->getContent());
        $typeofAtt=new TypeOfAttraction();
        $typeofAtt->setType($content->type);
        if(empty($content->parentId)){
            $this->entityManager->persist($typeofAtt);
            $this->entityManager->flush();

        }else{
               $parent= $this->typeOfAttractionRepository->find((int)(trim($content->parentId)));
               $parent->addChildrenType($typeofAtt);
               $this->entityManager->persist($typeofAtt);
               $this->entityManager->flush();
        }
        return new JsonResponse(["_self"=>$typeofAtt],Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id<\d+>}", name="_delete_item",methods={"DELETE"})
     * @return JsonResponse
     */
    public function deleteTypesAction(int $id) :?JsonResponse
    {
        try{
            $type= $this->typeOfAttractionRepository->find($id);
            if(empty($type)){
                return new JsonResponse(["ERROR"=>"RESOURCES_NOT_FOUND"],Response::HTTP_NOT_FOUND);
            }
            else{
                $this->entityManager->remove($type);
                $this->entityManager->flush();
                return new JsonResponse(null,Response::HTTP_OK);
            }
        }catch (Exception $ex){
            return new JsonResponse(array("Error"=>$ex->getMessage()),RADIUS_ERROR_CAUSE_RESOURCES_UNAVAILABLE);
        }

    }

    /**
     * @Route("/{id<\d+>}", name="_get_item",methods={"GET"})
     * @return JsonResponse
     */
    public function getOneTypeAction(int $id) :?JsonResponse
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $maxDepthHandler = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return '/type_of_attraction/'.$innerObject->id;
        };
        $defaultContext = [
            AbstractObjectNormalizer::MAX_DEPTH_HANDLER => $maxDepthHandler,
        ];
        $normalizer = new ObjectNormalizer($classMetadataFactory, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer]);
        try{
        $type= $this->typeOfAttractionRepository->find($id);
        $jsontype = $serializer->normalize($type, null, [AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true]);
            if(empty($type)){
            return new JsonResponse(["ERROR"=>"RESOURCES_NOT_FOUND"],Response::HTTP_NOT_FOUND);
        }
        else{
            $response= new JsonResponse(null,Response::HTTP_OK);
            $response->setContent($this->json($jsontype));
            $response->headers->set('Content-Type', 'application/json');
            return  $response;
        }
        }catch (Exception $ex){
            $response= new JsonResponse(null,Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent($this->json(array("ERROR",$ex->getMessage())));
            $response->headers->set('Content-Type', 'application/json');
            return  $response;
        }


    }


}

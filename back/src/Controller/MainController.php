<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpClient\HttpClient;

use App\Entity\Persona;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

use Symfony\Component\Serializer\SerializerAwareTrait;
use Symfony\Component\Serializer\SerializerAwareInterface;

class MainController extends AbstractController{

    /**
    * @Route("/editarPersona", name="editarPersona")
    */
    public function editarPersona(Request $request){

        $data = json_decode($request->getContent());


        $entityManager = $this->getDoctrine()->getManager();

        $persona = $entityManager->getRepository(Persona::class)->find($data->id);
        

        $persona->setNombre($data->nombre);

        $persona->setEdad($data->edad);


        $entityManager->flush();


        return new Response('Persona editada');


    }


    /**
    * @Route("/eliminarPersona", name="eliminarPersona")
    */
    public function eliminarPersona(Request $request){

        $data = json_decode($request->getContent());


        $entityManager = $this->getDoctrine()->getManager();

        $persona = $entityManager->getRepository(Persona::class)->find($data->id);


        $entityManager->remove($persona);
        
        $entityManager->flush();


        return new Response('Persona eliminada');


    }


    /**
    * @Route("/nuevaPersona", name="nuevaPersona")
    */
    public function nuevaPersona(Request $request){

        $data = json_decode($request->getContent());

        $entityManager = $this->getDoctrine()->getManager();


        $persona = new Persona();

        $persona->setNombre($data->nombre);

        $persona->setEdad($data->edad);


        $entityManager->persist($persona);

        $entityManager->flush();


        return new Response('Persona guardada');

    }


    /**
    * @Route("/getPersonas", name="getPersonas")
    */
    public function getPersonas(){

        $personas = $this->getDoctrine()->getRepository(Persona::class)->findAll();

        $arrayPersonas = array();

        foreach($personas as $persona) {
             $arrayPersonas[] = array(
                 'id' => $persona->getId(),
                 'nombre' => $persona->getNombre(),
                 'edad' => $persona->getEdad()
             );
        }

        return new JsonResponse($arrayPersonas);
        
    }


}
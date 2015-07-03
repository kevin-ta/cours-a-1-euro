<?php

namespace Zephyr\CoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ferus\FairPayApi\FairPay;
use Doctrine\ORM\EntityManager;
use Zephyr\CoursBundle\Entity\Cours;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zephyr\CoursBundle\Form\StudentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Template
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->isMethod('POST')){
            $student = $this->getDoctrine()->getRepository('ZephyrCoursBundle:Student')->findOneById($request->request->get('id'));

            if($student === null){
                try{
                    $fairpay = new FairPay();
                    //$fairpay->setCurlParam(CURLOPT_HTTPPROXYTUNNEL, true);
                    //$fairpay->setCurlParam(CURLOPT_PROXY, "proxy.esiee.fr:3128");
                    $data = $fairpay->getStudent($request->request->get('id'));
                }
                catch(ApiErrorException $e){
                    return array(
                        'error' => 'Code cantine incorrect.'
                    );
                }

                $student = new Student();
                $student->setId($data->id);
                $student->setClass($data->class);
                $student->setFirstName($data->first_name);
                $student->setLastName($data->last_name);
                $student->setEmail($data->email);
            }
            else{
            }

            $form = $this->createForm(new StudentType(), $student);
            $form->handleRequest($request);

            if(! $form->isValid())
                return array(
                    'error' => 'Formulaire mal rempli.'
                );

            $this->em->persist($student);
            $this->em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('[Cours à 1 euro] Confirmation de cours')
                ->setFrom(array('bde@edu.esiee.fr' => 'BDE ESIEE Paris'))
                ->setTo(array($student->getEmail() => $student->getFirstName() . ' ' . $student->getLastName()))
                ->setBody(
                    $this->renderView(
                        'ZephyrCoursBundle:Email:confirm.html.twig',
                        array(
                            'name' => $student->getFirstName(),
                            'id' => $student->getId(),
                        )
                    )
                )
            ;
            $this->get('mailer')->send($message);

            return array(
                'success' => 'Infos mis à jour. Check tes mails !'
            );
        }

        return array(
        );
    }

	public function searchAction($query)
    {
        try{
            $fairpay = new FairPay();
            //$fairpay->setCurlParam(CURLOPT_HTTPPROXYTUNNEL, true);
            //$fairpay->setCurlParam(CURLOPT_PROXY, "proxy.esiee.fr:3128");
            $student = $fairpay->getStudent($query);
            $inBdd = $this->getDoctrine()->getRepository('ZephyrCoursBundle:Student')->findAsArray($student->id);

            if($inBdd !== null)
                $student = $inBdd;
        }
        catch(ApiErrorException $e){
            return new Response(json_encode($e->returned_value), $e->returned_value->code);
        }

        return new Response(json_encode($student), 200);
    }
}
<?php

namespace Zephyr\CoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ferus\FairPayApi\FairPay;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zephyr\CoursBundle\Entity\Course;
use Zephyr\CoursBundle\Entity\Student;
use Zephyr\CoursBundle\Form\CourseType;
use Zephyr\CoursBundle\Entity\Subject;
use Zephyr\CoursBundle\Entity\Unit;
use Zephyr\CoursBundle\Entity\Classe;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //Création du form
        $course = new Course();
        $form = $this->createForm('course', $course);

        //Si on a soumis le formulaire
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

            $form->handleRequest($request);

            if(! $form->isValid())
                return $this->render('ZephyrCoursBundle:Default:success.html.twig', array(
                    'error' => 'Le formulaire est mal rempli.'
                ));

            $course_exist = $this->getDoctrine()->getRepository('ZephyrCoursBundle:Course')->findBy(array(
                'subject' => $form->get('subject')->getData()->__toString(),
                'unit' => $form->get('unit')->getData()->__toString(),
                'date' => $form->get('date')->getData()
                ));

            if($course_exist != null)
            {
                return $this->render('ZephyrCoursBundle:Default:success.html.twig', array(
                'error' => "Ce cours existe déjà."
                ));
            }

            if (strcmp($form->get('date')->getData()->format('Y/m/d h:i'), date('Y/m/d h:i')) < 0)
            {
                return $this->render('ZephyrCoursBundle:Default:success.html.twig', array(
                    'error' => "La date indiquée est inférieure à la date d'aujourd'hui."
                ));
            }

            if ($this->getRequest()->request->get('submit') == 'prof')
            {
                $course->setProf($student);
                $em->persist($course);
                $em->flush();

                return $this->render('ZephyrCoursBundle:Default:success.html.twig', array(
                'success' => 'Votre demande de cours a été enregistrée.'
                ));
            }
            elseif ($this->getRequest()->request->get('submit') == 'eleve')
            {
                $course->addStudent($student);
                $em->persist($course);
                $em->flush();

                return $this->render('ZephyrCoursBundle:Default:success.html.twig', array(
                    'success' => 'Votre demande de cours a été enregistrée.'
                ));
            }
        }

        return $this->render('ZephyrCoursBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function mycourseAction(Request $request)
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
                        'error' => 'Le code cantine est incorrect.'
                    );
                }

                $student = new Student();
                $student->setId($data->id);
                $student->setClass($data->class);
                $student->setFirstName($data->first_name);
                $student->setLastName($data->last_name);
                $student->setEmail($data->email);
            }

            $prof = $em->getRepository('ZephyrCoursBundle:Course')->findByProf($student->__toString());
            $eleve = $student->getCourses();

            return $this->render('ZephyrCoursBundle:Default:mycourses.html.twig', array(
                'prof' => $prof,
                'eleve' => $eleve
                ));
        }

        return $this->render('ZephyrCoursBundle:Default:mycourse.html.twig');
    }

    public function listcourseAction()
    {
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository('ZephyrCoursBundle:Course')->findAllOrdered();

        return $this->render('ZephyrCoursBundle:Default:listcourse.html.twig', array('courses' => $courses, 
            ));
    }

    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository('ZephyrCoursBundle:Course')->findAllOrdered();

        return $this->render('ZephyrCoursBundle:Default:admin.html.twig', array('courses' => $courses)
            );
    }

    public function showAction(Course $course)
    {
        $students = $course->getStudents();
        return $this->render('ZephyrCoursBundle:Default:show.html.twig', array(
            'students' => $students,
            'course' => $course
            ));
    }

    public function addstudentAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('ZephyrCoursBundle:Course')->find($id);

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
                        'error' => 'Le code cantine est incorrect.'
                    );
                }

                $student = new Student();
                $student->setId($data->id);
                $student->setClass($data->class);
                $student->setFirstName($data->first_name);
                $student->setLastName($data->last_name);
                $student->setEmail($data->email);
            }

            if($student->__toString() == $course->getProf()){
                return $this->render('ZephyrCoursBundle:Default:success.html.twig', array(
                    'error' => 'Vous ne pouvez pas être élève de votre propre cours.'
                ));
            }

            $course->addStudent($student);
            $em->persist($course);
            $em->flush();

            return $this->render('ZephyrCoursBundle:Default:success.html.twig', array(
                    'success' => "Vous avez été ajouté au cours en tant qu'élève"
                ));
        }

        return $this->render('ZephyrCoursBundle:Default:addstudent.html.twig', array('course' => $course));
    }

    public function addprofAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('ZephyrCoursBundle:Course')->find($id);

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
                        'error' => 'Le code cantine est incorrect.'
                    );
                }

                $student = new Student();
                $student->setId($data->id);
                $student->setClass($data->class);
                $student->setFirstName($data->first_name);
                $student->setLastName($data->last_name);
                $student->setEmail($data->email);
            }

            if($student->__toString() == $course->getProf()){
                return $this->render('ZephyrCoursBundle:Default:success.html.twig', array(
                    'error' => 'Vous ne pouvez pas être le prof du cours si vous êtes déjà un élève.'
                ));
            }

            $course->setProf($student);
            $em->persist($course);
            $em->flush();

            return $this->render('ZephyrCoursBundle:Default:success.html.twig', array(
                    'success' => "Vous avez été ajouté au cours en tant que prof."
                ));
        }

        return $this->render('ZephyrCoursBundle:Default:addprof.html.twig', array('course' => $course));
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
<?php

namespace App\Controller;

use App\Entity\Student;

use App\Form\AddStudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    /**
     *@Route("/student", name="student")
     */
    public function index(): Response
    {
        return $this->render('student/student_details.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    /**
     *@Route("/student/student_list" , name= "student_list")
     */
    public function listStudent(StudentRepository $repo): Response
    {
        $students = $repo->findAll();

        return $this->render('student/student_list.html.twig', [
            'students' => $students
        ]);
    }

    /**
     *@Route("/student/student_add", name = "student_add")
     *@route("/student/{id}/student_edit", name ="student_edit")
     */
    public function addStudent(Student $student = null, Request $request, ManagerRegistry $manager): Response
    {
        if (!$student) {
            $student = new Student;
        }

        $form = $this->createForm(AddStudentType::class, $student);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->getManager()->persist($student);
            $manager->getManager()->flush();
            return $this->redirectToRoute('student_details', ['id' => $student->getId()]);
        }
        return $this->render('student/student_add.html.twig', [
            'formStudent' => $form->createView()
        ]);
    }

    /**
     *@Route("/student/{id}/student_details", name = "student_details")
     */
    public function detailsStudents(Student $student): Response
    {
        return $this->render('student/student_details.html.twig', [
            'student' => $student
        ]);
    }
}

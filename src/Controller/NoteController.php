<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\Note;
use App\Form\MatiereType;
use App\Form\NoteType;
use App\Repository\NiveauRepository;
use App\Repository\FiliereRepository;
use App\Repository\MatiereRepository;
use App\Repository\NoteRepository;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NoteController extends AbstractController
{

    /**
     *@Route("/class", name="class")
     *@Route("/class/{id_filiere}/classP", name="classP")
     *@Route("/class/{id_niveau}/classS", name="classS")
     */
    public function index(FiliereRepository $repo, NiveauRepository $repoN, int $id_filiere = 1, int $id_niveau = 1): Response
    {
        $filieres = $repo->findAll();
        $filiere = $repo->find($id_filiere);
        $niveaus = $filiere->getNiveaux();
        $niveau = $repoN->find($id_niveau);
        $students = $niveau->getStudents();

        return $this->render('note/index.html.twig', [
            'filieres' => $filieres,
            'niveaus' => $niveaus,
            'students' => $students
        ]);
    }


    /**
     * @Route("/matiere/liste", name= "matiere_liste")
     */
    public function listeMatiere(MatiereRepository $repo): Response
    {
        $matieres = $repo->findAll();
        return $this->render('note/list.html.twig', [
            'matieres' => $matieres
        ]);
    }

    /**
     * @Route("/matiere", name ="add_matiere")
     * @Route("/matiere/{id_filiere}/matiereF", name="matiereF")
     * @Route("/matiere/{id_niveau}/matiereN", name="matiereN")
     */
    public function addMatiere(FiliereRepository $repo, NiveauRepository $repoN, Request $request, ManagerRegistry $manager, int $id_filiere = 1, int $id_niveau = 1): Response
    {
        $matiere = new Matiere;
        $form = $this->createForm(MatiereType::class, $matiere);
        $filieres = $repo->findAll();
        $filiere = $repo->find($id_filiere);
        $niveaus = $filiere->getNiveaux();
        $niveau = $repoN->find($id_niveau);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $niveaux = $niveau->getNiveau();
            // $matiere->setNiveau($niveaux);
            $manager->getManager()->persist($matiere);
            $manager->getManager()->flush();
        }


        return $this->render('note/add_matiere.html.twig', [
            'form' => $form->createView(),
            'filieres' => $filieres,
            'niveaus' => $niveaus,
        ]);
    }



    /**
     * @Route("/note/{id}/note_add", name="note_add")
     */
    public function note_add(StudentRepository $repo, NiveauRepository $niveauRepository, int $id): Response
    {
        $student = $repo->find($id);
        $niveau = $student->getNiveau();
        $niveaux = $niveauRepository->find($niveau);
        $matieres = $niveaux->getMatiere();
        return $this->render('note/note_add.html.twig', [
            'student' => $student,
            'matieres' => $matieres
        ]);
    }

    /**
     * @Route("/note/injection" , name="injection")
     */
    public function injection(Request $request): Response
    {
        dd($request);

        return $this->render('note/injection.html.twig');
    }


    /**
     * @Route("/note/{id}/noteShow", name="noteShow")
     */
    public function noteShow(NoteRepository $noteRepository, StudentRepository $repo, NiveauRepository $niveauRepository, int $id): Response
    {
        $student = $repo->find($id);
        $niveau = $student->getNiveau();
        $niveaux = $niveauRepository->find($niveau);
        $matieres = $niveaux->getMatiere();

        $notes = $noteRepository->findBy(['Student' => $id]);



        $totalNote = 0;
        $moyenneGenerale = 0;
        foreach ($notes as $item) {
            $totalN = ($item->getPartielle() + $item->getFinal());
            $totalNote += $totalN;

            $moyenneGenerale = $totalNote / 20;
        }


        return $this->render('note/note_Show.html.twig', [
            'student' => $student,
            'matieres' => $matieres,
            'notes' => $notes,
            'total' => $totalNote,
            'moyen' => $moyenneGenerale
        ]);
    }
}

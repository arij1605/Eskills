<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Users;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiqueController extends AbstractController
{
    /**
     * @Route("/statistique", name="statistique")
     */
    public function index(): Response
    {

        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $notes = $em->getRepository(Note::class)->findAll();
      //  $examen = $em->getRepository(Examen::class)->findBy(array(), array('Module'=>'asc'));
        $totalenote=0;
        
        foreach ($notes as $note) {
            $totalenote = $totalenote + $note->getNote();
        }
        $data = array();
        $stat = ['note', 'note'];
        $nb = 0;
        array_push($data, $stat);
        foreach ($notes as $note) {
            $stat = array();
            array_push($stat, $note->getIdExamen()->getModule(), (($note->getNote()) * 100) / $totalenote);
            $nb = ($note->getNote() * 100) / $totalenote;
            $stat = [$note->getIdExamen()->getModule(), $nb];
            array_push($data, $stat);
        }
        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des Moyenn par Module');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        return $this->render('statistique/index.html.twig', array('piechart' =>
            $pieChart));
    }

}

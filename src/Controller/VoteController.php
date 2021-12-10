<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Users;
use App\Entity\Vote;
use App\Form\VoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vote")
 */
class VoteController extends AbstractController
{

    /**
     * @Route("like/{id}", name="like_vote", methods={"GET","POST"})
     */
    public function like(Request $request,$id)
    {
        // $count = $this->count($id);
        $em = $this->getDoctrine()->getManager();
        $vote = new Vote();
        $comment = $em->getRepository(Commentaire::class)->find($id);
        $user = $em->getRepository(Users::class)->find($this->getUser());
        $votepre = $em->getRepository(Vote::class)->findOneBy(array("idComment" => $comment->getId(), 'idUser' => $user->getId()));
        if ($votepre != null) {
            $vote->setIdUser($user);
            $vote->setIdComment($comment);
            $vote->setType(1);
            $em->remove($votepre);
            $em->persist($vote);
            $em->flush();
        } else{
            $vote->setIdUser($user);
            $vote->setIdComment($comment);
            $vote->setType(1);

            $em->persist($vote);
            $em->flush();

        }
        return $this->redirectToRoute('evenement_byId', ['id' => $comment->getIdEvenement()->getIdEvent()]);
    }

    /**
     * @Route("deslike/{id}", name="deslike_vote", methods={"GET","POST"})
     */
    public function deslike(Request $request , $id)
    {

        $em = $this->getDoctrine()->getManager();
        $vote = new Vote();
        $comment = $em->getRepository(Commentaire::class)->find($id);
        $user  = $em->getRepository(Users::class)->find($this->getUser());

        $votepre = $em->getRepository(Vote::class)->findOneBy(array("idComment" => $comment->getId(), 'idUser' => $user->getId()));
        if ($votepre != null) {
            $vote->setIdUser($user);
            $vote->setIdComment($comment);
            $vote->setType(2);
            $em->remove($votepre);
            $em->persist($vote);
            $em->flush();
        } else{
            $vote->setIdUser($user);
            $vote->setIdComment($comment);
            $vote->setType(2);

            $em->persist($vote);
            $em->flush();

        }
        return $this->redirectToRoute('evenement_byId', ['id' => $comment->getIdEvenement()->getIdEvent()]);

    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use App\Classes\NumberManager;

class NumberController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function showForm(Request $request, NumberManager $numberManager)
    {
        $form = $this->createFormBuilder();
        for($number = 1; $number <= 10; $number++)
            $form = $form->add('testCase' . $number , IntegerType::class, ['required' => false, 'attr' => ['class' => 'form-control', 'min' => 1, 'max' => 99999, 'placeholder' => "Test case " . $number], 'label' => false]);
        $form = $form->add('save', SubmitType::class, ['label' => 'Count number', 'attr' => ['class' => 'btn btn-success form-control']])
        ->getForm();

        $form->handleRequest($request);
        $result = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $result = $numberManager->getMaxValues($formData);
        }

       return $this->render('home/showForm.html.twig', [
            'form' => $form->createView(),
            'result' => $result
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\CartType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product')]
    public function index(Request $request): Response
    {
        $product = new Product();
        $product->setName('Premium Wireless Headphones');
        $product->setPrice(129.99);
        $product->setDescription('Experience superior sound quality with our premium wireless headphones. Features active noise cancellation, 30-hour battery life, and premium comfort padding.');
        $product->setBrand('AudioTech');
        $product->setColor('Matte Black');
        $product->setConnectivity('Bluetooth 5.0');
        $product->setBatteryLife('30 hours');
        $product->setImageUrl('https://images.pexels.com/photos/90946/pexels-photo-90946.jpeg?auto=compress&cs=tinysrgb&w=800');

        $form = $this->createForm(CartType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->addFlash('success', sprintf(
                'Added %d item(s) in %s color to cart!',
                $data['quantity'],
                $data['color']
            ));

            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/index.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    // #[Route('/cart', name: 'app_cart', methods: ['POST'])]
    // public function addToCart(Request $request): Response
    // {
    //     return $this->redirectToRoute('app_product');
    // }
}

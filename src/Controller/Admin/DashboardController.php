<?php

namespace App\Controller\Admin;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_admin_dashboard')]
    public function index(
        UserRepository $userRepository,
        ProductRepository $productRepository,
        OrderRepository $orderRepository,
        ReservationRepository $reservationRepository
    ): Response {
        $stats = [
            'total_users' => count($userRepository->findAll()),
            'total_products' => count($productRepository->findAll()),
            'total_orders' => count($orderRepository->findAll()),
            'pending_orders' => count($orderRepository->findByStatus('pending')),
            'total_reservations' => count($reservationRepository->findAll()),
            'upcoming_reservations' => count($reservationRepository->findUpcomingReservations()),
        ];

        return $this->render('admin/dashboard.html.twig', [
            'stats' => $stats,
        ]);
    }
}


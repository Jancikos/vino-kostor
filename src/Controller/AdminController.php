<?php

namespace App\Controller;

use App\Utils\Controller\BaseController;
use App\Utils\Datafeed\ChartRevenue;
use App\Utils\Datafeed\ChartUnpackedProducts;
use App\Utils\Datafeed\Params\ChartRevenueParams;
use App\Utils\Datafeed\Params\ChartUnpackedProductsParams;
use App\Utils\JsonResponse\FlashMessageType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends BaseController
{
    // nastavenia admin templatu
    protected bool $showBreadcrumbs = true;
    protected bool $showSidebar = true;
    protected bool $showHeader = true;
    protected bool $centerBody = false;

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {
        $this->addBreadcrumb('Dashboard', 'admin_index');

        return $this->renderAdminPage(
            'Admin dashboard',
            'dashboard',
            [
                'controller_name' => 'MainController',
            ]
        );
    }

    /** 
     * @Route("/chart/revenue", name="chart_revenue")
     */
    public function chartRevenue(Request $request): Response
    {
        $chartRevenueParams = new ChartRevenueParams();
        
        $dfChartRevenue = new ChartRevenue();
        return new JsonResponse(
            $dfChartRevenue->getData($chartRevenueParams)
        );
    }
    
    /** 
     * @Route("/chart/unpackedProducts", name="chart_unpackedProducts")
     */
    public function chartUnpackedProducts(Request $request): Response
    {
        $chartUnpackedProductsParams = new ChartUnpackedProductsParams();
        
        return $this->render(
            'admin/charts/chart_unpackedproducts.html.twig', [
                "params" => $chartUnpackedProductsParams
            ]
        );
    }
    
    /** 
     * @Route("/chart/unpackedProductsData", name="chart_unpackedProducts_data")
     */
    public function chartUnpackedProductsData(Request $request): Response
    {
        $chartUnpackedProductsParams = new ChartUnpackedProductsParams();
        
        $dfChartUnpackedProducts = new ChartUnpackedProducts();
        return new JsonResponse(
            $dfChartUnpackedProducts->getData($chartUnpackedProductsParams)
        );
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $this->addFlash(FlashMessageType::SUCCESS, 'Už ste prihlásený.');
            return $this->redirectToRoute('admin_index');
        }

        $this->addBreadcrumb('Login', 'admin_login');
        $this->showHeader = false;
        $this->showSidebar = false;
        $this->centerBody = true;

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error) {
            $this->addFlash(FlashMessageType::DANGER, $error->getMessage());   
        }

        return $this->renderAdminPage(
            'Prihlásenie',
            'login'
        );
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {
        // controller can be blank: it will never be called!
    }


    /**
     * @param string $title citatelna nazev stranky
     * @param string $page nazov twigu, musi byt v adresari templates/admin/pages a mat strukturu `admin_$page.html.twig`
     * @param array $params parametre nasledne pre twig
     * @return Response
     */
    protected function renderAdminPage(string $title, string $page, array $params = []): Response
    {
        return $this->render("admin/pages/admin_$page.html.twig", [
            'user' => $this->getUser(),
            'isSuperAdmin' => $this->isSuperAdmin(),
            'title' => $title,
            'showBreadcrumbs' => $this->showBreadcrumbs,
            'breadcrumbs' => $this->getBreadcrumbs(),
            'showSidebar' => $this->showSidebar,
            'showHeader' => $this->showHeader,
            'centerBody' => $this->centerBody,
        ] + $params);
    }
}

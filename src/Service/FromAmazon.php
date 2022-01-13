<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FromAmazon
{
    private string $amazonDomain;
    private int $nbOfProduct;
    private ParameterBagInterface $parameterBag;
    private EntityManagerInterface $entityManager;
    private PartnerRepository $partnerRepository;
    private CategoryRepository $categoryRepository;
    private Slugify $slugify;
    private const KEYWORDS = [
        'Bureau',
        'Table',
        // 'Etagère',
        // 'Fauteuil',
        // 'Canapé'
    ];

    public function __construct(
        EntityManagerInterface $entityManager,
        PartnerRepository $partnerRepository,
        CategoryRepository $categoryRepository,
        Slugify $slugify,
        ParameterBagInterface $parameterBag
    ) {
        $this->amazonDomain = 'amazon.fr';
        $this->partnerRepository = $partnerRepository;
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $entityManager;
        $this->slugify = $slugify;
        $this->nbOfProduct = 4;
        $this->parameterBag = $parameterBag;
    }

    public function main(): void
    {
        $product = $this->fetchAmazonInformation();
        $this->fetchAllProduct($product);
    }

    // Get categories with the foreach.
    public function fetchAmazonInformation(): array
    {
        $products = [];
        $apiResult = '';
        foreach (self::KEYWORDS as $value) {
            $queryString = http_build_query([
                'api_key' => $this->parameterBag->get('RAINFOREST_KEY'),
                'type' => 'search',
                'amazon_domain' => $this->amazonDomain,
                'search_term' => [$value]
            ]);
            echo ("\n========================\n");
            echo ("You search for : $value");
            echo ("\n========================\n");
            # make the http GET request to Rainforest API
            $curlHandle = curl_init(sprintf('%s?%s', 'https://api.rainforestapi.com/request', $queryString));
            if ($curlHandle == true) {
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, true);
                $apiResult = curl_exec($curlHandle);
                curl_close($curlHandle);
            }
            if (!is_string($apiResult)) {
                return [];
            }
            # print the JSON response from Rainforest API
            $amazonData = json_decode($apiResult, true);
            if (!is_array($amazonData)) {
                return [];
            }
            for ($i = 0; $i < $this->nbOfProduct; $i++) {
                try {
                    $asin = $amazonData["search_results"][$i]["asin"];
                    $price = $amazonData['search_results'][$i]['price']['value'];
                    $priceCurrency = $amazonData['search_results'][$i]['price']['symbol'];
                    $product = new Product();
                    echo ("\nProduct n° $i \n");
                    dump($asin, $price, $priceCurrency);
                    $product->setAsin(strval($asin));
                    $product->setPrice(floatval($price));
                    $product->setPriceCurrency($priceCurrency);
                    $product->setCategory($this->categoryRepository->findOneBy(['name' => $value]));
                    $products[] = $product;
                    echo ("\n==============================================================\n");
                    echo ("You have the asin, price and the symbol for product $asin");
                    echo ("\n==============================================================\n");
                } catch (Exception $exception) {
                    echo ("There are no product about this ASIN");
                    continue;
                }
            }
        }
        echo ("\n==============================================================\n");
        echo ("\n==============================================================\n");
        echo ("\n==============================================================\n");
        return $products;
    }

    // -- Fetch all product with the Asin(ID) from amazon.
    public function fetchAllProduct(array $products): void
    {
        if (empty($products)) {
            return;
        }
        $informations = [];
        $apiResult = '';
        foreach ($products as $product) {
            $queryString = http_build_query([
                'api_key' => $this->parameterBag->get('RAINFOREST_KEY'),
                'type' => 'product',
                'category_id' => '2818684031',
                'amazon_domain' => $this->amazonDomain,
                'asin' => $product->getAsin()
            ]);
            # make the http GET request to Rainforest API
            $curlHandle = curl_init(sprintf('%s?%s', 'https://api.rainforestapi.com/request', $queryString));
            if ($curlHandle == true) {
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, true);
                $apiResult = curl_exec($curlHandle);
                curl_close($curlHandle);
            }
            if (!is_string($apiResult)) {
                return;
            }
            # print the JSON response from Rainforest API
            $amazonData = (json_decode($apiResult, true));
            if (!is_array($amazonData)) {
                return;
            }
            $informations = $amazonData['product'];
            if (!is_array($informations)) {
                return;
            }
            if (!isset($informations['dimensions'])) {
                echo ("There are no dimensions for this product \n");
                continue;
            }
            $dimensions = $informations['dimensions'];
            echo ("The dimensions is : $dimensions \n");
            $height = intval(substr($dimensions, 0, 3));
            $width = intval(substr($dimensions, 5, 3));
            $depth = intval(substr($dimensions, 10, 3));
            $product->setName(strval($informations['title']));
            $product->setPicture(strval($informations['main_image']['link']));
            $product->setUrl(strval($informations['link']));
            $slug = $this->slugify->generate($product->getName());
            $product->setSlug($slug);
            $product->setHeight($height);
            $product->setWidth($width);
            $product->setDepth($depth);
            $product->setPartner($this->partnerRepository->findOneBy(['name' => 'Amazon']));
            $product->setPartnerProductId(uniqid());
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        }
    }
}

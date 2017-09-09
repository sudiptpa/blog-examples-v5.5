<?php

namespace App\Http\Controllers;

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Enums;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;

/**
 * Class EbayController
 * @package App\Http\Controllers
 */
class EbayController extends Controller
{
    /**
     * @var mixed
     */
    public $service;

    public function __construct()
    {
        $this->service = new Services\TradingService([
            'credentials' => config('ebay.sandbox.credentials'),
            'apiVersion' => '903',
            'sandbox' => true,
            'siteId' => Constants\SiteIds::US,

        ]);
    }

    public function publish()
    {
        $item = $this->buildItem();

        if ($this->verifyItem($item)) {
            $this->addItem($item);
        }
    }

    /**
     * @return mixed
     */
    public function buildItem()
    {
        /**
         * Begin creating the fixed price item.
         */
        $item = new Types\ItemType();

        /**
         * We want a multiple quantity fixed price listing.
         */
        $item->ListingType = Enums\ListingTypeCodeType::C_FIXED_PRICE_ITEM;
        $item->Quantity = 99;

        /**
         * Let the listing be automatically renewed every 30 days until cancelled.
         */
        $item->ListingDuration = Enums\ListingDurationCodeType::C_GTC;

        /**
         * The cost of the item is $19.99.
         * Note that we don't have to specify a currency as eBay will use the site id
         * that we provided earlier to determine that it will be United States Dollars (USD).
         */
        $item->StartPrice = new Types\AmountType(['value' => 19.99]);

        /**
         * Allow buyers to submit a best offer.
         */
        $item->BestOfferDetails = new Types\BestOfferDetailsType();
        $item->BestOfferDetails->BestOfferEnabled = true;

        /**
         * Automatically accept best offers of $17.99 and decline offers lower than $15.99.
         */
        $item->ListingDetails = new Types\ListingDetailsType();
        $item->ListingDetails->BestOfferAutoAcceptPrice = new Types\AmountType(['value' => 17.99]);
        $item->ListingDetails->MinimumBestOfferPrice = new Types\AmountType(['value' => 15.99]);

        /**
         * Provide a title and description and other information such as the item's location.
         * Note that any HTML in the title or description must be converted to HTML entities.
         */
        $item->Title = 'Water Pump & Housing 41011 Mazda Tribute MPV & Ford Escape 3.0 V6 00/01/02/03 099gg';
        $item->Description = 'Gates Water Pump and Housing to suit 3.0 V6 Mazda Tribute / MPV 2000-2003. ***If your vehicle is a 2003 model please pay particular attention to the pipe sizes*** This Pump features a complete housing with hose sizes of approx. 38mm / 32mm / 19mm. Dont waste your time in just replacing the water pump itself when you may need a new housing as well. A quality Gates product brought to you by TLC Automotive Parts.';
        $item->SKU = 'ABC-004';
        $item->Country = 'US';
        $item->Location = 'Beverly Hills';
        $item->PostalCode = '90210';
        /**
         * This is a required field.
         */
        $item->Currency = 'USD';

        /**
         * Display a picture with the item.
         */
        $item->PictureDetails = new Types\PictureDetailsType();
        $item->PictureDetails->GalleryType = Enums\GalleryTypeCodeType::C_GALLERY;
        $item->PictureDetails->PictureURL = ['http://lorempixel.com/1500/1024/abstract'];

        /**
         * List item in the Books > Audiobooks (29792) category.
         */
        $item->PrimaryCategory = new Types\CategoryType();
        $item->PrimaryCategory->CategoryID = '29792';

        /**
         * Tell buyers what condition the item is in.
         * For the category that we are listing in the value of 1000 is for Brand New.
         */
        $item->ConditionID = 1000;

        /**
         * Buyers can use one of two payment methods when purchasing the item.
         * Visa / Master Card
         * PayPal
         * The item will be dispatched within 1 business days once payment has cleared.
         * Note that you have to provide the PayPal account that the seller will use.
         * This is because a seller may have more than one PayPal account.
         */
        $item->PaymentMethods = [
            'VisaMC',
            'PayPal',
        ];
        $item->PayPalEmailAddress = 'developer@foxdigital.co.in';
        $item->DispatchTimeMax = 1;

        /**
         * Setting up the shipping details.
         * We will use a Flat shipping rate for both domestic and international.
         */
        $item->ShippingDetails = new Types\ShippingDetailsType();
        $item->ShippingDetails->ShippingType = Enums\ShippingTypeCodeType::C_FLAT;

        /**
         * Create our first domestic shipping option.
         * Offer the Economy Shipping (1-10 business days) service at $2.00 for the first item.
         * Additional items will be shipped at $1.00.
         */
        $shippingService = new Types\ShippingServiceOptionsType();
        $shippingService->ShippingServicePriority = 1;
        $shippingService->ShippingService = 'Other';
        $shippingService->ShippingServiceCost = new Types\AmountType(['value' => 2.00]);
        $shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 1.00]);
        $item->ShippingDetails->ShippingServiceOptions[] = $shippingService;

        /**
         * Create our second domestic shipping option.
         * Offer the USPS Parcel Select (2-9 business days) at $3.00 for the first item.
         * Additional items will be shipped at $2.00.
         */
        $shippingService = new Types\ShippingServiceOptionsType();
        $shippingService->ShippingServicePriority = 2;
        $shippingService->ShippingService = 'USPSParcel';
        $shippingService->ShippingServiceCost = new Types\AmountType(['value' => 3.00]);
        $shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 2.00]);
        $item->ShippingDetails->ShippingServiceOptions[] = $shippingService;

        /**
         * Create our first international shipping option.
         * Offer the USPS First Class Mail International service at $4.00 for the first item.
         * Additional items will be shipped at $3.00.
         * The item can be shipped Worldwide with this service.
         */
        $shippingService = new Types\InternationalShippingServiceOptionsType();
        $shippingService->ShippingServicePriority = 1;
        $shippingService->ShippingService = 'USPSFirstClassMailInternational';
        $shippingService->ShippingServiceCost = new Types\AmountType(['value' => 4.00]);
        $shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 3.00]);
        $shippingService->ShipToLocation = ['WorldWide'];
        $item->ShippingDetails->InternationalShippingServiceOption[] = $shippingService;

        /**
         * Create our second international shipping option.
         * Offer the USPS Priority Mail International (6-10 business days) service at $5.00 for the first item.
         * Additional items will be shipped at $4.00.
         * The item will only be shipped to the following locations with this service.
         * N. and S. America
         * Canada
         * Australia
         * Europe
         * Japan
         */
        $shippingService = new Types\InternationalShippingServiceOptionsType();
        $shippingService->ShippingServicePriority = 2;
        $shippingService->ShippingService = 'USPSPriorityMailInternational';
        $shippingService->ShippingServiceCost = new Types\AmountType(['value' => 5.00]);
        $shippingService->ShippingServiceAdditionalCost = new Types\AmountType(['value' => 4.00]);
        $shippingService->ShipToLocation = [
            'Americas',
            'CA',
            'AU',
            'Europe',
            'JP',
        ];
        $item->ShippingDetails->InternationalShippingServiceOption[] = $shippingService;

        /**
         * The return policy.
         * Returns are accepted.
         * A refund will be given as money back.
         * The buyer will have 14 days in which to contact the seller after receiving the item.
         * The buyer will pay the return shipping cost.
         */
        $item->ReturnPolicy = new Types\ReturnPolicyType();
        $item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsAccepted';
        $item->ReturnPolicy->RefundOption = 'MoneyBack';
        $item->ReturnPolicy->ReturnsWithinOption = 'Days_14';
        $item->ReturnPolicy->ShippingCostPaidByOption = 'Buyer';

        return $item;
    }

    /**
     * Sends the passed item to eBay for verification.
     */
    public function verifyItem($item)
    {
        $request = new Types\VerifyAddFixedPriceItemRequestType();

        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = config('ebay.sandbox.userToken');

        $request->Item = $item;

        $response = $this->service->verifyAddFixedPriceItem($request);

        if (isset($response->Errors)) {
            foreach ($response->Errors as $error) {
                printf(
                    "%s: %s\n%s\n\n",
                    $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                    $error->ShortMessage,
                    $error->LongMessage
                );
            }
        }

        $verified = $response->Ack !== 'Failure';

        if ($verified) {
            print("This item was verified.\n");
        } else {
            print("This item was not verified.\n");
        }

        return $verified;
    }

    /**
     * @param $item
     */
    public function addItem($item)
    {
        $request = new Types\AddFixedPriceItemRequestType();

        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = config('ebay.sandbox.userToken');

        $request->Item = $item;

        $response = $this->service->addFixedPriceItem($request);

        if (isset($response->Errors)) {
            foreach ($response->Errors as $error) {
                printf(
                    "%s: %s\n%s\n\n",
                    $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                    $error->ShortMessage,
                    $error->LongMessage
                );
            }
        }

        if ($response->Ack !== 'Failure') {
            printf(
                "The item was listed to the eBay Sandbox with the Item number http://cgi.sandbox.ebay.com.au/itm/%s\n",
                $response->ItemID
            );
        }
    }
}

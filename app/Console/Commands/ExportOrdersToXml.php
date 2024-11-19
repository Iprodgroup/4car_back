<?php

namespace App\Console\Commands;

use SimpleXMLElement;
use App\Models\Product\Order;
use Illuminate\Console\Command;

class ExportOrdersToXml extends Command
{
    protected $signature = 'orders:export-xml';
    protected $description = 'Export orders to XML file';

    public function handle()
    {
        $oldFilePath = storage_path('app/ftp/orders.xml');
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $orders = Order::all();
        $xml = new SimpleXMLElement('<shop/>');

        $ordersNode = $xml->addChild('orders');
        foreach ($orders as $order) {
            $orderNode = $ordersNode->addChild('order');
            $orderNode->addAttribute('OrderId', htmlspecialchars($order->id, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('ClientName', htmlspecialchars($order->name, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('CustomerId', htmlspecialchars($order->user_id, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('number', htmlspecialchars($order->number, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('city', htmlspecialchars($order->city, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('district', htmlspecialchars($order->district, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('delivery_method', htmlspecialchars($order->delivery_method, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('town', htmlspecialchars($order->town, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('adres', htmlspecialchars($order->adres, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('orient', htmlspecialchars($order->orient, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('work_adres', htmlspecialchars($order->work_adres, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('phone', htmlspecialchars($order->phone, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('comment', htmlspecialchars($order->comment, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('coupon', htmlspecialchars($order->coupon, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('payment_method', htmlspecialchars($order->payment_method, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('sum', $order->sum);
            $statusText = $this->getOrderStatusText($order->status_id);
            $orderNode->addChild('status_id', htmlspecialchars($statusText, ENT_XML1, 'UTF-8'));

            $productsNode = $orderNode->addChild('products');
            $products = json_decode($order->products, true);

            if (is_array($products)) {
                foreach ($products as $product) {
                    $productNode = $productsNode->addChild('product');

                    $productNode->addChild('id', htmlspecialchars($product['id'] ?? '', ENT_XML1, 'UTF-8'));
                    $productNode->addChild('name', htmlspecialchars($product['name'] ?? '', ENT_XML1, 'UTF-8'));
                    $productNode->addChild('slug', htmlspecialchars($product['slug'] ?? '', ENT_XML1, 'UTF-8'));
                    $productNode->addChild('brand', htmlspecialchars($product['brand'] ?? '', ENT_XML1, 'UTF-8'));
                    $productNode->addChild('image', htmlspecialchars($product['image'] ?? '', ENT_XML1, 'UTF-8'));
                    $productNode->addChild('price', htmlspecialchars($product['price'] ?? '', ENT_XML1, 'UTF-8'));
                    $productNode->addChild('sku', htmlspecialchars($product['sku'] ?? '', ENT_XML1, 'UTF-8'));
                    $productNode->addChild('quantity', htmlspecialchars($product['quantity'] ?? '', ENT_XML1, 'UTF-8'));
                    $productNode->addChild('total_price', htmlspecialchars($product['total_price'] ?? '', ENT_XML1, 'UTF-8'));
                }
            }
        }
        $filename = 'orders.xml';
        $xml->asXML($oldFilePath);

        $this->info('Orders exported to XML successfully.');

    }
    private function getOrderStatusText($statusId)
    {
        switch ($statusId) {
            case 1:
                return 'Новый';
            case 2:
                return 'В процессе';
            case 3:
                return 'Оплачен';
            default:
                return 'Неизвестен';  // На случай, если статус не распознан
        }
    }
}

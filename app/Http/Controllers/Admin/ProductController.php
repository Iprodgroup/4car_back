<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product\Order;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function showAllProducts()
    {
        $products = Product::query()->paginate(15);
        return view('admin.products.index', compact('products'));
    }
    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sku' => 'required|unique:products',
            'name' => 'required',
            'vidy_nomenklaturi' => 'required',
            'brendy' => 'required',
            'run_flat' => 'boolean',
            'weight' => 'required|numeric',
            'modeli' => 'required',
            'sezony' => 'required',
            'shipy' => 'required',
            'vysota_shin' => 'required|numeric',
            'diametr_shin' => 'required|numeric',
            'indeks_nagruzki' => 'required',
            'indeks_skorosti' => 'required',
            'shirina_shin' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($request->hasFile('images')) {
           $imagePath = $request->file('images')->store('products', 'public');
           $validatedData['images'] = $imagePath;
        }

        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validatedData = $request->validate([
            'sku' => 'required|unique:products,sku,' . $product->id,
            'name' => 'required',
            'vidy_nomenklaturi' => 'required',
            'brendy' => 'required',
            'run_flat' => 'boolean',
            'weight' => 'required|numeric',
            'modeli' => 'required',
            'sezony' => 'required',
            'shipy' => 'required',
            'vysota_shin' => 'required|numeric',
            'diametr_shin' => 'required|numeric',
            'indeks_nagruzki' => 'required',
            'indeks_skorosti' => 'required',
            'shirina_shin' => 'required|numeric',
            'image' => 'image|mimes:jpeg,jpg,png'
        ]);
        if ($request->hasFile('image')) {
            // Удаляем старую фотографию, если она существует
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $imagePath;
        }


        $product->update($validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function showUploadForm()
    {
        return view('admin.products.form');
    }
    public function handleUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xml|max:30000',
        ]);

        Log::info('Файл загружен: ' . $request->file('file')->getClientOriginalName());

        $path = $request->file('file')->store('uploads/xml', 'public');
        Log::info("Файл успешно сохранен в: " . $path);

        $fullPath = Storage::disk('public')->path($path);
        if (!file_exists($fullPath)) {
            Log::error("Файл не найден по пути: " . $fullPath);
            return redirect()->back()->with('error', 'Ошибка загрузки файла.');
        }

        Log::info('Начало обработки файла: ' . $fullPath);

        $this->processXmlFile($fullPath);

        return redirect()->back()->with('success', 'XML файл успешно загружен и обработан.');

    }
    private function processXmlFile($filePath)
    {
        $xml = simplexml_load_file($filePath);
        if ($xml === false) {
            Log::error("Ошибка загрузки XML файла: $filePath");
            foreach (libxml_get_errors() as $error) {
                Log::error($error->message);
            }
            return;
        }

        Log::info("XML файл успешно загружен: " . $filePath);

        if (isset($xml->shop)) {
            Log::info("Обрабатываем элемент <shop>");

            // Проверяем наличие секции с продуктами
            if (isset($xml->shop->products)) {
                Log::info("Количество продуктов: " . count($xml->shop->products->product));

                // Обрабатываем каждый продукт
                foreach ($xml->shop->products->product as $product) {
                    Log::info("Обрабатываем продукт SKU: " . $product['sku']);
                    $this->saveToDatabase($product, 'product');
                }
            }

            // Проверяем наличие секции с предложениями (если она есть)
            if (isset($xml->shop->offers)) {
                Log::info("Количество предложений: " . count($xml->shop->offers->offer));

                // Обрабатываем каждое предложение
                foreach ($xml->shop->offers->offer as $offer) {
                    Log::info("Обрабатываем предложение SKU: " . $offer['sku']);
                    $this->saveToDatabase($offer, 'offer');
                }
            }
        } else {
            Log::warning("Неизвестная структура XML. Ожидается <shop> как корневой элемент.");
        }
    }

    private function saveToDatabase($item, $type)
    {
        ini_set('max_execution_time', 1000);
        try {
            if ($type === 'product') {
                $data = [
                    'sku' => (string)$item['sku'],
                    'name' => (string)$item->name,
                    'vidy_nomenklaturi' => (string)$item->category ?? null,
                    'brendy' => (string)$item->vendor ?? null,
                    'publish_in_kaspi' => filter_var((string)$item->PublishInKaspi, FILTER_VALIDATE_BOOLEAN),
                    'run_flat' => filter_var((string)$item->RunFlat, FILTER_VALIDATE_BOOLEAN),
                    'weight' => (int)$item->weight ?? null,
                    'modeli' => (string)$item->model ?? null,
                    'sezony' => (int)$item->season ?? null,
                    'shipy' => filter_var((string)$item->spikes, FILTER_VALIDATE_BOOLEAN),
                    'vysota_shin' => (int)$item->height ?? null,
                    'diametr_shin' => (int)$item->diameter ?? null,
                    'indeks_nagruzki' => (string)$item->{'load-index'} ?? null,
                    'indeks_skorosti' => (string)$item->{'speed-index'} ?? null,
                    'shirina_shin' => (string)$item->width ?? null,
                ];

                Product::updateOrCreate(
                    ['sku' => $data['sku']],
                    array_filter($data, function($value) {
                        return $value !== null;
                    })
                );

            } elseif ($type === 'offer') {
                $data = [
                    'sku' => (string)$item['sku'],
                    'name' => (string)$item->name,
                    'brendy' => (string)$item->vendor ?? null,
                    'stock_quantity' => (int)$item->quantity ?? 0,
                    'price' => (float)$item->price ?? null,
                ];

                Product::updateOrCreate(
                    ['sku' => $data['sku']],
                    array_filter($data, function($value) {
                        return $value !== null;
                    })
                );
            }

            Log::info("Продукт с SKU {$data['sku']} успешно сохранен/обновлен.");
        } catch (\Exception $e) {
            Log::error("Ошибка при сохранении данных продукта с SKU {$item['sku']}: " . $e->getMessage());
        }
    }
    public function exportProductsWithOrders()
    {
        $products = Product::all();
        $orders = Order::all();

        $xml = new \SimpleXMLElement('<shop/>');

        $productsNode = $xml->addChild('products');
        foreach ($products as $product) {
            $productNode = $productsNode->addChild('product');
            $productNode->addAttribute('sku', htmlspecialchars($product->sku, ENT_XML1, 'UTF-8'));
            $productNode->addChild('name', htmlspecialchars($product->name, ENT_XML1, 'UTF-8'));
            $productNode->addChild('category', htmlspecialchars($product->vidy_nomenklaturi, ENT_XML1, 'UTF-8'));
            $productNode->addChild('vendor', htmlspecialchars($product->brendy, ENT_XML1, 'UTF-8'));
            $productNode->addChild('PublishInKaspi', $product->publish_in_kaspi ? 'true' : 'false');
            $productNode->addChild('RunFlat', $product->run_flat ? 'true' : 'false');
            $productNode->addChild('height', $product->vysota_shin);
            $productNode->addChild('diameter', $product->diametr_shin);
            $productNode->addChild('load-index', $product->indeks_nagruzki);
            $productNode->addChild('speed-index', $product->indeks_skorosti);
            $productNode->addChild('weight', $product->weight);
            $productNode->addChild('model', htmlspecialchars($product->modeli, ENT_XML1, 'UTF-8'));
            $productNode->addChild('season', $product->sezony);
            $productNode->addChild('spikes', $product->shipy ? 'true' : 'false');
            $productNode->addChild('width', $product->shirina_shin);
        }

        $ordersNode = $xml->addChild('orders');
        foreach ($orders as $order) {
            $orderNode = $ordersNode->addChild('order');
            $orderNode->addAttribute('id', htmlspecialchars($order->id, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('name', htmlspecialchars($order->name, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('delivery_method', htmlspecialchars($order->delivery_method, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('adres', htmlspecialchars($order->adres, ENT_XML1, 'UTF-8'));
            $orderNode->addChild('payment_method', htmlspecialchars($order->payment_method, ENT_XML1, 'UTF-8'));
        }

        $filename = 'products_with_orders.xml';
        $xml->asXML(public_path($filename));

        return response()->download(public_path($filename));
    }

    public function exportProducts()
    {
        $products = Product::all();

        $xml = new \SimpleXMLElement('<shop/>');

        $productsNode = $xml->addChild('products');
        foreach ($products as $product) {
            $productNode = $productsNode->addChild('product');
            $productNode->addAttribute('sku', htmlspecialchars($product->sku, ENT_XML1, 'UTF-8'));
            $productNode->addChild('name', htmlspecialchars($product->name, ENT_XML1, 'UTF-8'));
            $productNode->addChild('category', htmlspecialchars($product->vidy_nomenklaturi, ENT_XML1, 'UTF-8'));
            $productNode->addChild('vendor', htmlspecialchars($product->brendy, ENT_XML1, 'UTF-8'));
            // Добавьте другие поля по необходимости
        }

        $filename = 'products.xml';
        $xml->asXML(public_path($filename));

        return response()->download(public_path($filename));
    }

}

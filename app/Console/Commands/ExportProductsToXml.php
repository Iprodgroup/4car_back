<?php

namespace App\Console\Commands;

use App\Models\Product\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportProductsToXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:products-to-xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export products data to XML and save to storage/app/ftp';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Product::all();

        $xml = new \SimpleXMLElement('<products/>');

        foreach ($products as $product) {
            $productNode = $xml->addChild('product');
            $productNode->addAttribute('sku', $product->sku);
            $productNode->addChild('name', htmlspecialchars($product->name));
            $productNode->addChild('category', htmlspecialchars($product->vidy_nomenklaturi));
            $productNode->addChild('vendor', htmlspecialchars($product->brendy));
            $productNode->addChild('PublishInKaspi', $product->publish_in_kaspi ? 'true' : 'false');
            $productNode->addChild('RunFlat', $product->run_flat ? 'true' : 'false');
            $productNode->addChild('height', $product->vysota_shin);
            $productNode->addChild('diameter', $product->diametr_shin);
            $productNode->addChild('load-index', $product->indeks_nagruzki);
            $productNode->addChild('speed-index', $product->indeks_skorosti);
            $productNode->addChild('weight', $product->weight);
            $productNode->addChild('model', htmlspecialchars($product->modeli));
            $productNode->addChild('season', $product->sezony);
            $productNode->addChild('spikes', $product->shipy ? 'true' : 'false');
            $productNode->addChild('width', $product->shirina_shin);
        }

        $filePath = 'ftp/products_' . date('Y-m-d_H-i-s') . '.xml';

        Storage::put($filePath, $xml->asXML());
        $this->info('Products data exported to XML and saved to ' . $filePath);
        return 0;
    }
}

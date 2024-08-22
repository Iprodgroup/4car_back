<?php

namespace App\Traits;

use App\Models\Product\Product;

trait SlugTrait
{
    public function generateSlug(string $name)
    {
        $transliterationTable = $this->transliterate();
        $name = strtr($name, $transliterationTable);
        $slug = str_replace(['&', '/', ',', ' ', '.', '(', ')'], ['and', '-', '-', '-', '-', '-', '-'], $name);
        $slug = preg_replace('/[^a-zA-Z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = strtolower($slug);
        return $slug;
    }

    protected function getLowerSlug($slug): string
    {
        $slug = $this->generateSlug($slug);
        $skuPart = substr(strrchr($slug, '-p'), 2);
        $namePart = str_replace('-p' . $skuPart, '', $slug);

        $product = Product::where('name', 'LIKE', "%$namePart%")
            ->where('sku', $skuPart)
            ->firstOrFail();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return $product;
    }

    protected function transliterate(): array
    {
        return [
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo',
            'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M',
            'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch', 'Ь' => '',
            'Ы' => 'Y', 'Ъ' => '', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            //small words
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm',
            'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ь' => '',
            'ы' => 'y', 'ъ' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
        ];
    }
}

<?php

namespace Database\Factories;

use Database\Factories\MunicipalityFactory;
use Dmn\PhAddress\Models\Barangay;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangayFactory extends Factory
{
    protected $model = Barangay::class;

    /**
     * @inheritDoc
     */
    public function definition()
    {
        $factory = new MunicipalityFactory();
        $municipality = $factory->create();
        return [
            'name' => $this->faker->city,
            'code' => $this->faker->lexify('?????????'),
            'region_code' => $municipality->region_code,
            'province_code' => $municipality->province_code,
            'municipality_code' => $municipality->code,
            'zip_code' => $this->faker->lexify('????'),
        ];
    }
}

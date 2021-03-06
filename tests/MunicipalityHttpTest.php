<?php

use Database\Factories\BarangayFactory;
use Database\Factories\MunicipalityFactory;
use Database\Factories\ProvinceFactory;
use Dmn\PhAddress\Models\Barangay;
use Dmn\PhAddress\Models\Municipality;

class MunicipalityHttpTest extends TestCase
{
    /**
     * @test
     * @testdox Municipality list
     *
     * @return void
     */
    public function listMunicipality(): void
    {
        $factory = new MunicipalityFactory();
        $factory->count(10)->create();
        $this->get('municipality');

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(10, count($response['data']));
    }

    /**
     * @test
     * @testdox Municipality list per page
     *
     * @return void
     */
    public function listMunicipalityPerPage(): void
    {
        $factory = new MunicipalityFactory();
        $factory->count(10)->create();
        $this->get('municipality?per_page=2');

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(2, count($response['data']));
    }

    /**
     * @test
     * @testdox Filter municipalities
     *
     * @return void
     */
    public function filterMunicipality(): void
    {
        $factory = new MunicipalityFactory();
        $factory->count(10)->create();
        $municipality = Municipality::first();
        $this->get('municipality?q=' . $municipality->name);

        $response = $this->response->json();
        $this->assertResponseOk();
        $this->assertEquals(1, count($response['data']));
    }

    /**
     * @test
     * @testdox Municipalities under a province
     *
     * @return void
     */
    public function municipalitiesInProvince(): void
    {
        $municipalityFactory = new MunicipalityFactory();
        $factory = new BarangayFactory();
        $municipality = $municipalityFactory->create();
        $factory->count(10)->create(['municipality_code' => $municipality->code]);

        $this->get('municipality/' . $municipality->code . '/barangay');
        $this->assertResponseOk();

        $response = $this->response->json();
        $this->assertEquals(10, count($response['data']));
    }

    /**
     * @test
     * @testdox Provinces under a region filter
     *
     * @return void
     */
    public function filterMunicipalitiesInProvince(): void
    {
        $municipalityFactory = new MunicipalityFactory();
        $factory = new BarangayFactory();
        $municipality = $municipalityFactory->create();
        $factory->count(10)->create(['municipality_code' => $municipality->code]);

        $barangay = Barangay::first();

        $this->get('municipality/' . $municipality->code . '/barangay?q=' . $barangay->name);
        $this->assertResponseOk();

        $response = $this->response->json();
        $this->assertEquals(1, count($response['data']));
    }

    /**
     * @test
     * @testdox Municipalities by area code
     *
     * @return void
     */
    public function filterMunicipalitiesByAreaCode(): void
    {
        $provinceFactory = new ProvinceFactory();
        $factory = new MunicipalityFactory();
        $province = $provinceFactory->create();

        $str = \Illuminate\Support\Str::random(6);
        $factory->count(10)->create(
            [
                'province_code' => $province->code,
                'area_code' => $str
            ]
        );

        $this->get('/area-code?q=' . $str);
        $this->assertResponseOk();

        $response = $this->response->json();
        $this->assertEquals(10, count($response['data']));
    }
}

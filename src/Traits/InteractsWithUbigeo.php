<?php

namespace LaravelPeru\Ubigeo\Traits;

use Illuminate\Support\Collection;
use LaravelPeru\Ubigeo\Models\Ubigeo;

trait InteractsWithUbigeo
{
    public function getDepartament(?string $name = null): Collection
    {
        $query = Ubigeo::query()
            ->select(['code', 'department as name'])
            ->where('code', 'like', '__0000');

        if ($name !== null && $name !== '') {
            $query->where('department', 'like', '%' . $name . '%');
        }

        return $query
            ->orderBy('department')
            ->get();
    }

    public function getDepartment(?string $name = null): Collection
    {
        return $this->getDepartament($name);
    }

    public function getProvice(string $code, ?string $name = null): Collection
    {
        $departmentPrefix = $this->getDepartmentPrefix($code);

        if ($departmentPrefix === null) {
            return collect();
        }

        $query = Ubigeo::query()
            ->select(['code', 'province as name', 'department'])
            ->where('code', 'like', $departmentPrefix . '__00')
            ->where('code', 'not like', $departmentPrefix . '0000');

        if ($name !== null && $name !== '') {
            $query->where('province', 'like', '%' . $name . '%');
        }

        return $query
            ->orderBy('province')
            ->get();
    }

    public function getProvince(string $code, ?string $name = null): Collection
    {
        return $this->getProvice($code, $name);
    }

    public function getDistrict(string $code, ?string $name = null): Collection
    {
        $provincePrefix = $this->getProvincePrefix($code);

        if ($provincePrefix === null) {
            return collect();
        }

        $query = Ubigeo::query()
            ->select(['id', 'district as name', 'province', 'department'])
            ->where('code', 'like', $provincePrefix . '__')
            ->where('code', 'not like', $provincePrefix . '00');

        if ($name !== null && $name !== '') {
            $query->where('district', 'like', '%' . $name . '%');
        }

        return $query
            ->orderBy('district')
            ->get();
    }

    protected function getDepartmentPrefix(string $code): ?string
    {
        $normalized = $this->normalizeCode($code);
        $prefix = substr($normalized, 0, 2);

        return strlen($prefix) === 2 ? $prefix : null;
    }

    protected function getProvincePrefix(string $code): ?string
    {
        $normalized = $this->normalizeCode($code);
        $prefix = substr($normalized, 0, 4);

        return strlen($prefix) === 4 ? $prefix : null;
    }

    protected function normalizeCode(string $code): string
    {
        return preg_replace('/\D+/', '', $code) ?? '';
    }
}

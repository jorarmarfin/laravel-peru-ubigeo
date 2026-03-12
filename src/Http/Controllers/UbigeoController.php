<?php

namespace LaravelPeru\Ubigeo\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelPeru\Ubigeo\Models\Ubigeo;
use LaravelPeru\Ubigeo\Traits\InteractsWithUbigeo;

class UbigeoController extends Controller
{
    use InteractsWithUbigeo;

    public function search(Request $request): JsonResponse
    {
        $code = trim((string) $request->query('code', ''));
        $name = trim((string) $request->query('name', ''));

        if ($code !== '') {
            $normalizedCode = $this->normalizeCode($code);

            if (strlen($normalizedCode) !== 6) {
                return response()->json([
                    'message' => 'The code must have exactly 6 digits.',
                ], 422);
            }

            return $this->searchByCode($normalizedCode, $name);
        }

        if ($name === '') {
            return response()->json([
                'message' => 'At least one filter is required: code or name.',
            ], 422);
        }

        return response()->json([
            'type' => 'mixed',
            'data' => [
                'departments' => $this->getDepartament($name)->values(),
                'provinces' => $this->searchProvincesByName($name)->values(),
                'districts' => $this->searchDistrictsByName($name)->values(),
            ],
        ]);
    }

    public function departments(Request $request): JsonResponse
    {
        $name = trim((string) $request->query('name', ''));

        return response()->json([
            'type' => 'department',
            'data' => $this->getDepartament($name !== '' ? $name : null)->values(),
        ]);
    }

    public function provinces(Request $request, string $code): JsonResponse
    {
        $name = trim((string) $request->query('name', ''));

        return response()->json([
            'type' => 'province',
            'data' => $this->getProvice($code, $name !== '' ? $name : null)->values(),
        ]);
    }

    public function districts(Request $request, string $code): JsonResponse
    {
        $name = trim((string) $request->query('name', ''));

        return response()->json([
            'type' => 'district',
            'data' => $this->getDistrict($code, $name !== '' ? $name : null)->values(),
        ]);
    }

    protected function searchByCode(string $code, string $name = ''): JsonResponse
    {
        if ($this->isDepartmentCode($code)) {
            $department = $this->getDepartament($name !== '' ? $name : null)
                ->where('code', $code)
                ->values();

            return response()->json([
                'type' => 'department',
                'data' => $department,
            ]);
        }

        if ($this->isProvinceCode($code)) {
            $province = $this->getProvice($code, $name !== '' ? $name : null)
                ->where('code', $code)
                ->values();

            return response()->json([
                'type' => 'province',
                'data' => $province,
            ]);
        }

        $district = Ubigeo::query()
            ->select(['id', 'district as name', 'province', 'department'])
            ->where('code', $code)
            ->when($name !== '', function ($query) use ($name): void {
                $query->where('district', 'like', '%' . $name . '%');
            })
            ->get()
            ->values();

        return response()->json([
            'type' => 'district',
            'data' => $district,
        ]);
    }

    protected function searchProvincesByName(string $name)
    {
        return Ubigeo::query()
            ->select(['code', 'province as name', 'department'])
            ->where('code', 'like', '____00')
            ->where('code', 'not like', '__0000')
            ->where('province', 'like', '%' . $name . '%')
            ->orderBy('province')
            ->get();
    }

    protected function searchDistrictsByName(string $name)
    {
        return Ubigeo::query()
            ->select(['id', 'district as name', 'province', 'department'])
            ->where('code', 'not like', '____00')
            ->where('district', 'like', '%' . $name . '%')
            ->orderBy('district')
            ->get();
    }

    protected function isDepartmentCode(string $code): bool
    {
        return str_ends_with($code, '0000');
    }

    protected function isProvinceCode(string $code): bool
    {
        return str_ends_with($code, '00') && !$this->isDepartmentCode($code);
    }
}

<?php

namespace App\Helpers;

use Carbon\Carbon;

class FilterHelper
{
    public static function hitungSemesterSekarang($tanggalMasuk)
    {
        $tanggalMasuk = Carbon::parse($tanggalMasuk);
        $now = Carbon::now();
        $diffInMonths = $tanggalMasuk->diffInMonths($now);
        return (int) ceil($diffInMonths / 6);
    }

    public static function getTahunAjaranList($tanggalMasuk)
    {
        $tahunMasuk = Carbon::parse($tanggalMasuk)->year;
        $semesterSekarang = self::hitungSemesterSekarang($tanggalMasuk);
        $jumlahTahunAjaran = ceil($semesterSekarang / 2);

        $list = [];
        for ($i = 0; $i < $jumlahTahunAjaran; $i++) {
            $awal = $tahunMasuk + $i;
            $akhir = $awal + 1;
            $list[] = "$awal/$akhir";
        }
        return $list;
    }

    public static function getSemesterOptions($tanggalMasuk)
    {
        $semesterSekarang = self::hitungSemesterSekarang($tanggalMasuk);

        $semesters = [];
        for ($i = 1; $i <= $semesterSekarang; $i++) {
            $semesters[] = [
                'nomor' => $i,
                'label' => $i % 2 == 1 ? 'ganjil' : 'genap',
            ];
        }
        return $semesters;
    }
}
<?php

namespace App\Services;

class StaticValueService
{
    public static function regMediumId($key): int
    {
        $data = [
            'email' => 1,
            'facebook' => 2,
            'google' => 3,
            'mobile' => 4,
        ];

        return $data[$key];
    }

    public static function userContactTypeId($key): int
    {
        $data = [
            'email' => 1,
            'mobile' => 2,
            'telephone' => 3,
        ];

        return $data[$key];
    }

    public static function companyStatusById($key): array
    {
        $data = [
            0 => ['id' => 0, 'title' => 'Pending'],
            1 => ['id' => 1, 'title' => 'Active'],
            2 => ['id' => 2, 'title' => 'Inactive'],
        ];

        return $data[$key];
    }

    public static function userStatusById($key): array
    {
        $data = [
            0 => ['id' => 0, 'title' => 'Inactive'],
            1 => ['id' => 1, 'title' => 'Active'],
            2 => ['id' => 2, 'title' => 'Blocked'],
        ];

        return $data[$key];
    }

    public static function postStatusById($key): array
    {
        $data = [
            0 => ['id' => 0, 'title' => 'Draft'],
            1 => ['id' => 1, 'title' => 'Pending'],
            2 => ['id' => 2, 'title' => 'Published'],
            3 => ['id' => 3, 'title' => 'Archived'],
        ];

        return $data[$key];
    }

    public static function userTypeById($key)
    {
        $data = [
            1 => ['id' => 1, 'title' => 'Super Admin'],
            2 => ['id' => 2, 'title' => 'Employee'],
            3 => ['id' => 3, 'title' => 'Employer'],
            4 => ['id' => 4, 'title' => 'Admin'],
        ];

        return @$data[$key];
    }

    public static function userTypeIdByKey($key): int
    {
        $data = [
            'super_admin' => 1,
            'employee' => 2,
            'employer' => 3,
            'admin' => 4
        ];

        return $data[$key];
    }

    public static function regMediumById($key): array
    {
        $data = [
            1 => ['id' => 1, 'title' => 'email'],
            2 => ['id' => 2, 'title' => 'facebook'],
            3 => ['id' => 3, 'title' => 'google'],
            4 => ['id' => 4, 'title' => 'mobile'],
        ];

        return $data[$key];
    }

    public static function relationTypeById($key): array
    {
        $data = [
            1 => ['id' => 1, 'title' => 'Relative'],
            2 => ['id' => 2, 'title' => 'Family Friend'],
            3 => ['id' => 3, 'title' => 'Academic'],
            4 => ['id' => 4, 'title' => 'Professional'],
            5 => ['id' => 4, 'title' => 'Others'],
        ];

        return $data[$key];
    }

    public static function userCriteriaKeyById($key): string
    {
        $data = [
            1 => 'age',
            2 => 'job_location',
            3 => 'total_exp',
            4 => 'salary',
            5 => 'gender',
            6 => 'area_of_business',
            7 => 'area_of_exp',
            8 => 'job_level',
            9 => 'skills',
        ];

        return $data[$key];
    }

    public static function jobTypeById($key): array
    {
        $data = [
            1 => ['id' => 1, 'title' => 'Regular Job'],
            2 => ['id' => 2, 'title' => 'Special Skilled Job'],
        ];

        return $data[$key];
    }

    public static function langProficiencySkillById($key): array
    {
        $data = [
            1 => ['id' => 1, 'title' => 'High'],
            2 => ['id' => 2, 'title' => 'Medium'],
            3 => ['id' => 3, 'title' => 'Low'],
        ];

        return @$data[$key];
    }

    public static function blogStatusById($key): array
    {
        $data = [
            0 => ['id' => 0, 'title' => 'Pending'],
            1 => ['id' => 1, 'title' => 'Active'],
            2 => ['id' => 2, 'title' => 'Inactive'],
        ];

        return $data[$key];
    }

    public static function adsStatusById($key): array
    {
        $data = [
            0 => ['id' => 0, 'title' => 'Inactive'],
            1 => ['id' => 1, 'title' => 'Active'],
        ];

        return $data[$key];
    }

    public static function subscriptionStatusById($key): array
    {
        $data = [
            0 => ['id' => 0, 'title' => 'Pending'],
            1 => ['id' => 1, 'title' => 'Active'],
            2 => ['id' => 2, 'title' => 'Cancelled'],
        ];

        return $data[$key];
    }
}

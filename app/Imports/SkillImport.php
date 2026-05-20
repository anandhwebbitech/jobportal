<?php

namespace App\Imports;

use App\Models\Skill;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class SkillImport implements ToModel, WithHeadingRow
{
    /**
     * Excel Heading Format:
     *
     * skill_name | description | status
     */

    public function model(array $row)
    {
        // Skip empty rows
        if (
            empty($row['skill_name']) &&
            empty($row['description']) &&
            empty($row['status'])
        ) {
            return null;
        }

        // Prevent duplicate skills
        $exists = Skill::where(
            'skill_name',
            trim($row['skill_name'])
        )->exists();

        if ($exists) {
            return null;
        }

        return new Skill([
            'skill_name' => trim($row['skill_name']),
            'description' => $row['description'] ?? null,
            'status'      => isset($row['status'])
                                ? (int) $row['status']
                                : 1,
        ]);
    }
}
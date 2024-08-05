<?php

namespace App\Repositories;

use App\Interfaces\AcademicProgramRepositoryInterface;
use App\Models\AcademicProgram;

class AcademicProgramRepository implements AcademicProgramRepositoryInterface
{
    public function getAll()
    {
        return AcademicProgram::all();
    }

    public function getById($id)
    {
        return AcademicProgram::findOrFail($id);
    }

    public function store(array $data)
    {
        return AcademicProgram::create($data);
    }

    public function update($id, array $data)
    {
        AcademicProgram::find($id)->update($data);
    }

    public function delete($id)
    {
        AcademicProgram::destroy($id);
    }
}

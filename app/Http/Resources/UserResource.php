<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->role != 2){
            $campus = [
                'id' => $this->campus->id,
                'name' => $this->campus->town->name,
            ];

            if($this->role == 0){
                $academicProgram = [
                    'id' => $this->program->id,
                    'name' => $this->program->name,
                ];
            }else{
                $academicProgram = '';
            }
        }else{
            $campus = '';
            $academicProgram = '';
        }

        return [
            'id' => $this->id,
            'name' => $this->name . ' ' . $this->lastname,
            'email' => $this->email,
            'role' => $this->role,
            'campus' => $campus,
            'academic_program' => $academicProgram,
            
        ];
    }
}

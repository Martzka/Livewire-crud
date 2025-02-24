<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployeee;
use Livewire\Component;

class Employee extends Component
{
    public $nama;
    public $email;
    public $alamat;

    public function store()
    {
        $rules = [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
        ];
        $pesan = [
            'nama.required' => 'Nama wajib di isi',
            'email.required' => 'Email wajib di isi',
            'email.email' => 'Format email tidak sesuai',
            'alamat.required' => 'Alamat wajib di isi',
        ];
        $validated = $this->validate($rules, $pesan);
        ModelsEmployeee::create($validated);
        session()->flash('message', 'Data Berhasil Dimasukkan');
    }

    public function render()
    {
        return view('livewire.employee');
    }
}

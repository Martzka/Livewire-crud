<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployeee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap'; 
    
    public $nama;
    public $email;
    public $alamat;
    public $updateData = false;
    public $employee_id;
    public $katakunci;
    public $employee_selected_id = [];

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

        $this->clear();
    }

    public function edit($id)
    {
        $data = ModelsEmployeee::find($id);
        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->alamat = $data->alamat;

        $this->updateData = true;
        $this->employee_id = $id;
    }

    public function update()
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
        $data = ModelsEmployeee::find($this->employee_id);
        $data->update($validated);
        session()->flash('message', 'Data Berhasil di-update');

        $this->clear();
    }

    public function clear()
    {
        $this->nama = '';
        $this->email = '';
        $this->alamat = '';

        $this->updateData = false;
        $this->employee_id = '';
        $this->employee_selected_id = [];
    }

    
    public function delete()
    {  
        if ($this->employee_id != '') {
            
            $id = $this->employee_id;
            ModelsEmployeee::find($id)->delete();
        }
    
        if (!empty($this->employee_selected_id)) {
            
            foreach ($this->employee_selected_id as $employeeId) {
                ModelsEmployeee::find($employeeId)->delete();
            }
        }
    
        
        session()->flash('message', 'Data berhasil di-delete');
    
        
        $this->clear();
    }
    

    public function delete_confirmation($id)
    {
        
        if ($id != '') {
        $this->employee_id = $id;
        }
    }

        

    public function render()
{
    if($this->katakunci != null) {
        $data = ModelsEmployeee::where('nama', 'like', '%'.$this->katakunci. '%')
        ->orWhere('email', 'like', '%' .$this->katakunci . '%')
        ->orWhere('alamat', 'like', '%' .$this->katakunci . '%')
                               ->orderBy('nama', 'asc')
                               ->paginate(2);
    } else {
        $data = ModelsEmployeee::orderBy('nama', 'asc')->paginate(2);
    }
    
    return view('livewire.employee', ['dataEmployees' => $data]);
}

}
